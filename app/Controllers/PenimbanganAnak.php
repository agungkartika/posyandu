<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\PenimbanganModel;
use CodeIgniter\HTTP\ResponseInterface;

class PenimbanganAnak extends BaseController
{
    protected $timbangan;
    protected $anak;
    protected $db;

    public function __construct()
    {
        helper(['url']);
        $this->timbangan = new PenimbanganModel();
        $this->anak      = new AnakModel();
        $this->db        = \Config\Database::connect();
    }

    private function requireLogin()
    {
        if (! session()->get('auth.username')) {
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    private function currentUser(): array
    {
        $auth = session()->get('auth') ?? [];
        $username = $auth['username'] ?? null;
        if (! $username) return [];

        $row = [];
        if ($this->db->tableExists('users')) {
            $res = $this->db->table('users')->getWhere(['username' => $username], 1);
            $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
        }
        if (! $row && $this->db->tableExists('user')) {
            $res = $this->db->table('user')->getWhere(['username' => $username], 1);
            $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
        }

        // Normalisasi agar view aman
        $row['image']    = $row['image'] ?? 'default.png';
        $row['name']     = $row['name']  ?? ($row['username'] ?? 'Pengguna');
        $row['level_id'] = (int) ($row['level_id'] ?? (session('auth.level_id') ?? 0));

        return $row;
    }

    // === MENAMPILKAN FORM TAMBAH ===
    public function index()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();
        $data = [
            'title'  => 'Penimbangan Anak | Posyandu Mawar XIII',
            'user'   => $user,
            'd_anak' => $this->anak->getDataAnak(), // semua anak
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/penimbangan-form', $data)
            . view('templates/footer-datatables');
    }

    // === PROSES TAMBAH DATA ===
    public function submit()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        // --- VALIDASI MINIMAL ---
        $rules = [
            'id_anak'       => 'required|is_natural_no_zero',
            'jenis_kelamin' => 'required|in_list[Laki-Laki,Perempuan]',
            'usia'          => 'required|is_natural',
            'tb'            => 'required|decimal',
            'bb'            => 'required|decimal',
            'tgl_skrng'     => 'required',
            'kategori'      => 'required|string',
            'keterangan'    => 'permit_empty|string',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' | ', $this->validator->getErrors()));
        }

        // --- NORMALISASI TANGGAL (antisipasi input dd/mm/yyyy) ---
        $rawDate = (string) $this->request->getPost('tgl_skrng');
        $dateYmd = $rawDate;
        if (preg_match('~^\d{2}/\d{2}/\d{4}$~', $rawDate)) {
            // dd/mm/yyyy -> yyyy-mm-dd
            [$d, $m, $y] = explode('/', $rawDate);
            $dateYmd = sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
        }

        $payload = [
            'anak_id'       => (int) $this->request->getPost('id_anak'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'usia'          => (int) $this->request->getPost('usia'),
            'tb'            => (float) $this->request->getPost('tb'),
            'bb'            => (float) $this->request->getPost('bb'),
            'tgl_skrng'     => $dateYmd,                       // harus cocok tipe kolom (DATE/DATETIME)
            'kategori'    => $this->request->getPost('kategori') ?: null,
            'keterangan'           => $this->request->getPost('keterangan') ?: null,
            'created_by'    => $user['id_users'] ?? null,      // pastikan kolom nullable jika bisa null
        ];

        $ok = $this->timbangan->add($payload);

        if (! $ok) {
            $err = $this->timbangan->db->error(); // ['code','message']
            log_message('error', 'INSERT penimbangan gagal: {0} | payload: {1}', [
                json_encode($err),
                json_encode($payload)
            ]);
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menambahkan data: ' . ($err['message'] ?? 'Unknown DB error'));
        }

        return redirect()->to(site_url('penimbangan-anak/data'))
            ->with('success', 'Data berhasil ditambahkan');
    }

