<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\ImunisasiModel;
use App\Models\ModelApp;
use CodeIgniter\HTTP\ResponseInterface;

class ImunisasiAnak extends BaseController
{
    protected $imunisasi;
    protected $anak;
    protected $db;

    public function __construct()
    {
        helper(['url']); // pastikan helper url aktif
        $this->imunisasi = new ImunisasiModel();
        $this->anak      = new AnakModel();
        $this->db = \Config\Database::connect();
    }

    /** Wajib login */
    private function requireLogin()
    {
        // stack kamu menyimpan auth di session('auth')
        if (! session()->get('auth.username')) {
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    /** Ambil user aktif dari session -> refresh dari DB */
    private function currentUser(): array
    {
        $auth = session()->get('auth') ?? [];
        $username = $auth['username'] ?? null;
        if (! $username) return [];

        $row = [];
        try {
            if ($this->db->tableExists('users')) {
                $res = $this->db->table('users')->getWhere(['username' => $username], 1);
                $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
            }
            if (! $row && $this->db->tableExists('user')) { // fallback nama tabel lama
                $res = $this->db->table('user')->getWhere(['username' => $username], 1);
                $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
            }
        } catch (\Throwable $e) {
            log_message('error', 'ImunisasiAnak::currentUser DB error: {0}', [$e->getMessage()]);
        }

        // Default aman untuk view
        $row['image']    = $row['image'] ?? 'default.png';
        $row['name']     = $row['name']  ?? ($row['username'] ?? 'Pengguna');
        $row['level_id'] = (int) ($row['level_id'] ?? (session('auth.level_id') ?? 0));

        return $row;
    }

    // MENAMPILKAN FORM (user biasa)
    public function index()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        // Ambil list anak untuk dropdown/pilih
        $dAnak = $this->db->table('anak')->select('id_anak, nama_anak')->orderBy('nama_anak', 'ASC')->get()->getResultArray();

        $data = [
            'title'  => 'Imunisasi Anak | Posyandu Mawar XIII',
            'user'   => $user,
            'd_anak' => $dAnak,
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/imunisasi-form', $data)
            . view('templates/footer-datatables');
    }

    // LIST DATA IMUNISASI
    public function data_imunisasi()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        $builder = $this->db->table('imunisasi i')
            ->select('
            i.*,
            a.nama_anak,
            a.orang_tua,
            u.username AS created_by_name
        ')
            ->join('anak a', 'a.id_anak = i.anak_id', 'left')
            ->orderBy('i.id_imunisasi', 'DESC');

        if ($this->db->tableExists('users')) {
            $builder->join('users u', 'u.id_users = i.created_by', 'left');
        } else {
            $builder->join('user u', 'u.id_users = i.created_by', 'left');
        }

        $rows = $builder->get()->getResultArray();

        $data = [
            'title' => 'Imunisasi Anak',
            'user'  => $user,
            'rows'  => $rows,
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/data_imunisasi', $data)
            . view('templates/footer-datatables');
    }

    // MENAMPILKAN (role bidan)
    public function imunisasi()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();
        $dAnak = $this->db->table('anak')->select('id_anak, nama_anak')->orderBy('nama_anak', 'ASC')->get()->getResultArray();

        $data = [
            'title'  => 'Imunisasi Anak',
            'user'   => $user,
            'd_anak' => $dAnak,
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar-bidan', $data)
            . view('templates/topbar', $data)
            . view('layanan/imunisasi_bidan', $data)
            . view('templates/footer-datatables');
    }

    // TAMBAH DATA (form sederhana)
    public function submit()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        // Validasi minimal
        $rules = [
            'id_anak'         => 'required|is_natural_no_zero',
            'tgl_skrng'       => 'required',                 // pastikan format cocok tipe kolom
            'jenis_imunisasi' => 'required|string',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' | ', $this->validator->getErrors()));
        }

        $payload = [
            'anak_id'         => (int) $this->request->getPost('id_anak'),
            'tgl_skrng'       => $this->request->getPost('tgl_skrng'),
            'jenis_imunisasi' => $this->request->getPost('jenis_imunisasi'),
            'created_by'      => $user['id_users'] ?? null,
        ];

        // INSERT
        $ok = $this->imunisasi->insert($payload);
        if ($ok === false) {
            // Tangkap error dari Model (allowedFields, validation, dll.)
            $err = $this->imunisasi->errors();
            if (empty($err)) {
                // fallback error DB
                $err = $this->imunisasi->db->error();
                log_message('error', 'Imunisasi insert DB error: {0} | payload: {1}', [json_encode($err), json_encode($payload)]);
                $err = [$err['message'] ?? 'DB error'];
            }
            return redirect()->back()->withInput()->with('error', implode('; ', (array) $err));
        }

        return redirect()->to(site_url('imunisasi-anak/data-imunisasi'))
            ->with('msg', 'Data Berhasil Ditambahkan');
    }

