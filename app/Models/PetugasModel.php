<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table       = 'petugas';
    protected $primaryKey  = 'id_petugas';
    protected $returnType  = 'array';
    protected $useSoftDeletes = false;

    public function getDataUsers(): array
    {
        $userTable = $this->db->tableExists('users') ? 'users' : 'user';
        $res = $this->db->table($userTable)->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    public function getDataPetugas(): array
    {
        $res = $this->db->table($this->table)->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    public function addDataPetugas(array $data): bool
    {
        return (bool) $this->db->table($this->table)->insert($data);
    }

    public function updDataPetugas(int $id, array $data): bool
    {
        return (bool) $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }

    public function delDataPetugas(int $id): bool
    {
        return (bool) $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
}