    // === TAMPILKAN SEMUA DATA ===
    public function data()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();
        $data = [
            'title' => 'Penimbangan Anak | Posyandu Mawar XIII',
            'user'  => $user,
            'row'   => $this->timbangan->getAllWithInfo(), // array
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/data_penimbangan', $data)
            . view('templates/footer-datatables');
    }

    // === TAMPILKAN FORM EDIT ===
    public function edit($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $id   = (int) $id;
        $user = $this->currentUser();

        $timbangan = $this->timbangan->getById($id);

        // ambil nama anak di controller (jangan query di view)
        $namaAnak = '';
        if ($timbangan && ! empty($timbangan['anak_id'])) {
            $rowAnak = $this->anak->getAnakById((int) $timbangan['anak_id']);
            $namaAnak = $rowAnak['nama_anak'] ?? '';
        }

        $data = [
            'title'     => 'Edit Penimbangan Anak',
            'user'      => $user,
            'd_anak'    => $this->anak->getDataAnak(),
            'timbangan' => $timbangan,
            'nama_anak' => $namaAnak,
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/edit_data', $data)
            . view('templates/footer-datatables');
    }

    // === PROSES UPDATE ===
    public function update($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $id   = (int) $id;
        $user = $this->currentUser();

        // --- VALIDASI MINIMAL ---
        $rules = [
            'id_anak'       => 'required|is_natural_no_zero',
            'jenis_kelamin' => 'required|in_list[Laki-Laki,Perempuan]',
            'usia'          => 'required|is_natural',
            'tb'            => 'required|decimal',
            'bb'            => 'required|decimal',
            'tgl_skrng'     => 'required',
            'kategori'      => 'required|string',
            'keterangan'    => 'permit_empty|string',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(' | ', $this->validator->getErrors()));
        }

        // --- NORMALISASI TANGGAL (antisipasi input dd/mm/yyyy) ---
        $rawDate = (string) $this->request->getPost('tgl_skrng');
        $dateYmd = $rawDate;
        if (preg_match('~^\d{2}/\d{2}/\d{4}$~', $rawDate)) {
            // dd/mm/yyyy -> yyyy-mm-dd
            [$d, $m, $y] = explode('/', $rawDate);
            $dateYmd = sprintf('%04d-%02d-%02d', (int)$y, (int)$m, (int)$d);
        }

        $payload = [
            'anak_id'       => (int) $this->request->getPost('id_anak'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'usia'          => (int) $this->request->getPost('usia'),
            'tb'            => (float) $this->request->getPost('tb'),
            'bb'            => (float) $this->request->getPost('bb'),
            'tgl_skrng'     => $dateYmd,                       // harus cocok tipe kolom (DATE/DATETIME)
            'kategori'    => $this->request->getPost('kategori') ?: null,
            'keterangan'           => $this->request->getPost('keterangan') ?: null,
            'created_by'    => $user['id_users'] ?? null,      // pastikan kolom nullable jika bisa null
        ];

        $ok = $this->timbangan->updateById($id, $payload);

        if (! $ok) {
            $err = $this->timbangan->db->error(); // ['code','message']
            log_message('error', 'UPDATE penimbangan gagal: {0} | payload: {1}', [
                json_encode($err),
                json_encode($payload)
            ]);
            return redirect()->back()->withInput()
                ->with('error', 'Gagal mengubah data: ' . ($err['message'] ?? 'Unknown DB error'));
        }

        return redirect()->to(site_url('penimbangan-anak/data'))
            ->with('success', 'Data berhasil diubah');
    }

    // === HAPUS DATA ===
    public function delete($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $id = (int) $id;
        $ok = $this->timbangan->deldata($id);

        session()->setFlashdata('msg', $ok ? 'Data berhasil dihapus' : 'Gagal menghapus data');
        session()->setFlashdata($ok ? 'success' : 'error', session()->getFlashdata('msg'));

        return redirect()->to(site_url('penimbangan-anak/data'));
    }
}
