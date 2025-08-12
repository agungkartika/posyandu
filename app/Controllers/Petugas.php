<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PetugasModel;
use CodeIgniter\HTTP\ResponseInterface;

class Petugas extends BaseController
{
    protected $petugas;
    protected $db;

    public function __construct()
    {
        helper(['url']);
        $this->petugas = new PetugasModel();
        $this->db      = \Config\Database::connect();
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
        try {
            if ($this->db->tableExists('users')) {
                $res = $this->db->table('users')->getWhere(['username' => $username], 1);
                $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
            }
            if (! $row && $this->db->tableExists('user')) {
                $res = $this->db->table('user')->getWhere(['username' => $username], 1);
                $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
            }
        } catch (\Throwable $e) {
            log_message('error', 'Petugas::currentUser DB error: {0}', [$e->getMessage()]);
        }
        return $row;
    }

    // INDEX DATA PETUGAS
    public function index()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();
        $data = [
            'title'    => 'Data Petugas | Posyandu Mawar XIII',
            'user'     => $user,
            'users'    => $this->petugas->getDataUsers(),
            'petugas'  => $this->petugas->getDataPetugas(),
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('petugas/index', $data)
            . view('templates/footer-datatables');
    }

    // CREATE DATA PETUGAS
    public function createDataPetugas()
    {
        if ($redir = $this->requireLogin()) return $redir;

        // Normalisasi tanggal -> 'Y-m-d'
        $tgl = $this->request->getPost('tgl-lahir');
        if ($tgl !== null && $tgl !== '') {
            try {
                $tgl = (new \DateTime($tgl))->format('Y-m-d');
            } catch (\Throwable $e) {
                $tgl = null; // biarkan null jika parsing gagal
            }
        } else {
            $tgl = null;
        }

        // Bangun payload yang bersih
        $payload = [
            // HAPUS id_petugas jika PK auto-increment. Jangan kirim ini!
            // 'id_petugas' => $this->request->getPost('id_petugas'),
            'nama_petugas'         => trim((string) $this->request->getPost('nama-petugas')),
            'tempat_lahir'         => trim((string) $this->request->getPost('tmt-lahir')),
            'tgl_lahir'            => $tgl,
            'no_hp'                => trim((string) $this->request->getPost('no-hp')),
            'jabatan'              => trim((string) $this->request->getPost('jabatan')),
            'pendidikan_terakhir'  => trim((string) $this->request->getPost('pendidikan-terakhir')),
            'lama_kerja'           => trim((string) $this->request->getPost('lama-kerja')),
            'tugas_pokok'          => trim((string) $this->request->getPost('tugas-pokok')),
            'user_id'              => $this->request->getPost('user_id') !== '' ? (int) $this->request->getPost('user_id') : null,
        ];

        // Buang key yang nilainya null/'' biar nggak nabrak kolom yang tidak ada/NOT NULL
        $payload = array_filter(
            $payload,
            static fn($v) => $v !== null && $v !== ''
        );

        $ok = $this->petugas->addDataPetugas($payload);

        if (! $ok) {
            // Tulis error DB ke log agar tahu tepatnya kenapa gagal
            log_message('error', 'Insert petugas gagal: {0}', [json_encode($this->petugas->db->error())]);
            session()->setFlashdata('error', 'Gagal menambahkan data. Cek log.');
        } else {
            session()->setFlashdata('success', 'Berhasil Ditambahkan');
        }

        return redirect()->to(site_url('petugas'));
    }


    // UPDATE DATA PETUGAS
    public function updateDataPetugas($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $payload = [
            'nama_petugas'         => $this->request->getPost('nama-petugas'),
            'tempat_lahir'         => $this->request->getPost('tmt-lahir'),
            'tgl_lahir'            => $this->request->getPost('tgl-lahir'),
            'no_hp'                => $this->request->getPost('no-hp'),
            'jabatan'              => $this->request->getPost('jabatan'),
            'pendidikan_terakhir'  => $this->request->getPost('pendidikan-terakhir'),
            'lama_kerja'           => $this->request->getPost('lama-kerja'),
            'tugas_pokok'          => $this->request->getPost('tugas-pokok'),
            'user_id'              => $this->request->getPost('user_id'),
        ];

        $ok = $this->petugas->updDataPetugas((int) $id, $payload);
        session()->setFlashdata('msg', $ok ? 'Berhasil Diubah' : 'Gagal mengubah data');
        session()->setFlashdata($ok ? 'success' : 'error', session()->getFlashdata('msg'));
        return redirect()->to(site_url('petugas'));
    }

    // DELETE DATA PETUGAS
    public function deleteDataPetugas($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $ok = $this->petugas->delDataPetugas((int) $id);
        session()->setFlashdata('msg', $ok ? 'Berhasil Dihapus' : 'Gagal menghapus data');
        session()->setFlashdata($ok ? 'success' : 'error', session()->getFlashdata('msg'));
        return redirect()->to(site_url('petugas'));
    }
}
