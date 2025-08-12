<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\VitaminModel;
use CodeIgniter\HTTP\ResponseInterface;

class Vitamin extends BaseController
{
    protected $vitamin;
    protected $anak;
    protected $db;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->vitamin = new VitaminModel();
        $this->anak    = new AnakModel();
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
        if ($this->db->tableExists('users')) {
            $res = $this->db->table('users')->getWhere(['username' => $username], 1);
            $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
        }
        if (! $row && $this->db->tableExists('user')) {
            $res = $this->db->table('user')->getWhere(['username' => $username], 1);
            $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
        }
        return $row;
    }

    // FORM TAMBAH
    public function index()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        $data = [
            'title'  => 'Vitamin Anak | Posyandu Mawar XIII',
            'user'   => $user,
            'd_anak' => $this->anak->getDataAnak(), // list anak untuk dropdown/modal
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/vitamin-form', $data)
            . view('templates/footer-datatables');
    }

    // LIST DATA
    public function data()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        $builder = $this->db->table('vitamin v')
            ->select('v.*, a.nama_anak, u.username AS created_by_name')
            ->join('anak a', 'a.id_anak = v.anak_id', 'left')
            ->orderBy('v.id_vitamin', 'DESC');

        if ($this->db->tableExists('users')) {
            $builder->join('users u', 'u.id_users = v.created_by', 'left');
        } else {
            $builder->join('user u', 'u.id_users = v.created_by', 'left');
        }

        $rows = $builder->get()->getResultArray();

        $data = [
            'title' => 'Vitamin Anak',
            'user'  => $user,
            'rows'  => $rows,
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/vitamin', $data)
            . view('templates/footer-datatables');
    }

    // SIMPAN
    public function submit()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        $payload = [
            'anak_id'            => (int) $this->request->getPost('id_anak'),
            'tanggal_pemberian'  => $this->request->getPost('tanggal_pemberian') ?: null, // DATE (Y-m-d)
            'jenis_vitamin'      => $this->request->getPost('jenis_vitamin') ?: null,
            'created_by'         => $user['id_users'] ?? null,
        ];

        $ok = $this->vitamin->add($payload);
        if ($ok === false) {
            $err = $this->vitamin->errors() ?: $this->vitamin->db->error();
            return redirect()->back()->withInput()->with('error', is_array($err) ? implode('; ', $err) : ($err['message'] ?? 'DB error'));
        }

        return redirect()->to(site_url('vitamin-anak/data-vitamin'))->with('msg', 'Data Berhasil Ditambahkan');
    }

    // FORM EDIT
    public function edit($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();
        $id   = (int) $id;

        // vitamin + nama anak
        $vitamin = $this->db->table('vitamin v')
            ->select('v.*, a.nama_anak')
            ->join('anak a', 'a.id_anak = v.anak_id', 'left')
            ->where('v.id_vitamin', $id)
            ->get()->getRowArray();

        if (! $vitamin) {
            return redirect()->to(site_url('vitamin-anak/data-vitamin'))->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title'   => 'Edit Vitamin Anak',
            'user'    => $user,
            'vitamin' => $vitamin,
            'd_anak'  => $this->anak->getDataAnak(), // kalau mau ganti anak di modal
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('layanan/edit_vitamin', $data)
            . view('templates/footer-datatables');
    }

    // UPDATE
    public function update($id = null)
        {
            if ($redir = $this->requireLogin()) return $redir;

            $user = $this->currentUser();
            $id   = (int) $id;

            $payload = [
                'anak_id'            => (int) $this->request->getPost('id_anak'),
                'tanggal_pemberian'  => $this->request->getPost('tanggal_pemberian') ?: null, // DATE (Y-m-d)
                'jenis_vitamin'      => $this->request->getPost('jenis_vitamin') ?: null,
            ];

            $ok = $this->vitamin->update($id, $payload);
            if ($ok === false) {
                $err = $this->vitamin->errors() ?: $this->vitamin->db->error();
                return redirect()->back()->withInput()->with('error', is_array($err) ? implode('; ', $err) : ($err['message'] ?? 'DB error'));
            }

            return redirect()->to(site_url('vitamin-anak/data-vitamin'))->with('msg', 'Data Berhasil Diubah');
        }

    // HAPUS
    public function delete($id = null)
    {
        if ($redir = $this->requireLogin()) return $redir;

        $id = (int) $id;
        $ok = $this->vitamin->delete($id);

        return redirect()->to(site_url('vitamin-anak/data-vitamin'))
            ->with($ok ? 'msg' : 'error', $ok ? 'Berhasil Dihapus' : 'Gagal menghapus data');
    }
}
