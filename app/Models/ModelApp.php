<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelApp extends Model
{
    protected $DBGroup = 'default';

    /** Generic helpers (drop-in gaya CI3, tapi return type CI4) */

    public function view(string $table)
    {
        return $this->db->table($table)->get();
    }

    public function insert($data = null, bool $returnID = true)
    {
        return parent::insert($data, $returnID);
    }

    public function edit(string $table, array $where)
    {
        return $this->db->table($table)->getWhere($where);
    }

    public function update($id = null, $data = null): bool
    {
        if ($id === null) {
            return false;
        }

        $table = $this->table;
        $where = [$this->primaryKey => $id];

        return (bool) $this->db->table($table)->update($data, $where);
    }

    public function delete($id = null, bool $purge = false)
    {
        if ($id === null) {
            return false;
        }

        $table = $this->table;
        $where = [$this->primaryKey => $id];

        return (bool) $this->db->table($table)->delete($where);
    }

    public function view_where(string $table, array $where)
    {
        return $this->db->table($table)->where($where)->get();
    }

    public function view_ordering_limit(
        string $table,
        string $order,
        string $ordering,
        int $baris,
        int $dari
    ) {
        return $this->db->table($table)
            ->orderBy($order, $ordering)
            ->limit($baris, $dari)   // CI4: limit($limit, $offset)
            ->get();
    }

    public function view_where_ordering_limit(
        string $table,
        array $where,
        string $order,
        string $ordering,
        int $baris,
        int $dari
    ) {
        return $this->db->table($table)
            ->where($where)
            ->orderBy($order, $ordering)
            ->limit($baris, $dari)
            ->get();
    }

    public function view_ordering(string $table, string $order, string $ordering): array
    {
        return $this->db->table($table)
            ->orderBy($order, $ordering)
            ->get()->getResultArray();
    }

    public function view_where_ordering(string $table, array $where, string $order, string $ordering): array
    {
        return $this->db->table($table)
            ->where($where)
            ->orderBy($order, $ordering)
            ->get()->getResultArray();
    }

    public function view_join_one(
        string $table1,
        string $table2,
        string $field,
        string $order,
        string $ordering
    ): array {
        return $this->db->table($table1)
            ->join($table2, "{$table1}.{$field} = {$table2}.{$field}", 'inner')
            ->orderBy($order, $ordering)
            ->get()->getResultArray();
    }

    public function view_join_where(
        string $table1,
        string $table2,
        string $field,
        array $where,
        string $order,
        string $ordering
    ): array {
        return $this->db->table($table1)
            ->join($table2, "{$table1}.{$field} = {$table2}.{$field}", 'inner')
            ->where($where)
            ->orderBy($order, $ordering)
            ->get()->getResultArray();
    }

    /** Business-specific ports */

    public function umenu_akses(string $link, string $id): int
    {
        return $this->db->table('modul')
            ->join('users_modul', 'modul.id_modul = users_modul.id_modul', 'inner')
            ->where('users_modul.id_session', $id)
            ->where('modul.link', $link)
            ->countAllResults();
    }

    // NOTE: disarankan pakai password hash (lihat cek_login_hash)
    public function cek_login(string $username, string $password, string $table)
    {
        return $this->db->table($table)
            ->where('username', $username)
            ->where('password', $password)
            ->where('blokir', 'N')
            ->get();
        // gunakan ->getRowArray() di pemanggil
    }

    // Versi aman (disarankan). Kolom 'password' harus hash (password_hash).
    public function cek_login_hash(string $username, string $password, string $table = 'users'): ?array
    {
        $row = $this->db->table($table)
            ->where('username', $username)
            ->where('blokir', 'N')
            ->get()->getRowArray();

        if (!$row) return null;
        return password_verify($password, $row['password'] ?? '') ? $row : null;
    }

    public function grafik_kunjungan(int $limit = 10): array
    {
        return $this->db->table('statistik')
            ->select('COUNT(*) AS jumlah, tanggal')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'DESC')
            ->limit($limit)
            ->get()->getResultArray();
    }

    public function kategori_populer(int $limit): array
    {
        // Port SQL asli; gunakan LIMIT aman via builder.
        $subB = $this->db->table('berita')
            ->select('id_kategori, SUM(dibaca) AS jum_dibaca')
            ->groupBy('id_kategori');

        // CI4 belum punya joinSubquery cross-DB secara konsisten -> pakai raw SQL yang jelas & sederhana.
        $sql = "
            SELECT c.*
            FROM (
                SELECT a.*, b.jum_dibaca
                FROM kategori a
                LEFT JOIN (
                    SELECT id_kategori, SUM(dibaca) AS jum_dibaca
                    FROM berita
                    GROUP BY id_kategori
                ) b ON a.id_kategori = b.id_kategori
            ) c
            WHERE c.aktif = 'Y'
            ORDER BY c.jum_dibaca DESC
            LIMIT {$limit}
        ";
        // Pastikan $limit int
        $limit = (int) $limit;
        $sql = str_replace("LIMIT {$limit}", "LIMIT {$limit}", $sql);

        return $this->db->query($sql)->getResultArray();
    }
}
