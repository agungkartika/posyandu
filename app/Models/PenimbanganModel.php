<?php

namespace App\Models;

use CodeIgniter\Model;

class PenimbanganModel extends Model
{
    protected $DBGroup    = 'default';
    protected $table      = 'penimbangan';
    protected $primaryKey = 'id_penimbangan';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    // Jika ingin pakai Model::save/update/delete bisa set allowedFields,
    // tapi karena kita pakai query builder manual, ini opsional.
    protected $allowedFields = [];

    /**
     * Tambah data penimbangan.
     */
    public function add(array $data)
    {
        return (bool) $this->db->table($this->table)->insert($data);
    }

    /**
     * Hapus data penimbangan berdasarkan ID.
     */
    public function deldata(int $id)
    {
        $ok = $this->db->table($this->table)->delete([$this->primaryKey => $id]);
        if (! $ok) {
            log_message('error', 'PenimbanganModel::deldata DB error: {0}', [json_encode($this->db->error())]);
        }
        return (bool) $ok;
    }

    /**
     * Ambil semua data penimbangan.
     */
    public function getAll()
    {
        $res = $this->db->table($this->table)->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    /**
     * Ambil data penimbangan berdasarkan beberapa anak_id.
     */
    public function getByAnakIds(array $anakIds)
    {
        if (empty($anakIds)) return [];

        $res = $this->db->table($this->table)
            ->whereIn('anak_id', $anakIds)
            ->get();

        return is_object($res) ? $res->getResultArray() : [];
    }

    /**
     * Ambil satu data penimbangan berdasarkan ID.
     */
    public function getById(int $id)
    {
        $res = $this->db->table($this->table)
            ->getWhere([$this->primaryKey => $id], 1);

        return is_object($res) ? ($res->getRowArray() ?: null) : null;
    }

    /**
     * Update data berdasarkan ID (pengganti Model_app->update di CI3).
     */
    public function updateById(int $id, array $data)
    {
        $ok = $this->db->table($this->table)->where([$this->primaryKey => $id])->update($data);
        if (! $ok) {
            log_message('error', 'PenimbanganModel::updateById DB error: {0}', [json_encode($this->db->error())]);
        }
        return (bool) $ok;
    }

    /**
     * (Opsional) Versi dengan JOIN untuk menampilkan nama anak & pembuat.
     * Pakai ini di list kalau kamu ingin langsung bawa label siap tampil.
     */
    public function getAllWithInfo()
    {
        $b = $this->db->table($this->table . ' p')
            ->select('p.*, a.nama_anak, u.username AS created_by_username')
            ->join('anak a', 'a.id_anak = p.anak_id', 'left');

        // Tabel user bisa 'users' atau 'user' tergantung proyek lama
        if ($this->db->tableExists('users')) {
            $b->join('users u', 'u.id_users = p.created_by', 'left');
        } elseif ($this->db->tableExists('user')) {
            $b->join('user u', 'u.id_users = p.created_by', 'left');
        }

        $res = $b->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    public function getAllWithNamaAnak()
    {
        return $this->db->table('penimbangan p')
            ->select('p.*, a.nama_anak')
            ->join('anak a', 'a.id_anak = p.anak_id', 'left')
            ->orderBy('p.tgl_skrng', 'ASC')
            ->get()->getResultArray() ?: [];
    }
}
