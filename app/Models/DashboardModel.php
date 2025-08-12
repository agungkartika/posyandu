<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = '';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // === KARTU RINGKASAN ===
    public function dataIbu(): int
    {
        return (int) $this->db->table('ibu')->countAllResults();
    }

    public function dataAnak(): int
    {
        return (int) $this->db->table('anak')->countAllResults();
    }

    public function dataPetugas(): int
    {
        return (int) $this->db->table('petugas')->countAllResults();
    }

    public function dataBidan(): int
    {
        return (int) $this->db->table('bidan')->countAllResults();
    }

    public function dataLog(int $userId): int
    {
        return (int) $this->db->table('login_attempts')
            ->where('user_id', $userId)
            ->countAllResults();
    }
    // === END KARTU RINGKASAN ===

    public function dataAnakPeserta(int $userId): int
    {
        return (int) $this->db->table('anak')
            ->where('user_id', $userId)
            ->countAllResults();
    }

    public function dataImunisasi(int $userId): int
    {
        return (int) $this->db->table('imunisasi i')
            ->join('anak a', 'i.anak_id = a.id_anak')
            ->where('a.user_id', $userId)
            ->countAllResults();
    }

    public function dataVitamin(int $userId): int
    {
        return (int) $this->db->table('vitamin v')
            ->join('anak a', 'v.anak_id = a.id_anak')
            ->where('a.user_id', $userId)
            ->countAllResults();
    }

    public function dataTimbangan(int $userId): int
    {
        return (int) $this->db->table('timbangan t')
            ->join('anak a', 't.anak_id = a.id_anak')
            ->where('a.user_id', $userId)
            ->countAllResults();
    }

    public function dataJadwal(int $userId): int
    {
        return (int) $this->db->table('jadwal_pemeriksaan jp')
            ->join('anak a', 'jp.anak_id = a.id_anak')
            ->where('a.user_id', $userId)
            ->countAllResults();
    }
}
