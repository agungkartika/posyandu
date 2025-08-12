<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnakModel;
use App\Models\ImunisasiModel;
use App\Models\JadwalPemeriksaanModel;
use App\Models\PenimbanganModel;
use App\Models\VitaminModel;
use CodeIgniter\HTTP\ResponseInterface;

class Peserta extends BaseController
{
    protected $anak;
    protected $imunisasi;
    protected $vitamin;
    protected $timbangan;
    protected $jadwal;
    protected $db;

    public function __construct()
    {
        helper(['url']);
        $this->anak       = new AnakModel();
        $this->imunisasi  = new ImunisasiModel();
        $this->vitamin    = new VitaminModel();
        $this->timbangan  = new PenimbanganModel();
        $this->jadwal     = new JadwalPemeriksaanModel();
        $this->db         = \Config\Database::connect();
    }

    /** Redirect ke login bila belum login */
    private function requireLogin()
    {
        if (! session()->get('auth.username')) {
            return redirect()->to(site_url('login'));
        }
        return null;
    }

    /** Ambil user aktif dari session lalu refresh dari DB (tabel user/users) */
    private function currentUser(): array
    {
        $auth = session('auth') ?? [];
        $username = $auth['username'] ?? null;
        if (! $username) {
            return [];
        }

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
            log_message('error', 'Peserta::currentUser DB error: {0}', [$e->getMessage()]);
        }
        return $row;
    }

    /** Helper ambil array id_anak milik user peserta */
    private function anakIdsForUser(int $userId): array
    {
        $anakList = $this->anak->getDataAnakByUser($userId); // pastikan method ini sudah ada
        return array_map(static fn($r) => (int) $r['id_anak'], $anakList);
    }

    /** Dashboard peserta */
    public function anak()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user  = $this->currentUser();
        $level = (int) ($user['level_id'] ?? 0);
        if ($level !== 2) {
            return $this->response->setStatusCode(403, 'Forbidden')
                ->setBody('Akses ditolak. Halaman ini hanya untuk peserta.');
        }

        $userId   = (int) ($user['id_users'] ?? 0);
        $anakList = $this->anak->getDataAnakByUser($userId);
        $anakIds  = array_column($anakList, 'id_anak');

        $data = [
            'title'     => 'Dashboard Peserta',
            'user'      => $user,
            'anak'      => $anakList,
            'imunisasi' => $this->imunisasi->getByAnakIds($anakIds),
            'vitamin'   => $this->vitamin->getByAnakIds($anakIds),
            'timbangan' => $this->timbangan->getByAnakIds($anakIds),
            'jadwal'    => $this->jadwal->getByAnakIds($anakIds),
        ];

        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('peserta/dashboard', $data)
            . view('templates/footer');
    }

    public function timbangan()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user   = $this->currentUser();
        $userId = (int) ($user['id_users'] ?? 0);

        $anakIds = $this->anakIdsForUser($userId);

        $data = [
            'title'     => 'Data Timbangan Anak',
            'user'      => $user,
            'timbangan' => $this->timbangan->getByAnakIds($anakIds),
            'anak'      => $this->anak->getDataAnakByUser($userId), // <- tambahkan ini
        ];

        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('peserta/timbangan', $data)
            . view('templates/footer');
    }

    public function imunisasi()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user   = $this->currentUser();
        $userId = (int) ($user['id_users'] ?? 0);

        // Ambil semua id_anak milik user ini
        $anakList = $this->anak->getDataAnakByUser($userId);
        $anakIds  = array_column($anakList, 'id_anak');

        $data = [
            'title'     => 'Data Imunisasi Anak',
            'user'      => $user,
            'imunisasi' => $this->imunisasi->getByAnakIdsWithName($anakIds),
        ];

        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('peserta/imunisasi', $data)
            . view('templates/footer');
    }

    public function vitamin()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user   = $this->currentUser();
        $userId = (int) ($user['id_users'] ?? 0);

        $anakIds = $this->anakIdsForUser($userId);

        $data = [
            'title'   => 'Data Vitamin Anak',
            'user'    => $user,
            'vitamin' => $this->vitamin->getByAnakIdsWithName($anakIds),
        ];

        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('peserta/vitamin', $data)
            . view('templates/footer');
    }

    public function jadwal()
    {
        if ($redir = $this->requireLogin()) return $redir;

        $user   = $this->currentUser();
        $userId = (int) ($user['id_users'] ?? 0);

        $anakIds = $this->anakIdsForUser($userId);

        $data = [
            'title'  => 'Jadwal Pemeriksaan',
            'user'   => $user,
            'jadwal' => $this->jadwal->getByAnakIdsWithName($anakIds),
        ];

        return view('templates/header', $data)
            . view('templates/sidebar', $data)
            . view('templates/topbar', $data)
            . view('peserta/jadwal', $data)
            . view('templates/footer');
    }
}
