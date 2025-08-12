<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DashboardModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    /** @var DashboardModel */
    protected $dashboard;
    /** @var \CodeIgniter\Database\ConnectionInterface */
    protected $db;

    public function __construct()
    {
        helper('url');
        $this->dashboard = new DashboardModel();
        $this->db = \Config\Database::connect();
    }

    // Default ke dashboard petugas
    public function index()
    {
        return redirect()->to(site_url('dashboard/petugas'));
    }

    // Ambil data user dari session lalu refresh dari DB (fallback table `user` jika `users` tidak ada)
    private function currentUser(): array
    {
        $auth = session('auth') ?? [];
        $username = $auth['username'] ?? null;
        if (! $username) {
            return [];
        }

        $row = [];

        try {
            // Cek tabel yang ada untuk menghindari getRowArray() on bool
            if ($this->db->table('users')->countAllResults() > 0) {
                $res = $this->db->table('users')->getWhere(['username' => $username], 1);
                $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
            }

            // Fallback: beberapa proyek lama pakai tabel 'user' (tanpa 's')
            if (! $row && $this->db->table('user')->countAllResults() > 0) {
                $res = $this->db->table('user')->getWhere(['username' => $username], 1);
                $row = is_object($res) ? ($res->getRowArray() ?: []) : [];
            }
        } catch (\Throwable $e) {
            log_message('error', 'currentUser() DB error: {0}', [$e->getMessage()]);
            $row = [];
        }

        return $row;
    }

    // === DASHBOARD PETUGAS (level 1) ===
    public function petugas()
    {
        $user = $this->currentUser();
        $id   = (int) ($user['id_users'] ?? (session('auth.id_users') ?? 0));

        $data = [
            'title'         => 'Dashboard | Posyandu Mawar XIII',
            'user'          => $user,
            'count_ibu'     => $this->dashboard->dataIbu(),
            'count_anak'    => $this->dashboard->dataAnak(),
            'count_petugas' => $this->dashboard->dataPetugas(),
            'count_log'     => $this->dashboard->dataLog($id),
        ];

        return view('templates/header', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('dashboard/petugas', $data)
            . view('templates/footer');
    }

    // === DASHBOARD PESERTA (level 2) ===
    public function peserta()
    {
        $user = $this->currentUser();

        // Normalisasi biar view aman
        $user['image']    = $user['image'] ?? 'default.png';
        $user['name']     = $user['name']  ?? ($user['username'] ?? 'Peserta');
        $user['level_id'] = (int) ($user['level_id'] ?? (session('auth.level_id') ?? 0));

        $id = (int) ($user['id_users'] ?? (session('auth.id_users') ?? 0));

        $data = [
            'title'            => 'Dashboard Peserta | Posyandu Mawar XIII',
            'user'             => $user,
            // gunakan angka murni untuk ditampilkan di view
            'count_anak'       => $this->dashboard->dataAnakPeserta($id),
            'count_imunisasi'  => $this->dashboard->dataImunisasi($id),
            'count_vitamin'    => $this->dashboard->dataVitamin($id),
            'count_timbangan'  => $this->dashboard->dataTimbangan($id),
            'count_jadwal'     => $this->dashboard->dataJadwal($id),
        ];

        return view('templates/header', $data)
            . view('templates/sidebar-peserta', $data)
            . view('templates/topbar-peserta', $data)
            . view('peserta/dashboard', $data)
            . view('templates/footer');
    }
}
