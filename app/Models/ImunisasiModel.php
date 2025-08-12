<?php

namespace App\Models;

use CodeIgniter\Model;

class ImunisasiModel extends Model
{
    protected $DBGroup    = 'default';
    protected $table         = 'imunisasi';
    protected $primaryKey    = 'id_imunisasi';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'anak_id',
        'tgl_lahir',
        'jenis_kelamin',
        'ibu_id',
        'usia',
        'imunisasi',
        'vit_a',
        'tgl_skrng',
        'ket',
        'jenis_imunisasi',
        'created_by'
    ];
    // Jika tabel punya kolom timestamps, aktifkan:
    // protected $useTimestamps = true; // pastikan ada created_at, updated_at

    /** === Port method CI3 → CI4 (nama dipertahankan agar controller lama tetap jalan) === */

    // Sama seperti versi CI3 kamu: ambil semua anak
    public function getDataAnakIbu()
    {
        return $this->db->table('anak')->get()->getResultArray();
    }

    // Wrapper agar kompatibel dengan pemanggilan lama: $this->Imunisasi_model->add($data)
    public function add(array $data): bool
    {
        return (bool) $this->insert($data);
    }
    public function edit(array $data, int $id): bool
    {
        return (bool) $this->update($id, $data);
    }
    public function deldata(int $id): bool
    {
        return (bool) $this->delete($id);
    }

    public function getById(int $id)
    {
        $res = $this->db->table($this->table)
            ->getWhere([$this->primaryKey => $id], 1);

        return is_object($res) ? ($res->getRowArray() ?: null) : null;
    }

    public function getByAnakIds(array $anak_ids)
    {
        if (empty($anak_ids)) return [];

        $res = $this->db->table($this->table)
            ->whereIn('anak_id', $anak_ids)
            ->get();

        return is_object($res) ? $res->getResultArray() : [];
    }

    public function getDataAnak(): array
    {
        $res = $this->builderWithUser()->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    public function getByAnakIdsWithName(array $anakIds): array
    {
        if (empty($anakIds)) return [];

        $res = $this->db->table('imunisasi i')
            ->select('i.*, a.nama_anak')
            ->join('anak a', 'a.id_anak = i.anak_id', 'left')
            ->whereIn('i.anak_id', $anakIds)
            ->orderBy('i.tgl_skrng', 'ASC')
            ->get();

        return is_object($res) ? ($res->getResultArray() ?: []) : [];
    }
}
