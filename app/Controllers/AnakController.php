<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\IbuModel;
use CodeIgniter\HTTP\ResponseInterface;

class AnakController extends BaseController
{
    protected $anak;
    protected $ibu;
    protected $db;

    public function __construct()
    {
        helper(['url']);
        $this->anak = new AnakModel();
        $this->ibu  = new IbuModel();
        $this->db   = \Config\Database::connect();
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
            log_message('error', 'Anak::currentUser DB error: {0}', [$e->getMessage()]);
        }
        return $row;
    }

    public function index()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user    = $this->currentUser();
        $level   = (int) ($user['level_id'] ?? (session('auth.level_id') ?? 0));
        $idUsers = (int) ($user['id_users'] ?? (session('auth.id_users') ?? 0));

        // Tentukan tabel user yang tersedia
        $userTable = $this->db->tableExists('user')
            ? 'user'
            : ($this->db->tableExists('users') ? 'users' : null);

        $data = [
            'title'     => 'Data Anak | Posyandu Mawar XIII',
            'user'      => $user,
            'ibu'       => $this->ibu->getDataIbu(),
            'user_ortu' => $userTable
                ? $this->db->table($userTable)->where('level_id', 2)->get()->getResultArray()
                : [],
        ];

        $data['anak'] = ($level === 2)
            ? $this->anak->getDataAnakByUser($idUsers)
            : $this->anak->getDataAnak();

        return view('templates/header-datatables', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('anak/index', $data)
            . view('templates/footer-datatables');
    }

    public function createDataAnak()
    {
        if ($redir = $this->requireLogin()) return $redir;
        $level = (int) (session('auth.level_id') ?? 0);
        if ($level !== 1) {
            return $this->response->setStatusCode(403, 'Akses ditolak')
                ->setBody('Akses ditolak. Hanya admin yang bisa menambahkan data anak.');
        }

        $data = [
            'nik_anak'      => $this->request->getPost('nik-anak'),
            'nama_anak'     => $this->request->getPost('nama-anak'),
            'tempat_lahir'  => $this->request->getPost('tmt-lahir'),
            'tgl_lahir'     => $this->request->getPost('tgl-lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis-kelamin'),
            'umur'          => $this->request->getPost('umur'),
            'anakKe'        => $this->request->getPost('anakKe'),
            'orang_tua'     => $this->request->getPost('orang_tua'),
            'user_id'       => $this->request->getPost('user_id'),
        ];

        $ok = $this->anak->addDataAnak($data);
        session()->setFlashdata($ok ? 'success' : 'error', $ok ? 'Berhasil Ditambahkan' : 'Gagal menambahkan data');

        return redirect()->to(site_url('anak'));
    }

    public function editDataAnak($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;
        $level = (int) (session('auth.level_id') ?? 0);
        if ($level !== 1) {
            return $this->response->setStatusCode(403, 'Akses ditolak')
                ->setBody('Akses ditolak. Hanya admin yang bisa mengedit data anak.');
        }

        $user = $this->currentUser();

        $data = [
            'title'     => 'Edit Data Anak | Posyandu Mawar XIII',
            'user'      => $user,
            'row'       => $this->anak->edit('anak', ['id_anak' => (int) $id])->getRowArray(),
            'ibu'       => $this->ibu->getDataIbu(),
            'user_ortu' => $this->db->table($this->db->tableExists('users') ? 'users' : 'user')
                ->where('level_id', 2)
                ->get()->getResultArray(),
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('anak/edit', $data)
            . view('templates/footer-datatables');
    }

    public function updateDataAnak($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;
        $level = (int) (session('auth.level_id') ?? 0);
        if ($level !== 1) {
            return $this->response->setStatusCode(403, 'Akses ditolak')
                ->setBody('Akses ditolak. Hanya admin yang bisa mengubah data anak.');
        }

        $data = [
            'nik_anak'      => $this->request->getPost('nik-anak'),
            'nama_anak'     => $this->request->getPost('nama-anak'),
            'tempat_lahir'  => $this->request->getPost('tmt-lahir'),
            'tgl_lahir'     => $this->request->getPost('tgl-lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis-kelamin'),
            'umur'          => $this->request->getPost('umur'),
            'anakKe'        => $this->request->getPost('anakKe'),
            'orang_tua'     => $this->request->getPost('orang_tua'),
            'user_id'       => $this->request->getPost('user_id'),
        ];

        $ok = $this->anak->updDataAnak((int) $id, $data);
        session()->setFlashdata($ok ? 'success' : 'error', $ok ? 'Berhasil Diubah' : 'Gagal mengubah data');
        return redirect()->to(site_url('anak'));
    }

    public function deleteDataAnak($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;
        $level = (int) (session('auth.level_id') ?? 0);
        if ($level !== 1) {
            return $this->response->setStatusCode(403, 'Akses ditolak')
                ->setBody('Akses ditolak. Hanya admin yang bisa menghapus data anak.');
        }

        $ok = $this->anak->delDataAnak((int) $id);
        session()->setFlashdata($ok ? 'success' : 'error', $ok ? 'Berhasil Dihapus' : 'Gagal menghapus data');
        return redirect()->to(site_url('anak'));
    }
}
