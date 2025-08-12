<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\GeneticAlgorithm;
use App\Libraries\Genetika;
use App\Models\AnakModel;
use App\Models\JadwalPemeriksaanModel;
use App\Models\PetugasModel;
use CodeIgniter\HTTP\ResponseInterface;

class JadwalPemeriksaan extends BaseController
{
    protected $jadwalModel;
    protected $anakModel;
    protected $petugasModel;
    protected $db;

    public function __construct()
    {
        $this->jadwalModel  = new JadwalPemeriksaanModel();
        $this->anakModel    = new AnakModel();
        $this->petugasModel = new PetugasModel();
        $this->db           = \Config\Database::connect();
    }
    public function requireLogin()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }
    }

    public function currentUser()
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

    public function index()
    {
        $data = [
            'title'    => 'Data Jadwal Pemeriksaan',
            'items'    => $this->jadwalModel->getWithNames(),  // ← list untuk tabel
            'anakList' => $this->anakModel->orderBy('id_anak', 'DESC')->findAll(),
            'petugas'  => $this->petugasModel->findAll(),
            'user'      => $this->currentUser(), // ← tambahkan user
        ];

        return view('templates/header-datatables', $data)
            . view('templates/sidebar')
            . view('templates/topbar', $data)
            . view('jadwal_pemeriksaan/index', $data)
            . view('templates/footer-datatables');
    }

    public function createData()
    {
        $idAnak = $this->request->getPost('id_anak');
        $idPetugas = $this->request->getPost('id_petugas');

        // Panggil library GeneticAlgorithm untuk dapatkan tanggal & jam
        $ga = new GeneticAlgorithm();
        $tanggal = date('Y-m-d'); // Set tanggal ke hari ini
        $jam = date('H:i'); // Set jam ke waktu sekarang
        $durasi = 30; // Durasi dalam menit
        $hasil = $ga->buatPenjadwalan($tanggal, $jam, $durasi);

        $data = [
            'id_anak' => $idAnak,
            'tanggal' => $hasil['tanggal'],
            'jam'     => $hasil['jam'],
            'id_petugas' => $idPetugas
        ];

        $jadwalModel = new JadwalPemeriksaanModel();
        $jadwalModel->insert($data);

        return redirect()->to('/jadwal-pemeriksaan')->with('success', 'Jadwal berhasil dibuat');
    }

    public function deleteData($id = null)
    {
        $id = (int) $id;
        if ($id && $this->jadwalModel->find($id)) {
            $this->jadwalModel->delete($id);
            return redirect()->to(site_url('jadwal-pemeriksaan'))->with('msg', 'Berhasil Dihapus');
        }
        return redirect()->to(site_url('jadwal-pemeriksaan'))->with('error', 'Data tidak ditemukan');
    }

    public function cetakData()
    {
        $jadwal = $this->db->table('jadwal_pemeriksaan')
            ->orderBy('id_jadwal_pemeriksaan', 'DESC')
            ->get()
            ->getResultArray();

        $anakTable    = $this->db->table('anak');
        $petugasTable = $this->db->table('petugas');

        foreach ($jadwal as &$row) {
            $row['anak'] = $anakTable->where('id_anak', $row['id_anak'])->get()->getRowArray();
            $row['petugas'] = $petugasTable->where('id_petugas', $row['id_petugas'])->get()->getRowArray();
        }

        $data = [
            'judul' => 'Cetak Data Jadwal Pemeriksaan',
            'rows'  => $jadwal,
        ];

        return view('jadwal_pemeriksaan/cetakdata', $data);
    }


    public function generate()
    {
        // Ambil input dari form (CI4 way)
        $tanggal = $this->request->getPost('tanggal');
        $jam     = $this->request->getPost('jam');
        $durasi  = $this->request->getPost('durasi');

        // Panggil algoritma genetika
        $ga = new GeneticAlgorithm();
        $ga->buatPenjadwalan($tanggal, $jam, $durasi);

        // Redirect ke halaman hasil jadwal
        return redirect()->to(base_url('jadwal-pemeriksaan'))->with('msg', 'Jadwal berhasil dibuat!');
    }
}
