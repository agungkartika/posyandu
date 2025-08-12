<?php

namespace App\Libraries;

use App\Models\AnakModel;
use App\Models\JadwalPemeriksaanModel;
use App\Models\PetugasModel;
use CodeIgniter\Database\BaseConnection;

class GeneticAlgorithm
{
    protected $petugasModel;
    protected $anakModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->petugasModel = new PetugasModel();
        $this->anakModel = new AnakModel();
        $this->jadwalModel = new JadwalPemeriksaanModel();
    }

    public function buatPenjadwalan($tanggal, $jam_awal, $durasi)
    {
        $kader = $this->petugasModel->findAll();
        $anak  = $this->anakModel->findAll();

        // Validasi data
        if (empty($kader) || empty($anak)) {
            log_message('error', 'Data kader atau anak kosong.');
            return false;
        }

        $jumlah_kader = count($kader);
        $jumlah_anak  = count($anak);
        $populasi     = [];

        // 1. Inisialisasi Populasi
        for ($i = 0; $i < 10; $i++) {
            $solusi = [];
            for ($j = 0; $j < $jumlah_anak; $j++) {
                $solusi[] = $kader[rand(0, $jumlah_kader - 1)]['id_petugas'];
            }
            $populasi[] = $solusi;
        }

        // 2. Crossover
        $anak_crossover = [];
        for ($i = 0; $i < count($populasi) - 1; $i += 2) {
            $anak_baru = $this->crossover($populasi[$i], $populasi[$i + 1]);
            $anak_crossover[] = $anak_baru;
        }
        $populasi = array_merge($populasi, $anak_crossover);

        // 3. Mutasi
        for ($i = 0; $i < 2; $i++) {
            $index = rand(0, count($populasi) - 1);
            $populasi[$index] = $this->mutasi($populasi[$index], $kader);
        }

        // 4. Seleksi berdasarkan Fitness
        $fitness_tertinggi = 0;
        $jadwal_terpilih   = $populasi[0];

        foreach ($populasi as $solusi) {
            $fitness = $this->hitungFitness($solusi);
            if ($fitness > $fitness_tertinggi) {
                $fitness_tertinggi = $fitness;
                $jadwal_terpilih   = $solusi;
            }
        }

        // 5. Simpan ke database
        $waktu = strtotime($jam_awal);
        foreach ($jadwal_terpilih as $i => $id_petugas) {
            if (!isset($anak[$i]['id_anak'])) {
                continue;
            }

            $this->jadwalModel->insert([
                'id_anak'    => $anak[$i]['id_anak'],
                'id_petugas' => $id_petugas,
                'tanggal'    => $tanggal,
                'jam'        => date('H:i', $waktu)
            ]);

            $waktu += $durasi * 60; // tambah menit
        }

        return true;
    }

    private function crossover($parent1, $parent2)
    {
        $titik = rand(1, count($parent1) - 1);
        return array_merge(array_slice($parent1, 0, $titik), array_slice($parent2, $titik));
    }

    private function mutasi($solusi, $kader)
    {
        $index = rand(0, count($solusi) - 1);
        $solusi[$index] = $kader[rand(0, count($kader) - 1)]['id_petugas'];
        return $solusi;
    }

    private function hitungFitness($solusi)
    {
        // Contoh sederhana: makin beragam petugas, makin tinggi fitness
        return count(array_unique($solusi));
    }
}
