<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends BaseController
{
    protected $db;
    protected $userTable; // 'user' atau 'users' (fallback otomatis)

    public function __construct()
    {
        helper(['form', 'url']);
        $this->db = \Config\Database::connect();
        $this->userTable = $this->db->tableExists('users') ? 'users' : 'user';
    }

    /** Guard login sederhana */
    private function requireLogin()
    {
        // Sesuaikan dengan session yang kamu set waktu login
        $auth = session()->get('auth') ?? [];
        if (! ($auth['username'] ?? null)) {
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    /** Ambil user aktif dari DB berdasarkan session */
    private function currentUser(): array
    {
        $auth = session()->get('auth') ?? [];
        $username = $auth['username'] ?? null;
        if (! $username) return [];

        $res = $this->db->table($this->userTable)->getWhere(['username' => $username], 1);
        return is_object($res) ? ($res->getRowArray() ?: []) : [];
    }

    /**
     * GET/POST /user/profile
     * - Tampilkan form profile
     * - Proses update nama, foto, & password (opsional)
     */
    public function profile()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();
        if (! $user) {
            return redirect()->to(site_url('login'))->with('error', 'Sesi berakhir, silakan login ulang.');
        }

        // Jika GET -> render form
        if ($this->request->getMethod() !== 'post') {
            $data = [
                'title' => 'Profile | Posyandu Sakura',
                'user'  => $user,
            ];
            return view('templates/header-form', $data)
                . view('templates/sidebar')
                . view('templates/topbar', $data)
                . view('user/profile', $data)
                . view('templates/footer-form');
        }

        // === POST: Validasi & Update ===
        $rules = [
            'name' => 'required|trim',
            // password opsional; panjang minimal jika diisi
            'current-password' => 'permit_empty',
            'new-password'     => 'permit_empty|min_length[6]',
            'repeat-password'  => 'matches[new-password]',
            'image'            => 'permit_empty|uploaded[image]|is_image[image]|max_size[image,2048]',
        ];

        // NOTE: untuk image tidak selalu diupload, jadi kita override rule upload jika file kosong
        $file = $this->request->getFile('image');
        if (!($file && $file->isValid() && !$file->hasMoved())) {
            unset($rules['image']);
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name           = trim((string) $this->request->getPost('name'));
        $username       = (string) $user['username']; // pakai dari DB
        $currPassword   = (string) $this->request->getPost('current-password');
        $newPassword    = (string) $this->request->getPost('new-password');
        $repeatPassword = (string) $this->request->getPost('repeat-password');

        // Siapkan payload update
        $payload = ['name' => $name];

        // === Upload foto jika ada ===
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'img/profile';
            if (! is_dir($uploadPath)) {
                @mkdir($uploadPath, 0775, true);
            }

            $newName = $file->getRandomName();
            if (! $file->move($uploadPath, $newName)) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
            }

            // Hapus gambar lama jika bukan default
            $oldImage = $user['image'] ?? 'icon-user.png';
            if ($oldImage && $oldImage !== 'icon-user.png' && is_file($uploadPath . '/' . $oldImage)) {
                @unlink($uploadPath . '/' . $oldImage);
            }

            $payload['image'] = $newName;
        }

        // === Update password (opsional) ===
        if ($currPassword !== '') {
            $stored = (string) ($user['password'] ?? '');

            // Dukung 2 mode: hash (password_hash) atau plaintext lama
            $okPass = password_verify($currPassword, $stored) || ($stored !== '' && $currPassword === $stored);
            if (! $okPass) {
                return redirect()->back()->withInput()->with('error', 'Current Password salah!');
            }

            if ($currPassword === $newPassword) {
                return redirect()->back()->withInput()->with('error', 'New Password tidak boleh sama dengan Current Password.');
            }

            if ($newPassword === '') {
                return redirect()->back()->withInput()->with('error', 'New Password tidak boleh kosong.');
            }

            // REKOMENDASI: gunakan hash. Jika kamu ingin tetap plaintext, ganti baris di bawah.
            $payload['password'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        // Eksekusi update
        $ok = $this->db->table($this->userTable)
            ->where('username', $username)
            ->update($payload);

        if (! $ok) {
            $err = $this->db->error();
            return redirect()->back()->withInput()->with('error', $err['message'] ?? 'Gagal menyimpan profil.');
        }

        return redirect()->to(site_url('user/profile'))->with('msg', 'Data telah diubah');
    }

    /** GET /user/tambah  -> form tambah user */
    public function tambahUser()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $data = [
            'title' => 'Tambah User | Posyandu Sakura',
            'user'  => $this->currentUser(),
            // Jika butuh list level, ambil dari tabel users_level kalau tersedia
            'levels' => $this->db->table('users_level')->get()->getResultArray() ?: [],
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('user/tambah', $data)
            . view('templates/footer-datatables');
    }

    /** POST /user/tambah -> proses tambah user */
    public function tambahUserInput()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $rules = [
            'username' => 'required|alpha_numeric_punct|min_length[3]|is_unique[' . $this->userTable . '.username]',
            'name'     => 'required|trim',
            'password' => 'required|min_length[6]',
            'level_id' => 'required|integer',
            'image'    => 'permit_empty|uploaded[image]|is_image[image]|max_size[image,2048]',
        ];

        $file = $this->request->getFile('image');
        if (!($file && $file->isValid() && !$file->hasMoved())) {
            unset($rules['image']);
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $uploadFileName = 'icon-user.png';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadPath = FCPATH . 'img/profile';
            if (! is_dir($uploadPath)) {
                @mkdir($uploadPath, 0775, true);
            }
            $uploadFileName = $file->getRandomName();
            if (! $file->move($uploadPath, $uploadFileName)) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengunggah gambar.');
            }
        }

        $payload = [
            'username'    => $this->request->getPost('username'),
            'name'        => $this->request->getPost('name'),
            'image'       => $uploadFileName,
            // REKOMENDASI: simpan hash
            'password'    => password_hash((string) $this->request->getPost('password'), PASSWORD_BCRYPT),
            'level_id'    => (int) $this->request->getPost('level_id'),
            'is_active'   => 1,
            'date_created' => time(), // jika kolom ini ada. Jika tidak ada, hapus.
        ];

        $ok = $this->db->table($this->userTable)->insert($payload);
        if (! $ok) {
            $err = $this->db->error();
            return redirect()->back()->withInput()->with('error', $err['message'] ?? 'Gagal menambah user.');
        }

        return redirect()->to(site_url('user/tambahUser'))->with('msg', 'Berhasil Ditambahkan');
    }
}
