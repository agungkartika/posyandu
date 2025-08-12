<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $DBGroup    = 'default';
    protected $table      = 'anak';         // tidak dipakai langsung (kita pakai builder manual)
    protected $primaryKey = 'id_anak';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    /**
     * Ambil semua data laporan singkat:
     * - id_anak, nama_anak, terakhir_periksa (MAX tgl_skrng dari penimbangan)
     */
    public function getAllLaporan(): array
    {
        $builder = $this->db->table('anak a');
        $builder->select('a.id_anak, a.nama_anak, MAX(p.tgl_skrng) as terakhir_periksa')
            ->join('penimbangan p', 'p.anak_id = a.id_anak', 'left')
            ->groupBy('a.id_anak, a.nama_anak');

        $res = $builder->get();
        return is_object($res) ? $res->getResultArray() : [];
    }

    /**
     * Ambil detail laporan lengkap per anak:
     * - penimbangan, imunisasi, vitamin (masing2 sebagai array)
     */
    public function getLaporanAnak(int $anakId): array
    {
        // Penimbangan
        $penimbangan = $this->db->table('penimbangan')
            ->select('tgl_skrng AS tanggal, usia, bb, tb, deteksi, kategori, keterangan ')
            ->where('anak_id', $anakId)
            ->get()->getResultArray();

        // Imunisasi
        $imunisasi = $this->db->table('imunisasi')
            ->select('tgl_skrng AS tanggal, usia, imunisasi, vit_a, ket, jenis_imunisasi')
            ->where('anak_id', $anakId)
            ->get()->getResultArray();

        // Vitamin
        $vitamin = $this->db->table('vitamin')
            ->select('tanggal_pemberian AS tanggal, jenis_vitamin')
            ->where('anak_id', $anakId)
            ->get()->getResultArray();

        return [
            'penimbangan' => $penimbangan,
            'imunisasi'   => $imunisasi,
            'vitamin'     => $vitamin,
        ];
    }

    /**
     * Ambil semua anak beserta detail pemeriksaannya (untuk cetak semua laporan)
     */
    public function getAllLaporanFull(): array
    {
        $anakList = $this->db->table('anak')->get()->getResultArray();

        foreach ($anakList as &$anak) {
            $anakId = (int) ($anak['id_anak'] ?? 0);

            // Penimbangan
            $anak['penimbangan'] = $this->db->table('penimbangan')
                ->select('tgl_skrng AS tanggal, usia, bb, tb, deteksi, kategori, keterangan ')
                ->where('anak_id', $anakId)
                ->get()->getResultArray();

            // Imunisasi
            $anak['imunisasi'] = $this->db->table('imunisasi')
                ->select('tgl_skrng AS tanggal, usia, imunisasi, vit_a, ket, jenis_imunisasi')
                ->where('anak_id', $anakId)
                ->get()->getResultArray();

            // Vitamin
            $anak['vitamin'] = $this->db->table('vitamin')
                ->select('tanggal_pemberian AS tanggal, jenis_vitamin')
                ->where('anak_id', $anakId)
                ->get()->getResultArray();
        }

        return $anakList;
    }
}