    // TAMBAH DATA (versi lengkap)
    public function submit_imun()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        $vit = $this->request->getPost('vit'); // array?
        $payload = [
            'anak_id'         => (int) $this->request->getPost('id_anak'),
            'tgl_lahir'       => $this->request->getPost('tgl_lahir') ?: null,
            'jenis_kelamin'   => $this->request->getPost('jenis_kelamin') ?: null,
            'ibu_id'          => $this->request->getPost('ibu_id') ?: null,
            'usia'            => $this->request->getPost('usia') ?: null,
            'imunisasi'       => $this->request->getPost('imun') ?: null,
            'vit_a'           => is_array($vit) ? ($vit[0] ?? null) : null,
            'tgl_skrng'       => $this->request->getPost('tgl_skrng'),
            'ket'             => $this->request->getPost('keterangan') ?: null,
            'created_by'      => $user['id_users'] ?? null,
        ];

        $ok = $this->imunisasi->insert($payload);
        if ($ok === false) {
            $err = $this->imunisasi->errors();
            if (empty($err)) {
                $err = $this->imunisasi->db->error();
                log_message('error', 'Imunisasi insert(complete) DB error: {0} | payload: {1}', [json_encode($err), json_encode($payload)]);
                $err = [$err['message'] ?? 'DB error'];
            }
            return redirect()->back()->withInput()->with('error', implode('; ', (array) $err));
        }

        return redirect()->to(site_url('imunisasi-anak/imunisasi'))
            ->with('msg', 'Berhasil Ditambahkan');
    }

    // EDIT DATA (tampilkan form)
    public function edit_data($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $id   = (int) $id;
        $user = $this->currentUser();

        $imunisasi = $this->imunisasi->getById($id);


        $namaAnak = '';
        if ($imunisasi && ! empty($imunisasi['anak_id'])) {
            $rowAnak  = $this->anak->getAnakById((int) $imunisasi['anak_id']); // BENAR
            $namaAnak = $rowAnak['nama_anak'] ?? '';
        }


        $data = [
            'title'      => 'Edit Imunisasi Anak',
            'user'       => $user,
            'd_anak'     => $this->anak->getDataAnak(),
            'imunisasi'  => $imunisasi,
            'nama_anak'  => $namaAnak,
        ];

       
        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/edit_imunisasi', $data)
            . view('templates/footer-datatables');
    }

    // UPDATE DATA (proses)
    public function update()
        {
            if ($redir = $this->requireLogin()) return $redir;

            $user = $this->currentUser();

            $id = $this->request->getPost('id_imunisasi');

            $rules = [
                'id_anak'         => 'required|is_natural_no_zero',
                'tgl_skrng'       => 'required',
                'jenis_imunisasi' => 'required|string',
            ];

            if (! $this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', implode(' | ', $this->validator->getErrors()));
            }

            $payload = [
                'anak_id'         => (int) $this->request->getPost('id_anak'),
                'tgl_skrng'       => $this->request->getPost('tgl_skrng'),
                'jenis_imunisasi' => $this->request->getPost('jenis_imunisasi'),
            ];

            $ok = $this->imunisasi->update($id, $payload);

            if ($ok === false) {
                $err = $this->imunisasi->errors();

                if (empty($err)) {
                    $err = $this->imunisasi->db->error();
                    log_message('error', 'Imunisasi update DB error: {0} | payload: {1}', [json_encode($err), json_encode($payload)]);
                    $err = [$err['message'] ?? 'DB error'];
                }

                return redirect()->back()->withInput()->with('error', implode('; ', (array) $err));
            }

            return redirect()->to(site_url('imunisasi-anak/data-imunisasi'))
                ->with('msg', 'Berhasil Diubah');
        }

    // HAPUS DATA
    public function delete_data($id)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $this->imunisasi->delete((int) $id);

        return redirect()->to(site_url('imunisasi-anak/data-imunisasi'))
            ->with('msg', 'Berhasil Dihapus');
    }
}
