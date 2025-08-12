<?php

namespace App\Libraries;

class Genetika
{
    public function __construct()
    {
        // Tidak perlu get_instance() di CI4
    }

    /**
     * @param string $dari         Format 'Y-m-d'
     * @param string $sampai       Format 'Y-m-d'
     * @param string $waktuMulai   'HH:MM' atau 'HH:MM:SS'
     * @param string $waktuSelesai 'HH:MM' atau 'HH:MM:SS'
     * @param int    $lama         durasi tiap slot (menit)
     */
    public function generate(string $dari, string $sampai, string $waktuMulai, string $waktuSelesai, int $lama): array
    {
        // Simulasi sederhana (seperti versi CI3 kamu)
        return [
            'tanggal' => $dari,
            'jam'     => $waktuMulai,
        ];
    }
}
