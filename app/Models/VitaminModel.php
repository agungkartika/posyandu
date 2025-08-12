<?php

namespace App\Models;

use CodeIgniter\Model;

class VitaminModel extends Model
{
    protected $DBGroup      = 'default';
    protected $table        = 'vitamin';
    protected $primaryKey   = 'id_vitamin';
    protected $returnType   = 'array';
    protected $useSoftDeletes = false;

    // Sesuaikan dengan kolom tabel kamu
    protected $allowedFields = [
        'anak_id',
        'tanggal_pemberian', // DATE (Y-m-d)
        'jenis_vitamin',
        'created_by',
    ];

    // ==== API kompatibel dengan CI3 lama (tanpa bentrok method bawaan) ====

    /** Tambah data vitamin (CI3: add) */
    public function add(array $data)
    {
        $ok = $this->insert($data, false);
        return $ok !== false;
    }

    /** Hapus by id (CI3: deldata) */
    public function deldata(int $id)
    {
        return (bool) $this->delete($id);
    }

    /**
     * Update by id — JANGAN pakai nama `update()` agar tidak bentrok
     * dengan `Model::update($id, $data)`.
     */
    public function updateById(int $id, array $data)
    {
        // protect(false) kalau ada kolom yang belum di-allowedFields
        return (bool) $this->update($id, $data);
    }

    /** Ambil semua (CI3: getAll) */
    public function getAll()
    {
        $res = $this->db->table($this->table)->orderBy($this->primaryKey, 'DESC')->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    /** Ambil satu by id (CI3: getById) */
    public function getById(int $id)
    {
        $res = $this->db->table($this->table)->getWhere([$this->primaryKey => $id], 1);
        return is_object($res) ? ($res->getRowArray() ?: null) : null;
    }

    /** Ambil data vitamin berdasarkan anak_id (CI3: getByAnakIds) */
    public function getByAnakIds(array $anakIds)
    {
        if (empty($anakIds)) return [];
        $res = $this->db->table($this->table)->whereIn('anak_id', $anakIds)->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    /** Untuk dropdown anak di form (CI3: getDataAnakIbu) */
    public function getDataAnakIbu()
    {
        $res = $this->db->table('anak')->select('id_anak, nama_anak')->orderBy('nama_anak', 'ASC')->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    public function getByAnakIdsWithName(array $anakIds): array
    {
        if (empty($anakIds)) return [];

        $res = $this->db->table('vitamin v')
            ->select('v.*, a.nama_anak')
            ->join('anak a', 'a.id_anak = v.anak_id', 'left')
            ->whereIn('v.anak_id', $anakIds)
            ->orderBy('v.tanggal_pemberian', 'ASC')
            ->get();

        return is_object($res) ? ($res->getResultArray() ?: []) : [];
    }
}
