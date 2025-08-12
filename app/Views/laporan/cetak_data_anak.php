<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Anak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .kop {
            text-align: center;
            margin-bottom: 5px;
        }

        .kop img {
            float: left;
            width: 70px;
            height: 70px;
            margin-right: 10px;
        }

        .garis-bawah {
            border-bottom: 2px solid black;
            margin-bottom: 20px;
        }

        h3 {
            text-align: center;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- KOP -->
    <div class="kop">
        <!-- Aktifkan baris berikut jika ingin menampilkan logo -->
        <!-- <img src="<?= base_url('assets/img/logo-posyandu.png'); ?>" alt="Logo Posyandu"> -->
        <h3>POS PELAYANAN TERPADU MAWAR XIII</h3>
        <strong>DESA SUMBERSARI</strong><br>
        <strong>KECAMATAN CIPARAY KABUPATEN BANDUNG</strong>
    </div>
    <div class="garis-bawah"></div>

    <!-- Judul -->
    <h3>Data Anak Posyandu</h3>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Tempat/Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Umur</th>
                <th>Anak Ke</th>
                <th>Nama Orang Tua</th>
                <th>Username Orang Tua</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; foreach ($anak as $n): ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $n['nama_anak']; ?></td>
                    <td><?= $n['tempat_lahir'] . ', ' . $n['tgl_lahir']; ?></td>
                    <td><?= $n['jenis_kelamin']; ?></td>
                    <td><?= $n['umur']; ?></td>
                    <td><?= $n['anakKe']; ?></td>
                    <td><?= $n['orang_tua']; ?></td>
                    <td><?= $n['nama_user']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Script Cetak Otomatis -->
    <script>
        window.print();
    </script>

</body>
</html>
