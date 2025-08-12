<?php

namespace App\Models;

use CodeIgniter\Model;

class AnakModel extends Model
{
    protected $DBGroup   = 'default';
    protected $table     = 'anak';
    protected $primaryKey = 'id_anak';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    /**
     * Builder dengan join ke tabel user/users dan alias kolom nama_user.
     */
    protected function builderWithUser()
    {
        $b = $this->db->table('anak a');
        $b->select('a.*, u.username AS nama_user');

        if ($this->db->tableExists('user')) {
            $b->join('user u', 'u.id_users = a.user_id', 'left');
        } elseif ($this->db->tableExists('users')) {
            $b->join('users u', 'u.id_users = a.user_id', 'left');
        } else {
            $b->select("'' AS nama_user", false);
        }

        return $b;
    }

    public function getDataAnak()
    {
        $res = $this->builderWithUser()->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    // Ambil data anak berdasarkan ID anak
    public function getAnakById(int $id)
    {
        $row = $this->db->table('anak')->where('id_anak', $id)->get();
        return is_object($row) ? ($row->getRowArray() ?: null) : null;
    }

    // Menambahkan data anak baru
    public function addDataAnak(array $data)
    {
        return (bool) $this->db->table('anak')->insert($data);
    }

    // Menghapus data anak
    public function delDataAnak(int $id)
    {
        return (bool) $this->db->table('anak')->delete(['id_anak' => $id]);
    }

    // Mengupdate data anak
    public function updDataAnak(int $id, array $data)
    {
        return (bool) $this->db->table('anak')->update($data, ['id_anak' => $id]);
    }

    // Untuk mengambil data tertentu dari tabel (kompatibel dengan kode lama)
    public function edit(string $table, array $where)
    {
        return $this->db->table($table)->getWhere($where); // kembalikan ResultInterface
    }

    // Ambil semua data anak berdasarkan user login (khusus user level peserta)
    public function getDataAnakByUser(int $userId): array
    {
        $res = $this->builderWithUser()->where('a.user_id', $userId)->get();
        if (! is_object($res)) {
            log_message('error', 'AnakModel::getDataAnakByUser SQL error: {0}', [json_encode($this->db->error())]);
            return [];
        }
        return $res->getResultArray();
    }
    // Ambil semua data anak (untuk cetak semua data anak tanpa pemeriksaan)
    public function getAllAnak(): array
    {
        return $this->getDataAnak();
    }
}
