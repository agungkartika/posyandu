<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalPemeriksaanModel extends Model
{
    protected $table            = 'jadwal_pemeriksaan';
    protected $primaryKey       = 'id_jadwal_pemeriksaan'; // sesuaikan jika berbeda
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    // Kolom yang boleh diinsert/update (opsional, jika pakai Model::save/insert/update)
    protected $allowedFields    = [
        'id_anak',
        'tanggal',
        'jam',
        'id_petugas'
    ];

    /**
     * Ambil data users untuk dropdown dsb.
     * Memakai tabel 'users' jika ada, fallback ke 'user'.
     */
    public function getDataUsers(): array
    {
        $tbl = $this->db->tableExists('users') ? 'users' : 'user';
        $res = $this->db->table($tbl)->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    /**
     * Ambil data petugas.
     */
    public function getDataPetugas(): array
    {
        $res = $this->db->table('petugas')->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    /**
     * Insert jadwal (kompatibel dengan CI3: $this->Jadwal_pemeriksaan_model->tambah($data))
     */
    public function tambah(array $data): bool
    {
        $ok = $this->db->table($this->table)->insert($data);
        if (! $ok) {
            log_message('error', 'JadwalPemeriksaanModel::tambah error: {0}', [json_encode($this->db->error())]);
        }
        return (bool) $ok;
    }

    /**
     * Hapus jadwal by ID (kompatibel dengan CI3: delData($id))
     */
    public function delData(int $id): bool
    {
        $ok = $this->db->table($this->table)->delete([$this->primaryKey => $id]);
        if (! $ok) {
            log_message('error', 'JadwalPemeriksaanModel::delData error: {0}', [json_encode($this->db->error())]);
        }
        return (bool) $ok;
    }

    /**
     * Ambil jadwal berdasarkan kumpulan anak_id / id_anak.
     * Tetap kompatibel dengan method lama: getByAnakIds($anak_ids)
     */
    public function getByAnakIds(array $anakIds): array
    {
        if (empty($anakIds)) {
            return [];
        }

        // Deteksi nama kolom FK yang dipakai tabel jadwal_pemeriksaan
        $cols  = $this->db->getFieldNames($this->table);
        $fkCol = in_array('anak_id', $cols, true) ? 'anak_id'
            : (in_array('id_anak', $cols, true) ? 'id_anak' : null);

        if ($fkCol === null) {
            log_message('error', 'JadwalPemeriksaanModel::getByAnakIds gagal: kolom FK anak tidak ditemukan di {0}', [$this->table]);
            return [];
        }

        // Deteksi nama kolom tanggal (opsional, untuk orderBy)
        $dateCol = in_array('tanggal', $cols, true) ? 'tanggal'
            : (in_array('tgl_jadwal', $cols, true) ? 'tgl_jadwal' : null);

        $builder = $this->db->table($this->table)->whereIn($fkCol, $anakIds);
        if ($dateCol) {
            $builder->orderBy($dateCol, 'DESC');
        }

        $res = $builder->get();
        return is_object($res) ? $res->getResultArray() : [];
    }
    public function getWithNames(): array
    {
        return $this->db->table('jadwal_pemeriksaan jp')
            ->select('jp.*, a.nama_anak, a.orang_tua, p.nama_petugas')
            ->join('anak a', 'a.id_anak = jp.id_anak', 'left')
            ->join('petugas p', 'p.id_petugas = jp.id_petugas', 'left')
            ->orderBy('jp.id_jadwal_pemeriksaan', 'DESC')
            ->get()->getResultArray();
    }
    public function getByAnakIdsWithName(array $anakIds): array
    {
        if (empty($anakIds)) return [];

        $res = $this->db->table('jadwal_pemeriksaan jp')
            ->select('jp.*, a.nama_anak')              // ← bawa nama anak
            ->join('anak a', 'a.id_anak = jp.id_anak', 'left')
            ->whereIn('jp.id_anak', $anakIds)
            ->orderBy('jp.tanggal', 'ASC')
            ->orderBy('jp.jam', 'ASC')
            ->get();

        return is_object($res) ? ($res->getResultArray() ?: []) : [];
    }
}
