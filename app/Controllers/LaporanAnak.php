<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\LaporanModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanAnak extends BaseController
{
    protected $laporan;
    protected $anak;
    protected $db;

    public function __construct()
    {
        helper(['url']);
        $this->laporan = new LaporanModel();
        $this->anak    = new AnakModel();
        $this->db      = \Config\Database::connect();
    }

    /** Guard sederhana: pastikan sudah login */
    private function requireLogin()
    {
        if (! session()->get('auth.username')) {
            return redirect()->to(site_url('login'))->with('error', 'Silakan login dulu.');
        }
        return null;
    }

    /** Ambil user aktif dari session lalu refresh dari DB (tabel users/user) */
    private function currentUser(): array
    {
        $username = session('auth.username');
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
        return $row ?: [];
    }

    // === LIST SEMUA LAPORAN ANAK ===
    public function index()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user = $this->currentUser();

        // Pakai nama method CI4 jika ada, fallback ke nama lama CI3.
        $laporan = method_exists($this->laporan, 'getAllLaporan')
            ? $this->laporan->getAllLaporan()
            : (method_exists($this->laporan, 'get_all_laporan') ? $this->laporan->get_all_laporan() : []);

        $data = [
            'title'   => 'Laporan Anak | Posyandu Mawar XIII',
            'user'    => $user,
            'laporan' => $laporan,
        ];

        return view('templates/header', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('laporan/daftar_laporan', $data)
            . view('templates/footer');
    }

    // === CETAK LAPORAN PER ANAK ===
    public function cetakLaporan(int $anak_id)
    {
        if ($redir = $this->requireLogin()) return $redir;

        // Anak
        $anak = method_exists($this->anak, 'getAnakById')
            ? $this->anak->getAnakById($anak_id)
            : (method_exists($this->anak, 'get_anak_by_id') ? $this->anak->get_anak_by_id($anak_id) : null);

        // Laporan anak
        $laporanAnak = method_exists($this->laporan, 'getLaporanAnak')
            ? $this->laporan->getLaporanAnak($anak_id)
            : (method_exists($this->laporan, 'get_laporan_anak') ? $this->laporan->get_laporan_anak($anak_id) : []);

        $data = [
            'anak'    => $anak,
            'laporan' => $laporanAnak,
        ];

        return view('laporan/cetak_laporan', $data);
    }

    // === CETAK SEMUA LAPORAN (lengkap pemeriksaan) ===
    public function cetakSemua()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $semua = method_exists($this->laporan, 'getAllLaporanFull')
            ? $this->laporan->getAllLaporanFull()
            : (method_exists($this->laporan, 'get_all_laporan_full') ? $this->laporan->get_all_laporan_full() : []);

        return view('laporan/cetak_semua_laporan', ['semua_laporan' => $semua]);
    }

    // === CETAK SEMUA DATA ANAK (tanpa pemeriksaan) ===
    public function cetakDataAnak()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $anakList = method_exists($this->anak, 'getAllAnak')
            ? $this->anak->getAllAnak()
            : (method_exists($this->anak, 'get_all_anak') ? $this->anak->get_all_anak() : []);

        return view('laporan/cetak_data_anak', ['anak' => $anakList]);
    }
}
