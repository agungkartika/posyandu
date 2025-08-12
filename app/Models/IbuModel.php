<?php

namespace App\Models;

use CodeIgniter\Model;

class IbuModel extends Model
{
    protected $table         = 'ibu';
    protected $primaryKey    = 'id_ibu';
    protected $returnType    = 'array';
    protected $useSoftDeletes = false;

    // Jika nanti ingin pakai $this->save() / insert/update mass-assignment:
    // protected $allowedFields = ['kolom1','kolom2', ...];

    /**
     * Ambil semua data ibu.
     */
    public function getDataIbu(): array
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    /**
     * Hapus data ibu by id.
     */
    public function delDataIbu(int $id): bool
    {
        return (bool) $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }

    /**
     * Update data ibu by id.
     */
    public function updDataIbu(int $id, array $data): bool
    {
        return (bool) $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
}
