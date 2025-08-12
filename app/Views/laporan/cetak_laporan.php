<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemeriksaan Anak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .kop {
            text-align: center;
            border-bottom: 2px solid black;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .kop h3 {
            margin: 0;
            font-size: 18px;
        }
        .kop p {
            margin: 2px;
            font-size: 14px;
        }
        h4 {
            text-align: center;
            margin-top: 25px;
            margin-bottom: 10px;
        }
        p {
            margin: 4px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
        <div class="kop">
            <!-- <img src="<?= base_url('build/img/posyandu-logo.png'); ?>" alt="Logo Posyandu"> -->
            <h3>POS PELAYANAN TERPADU MAWAR XIII</h3>
            <strong>DESA SUMBERSARI</strong><br>
            <strong>KECAMATAN CIPARAY KABUPATEN BANDUNG</strong><br>
        </div>
        <div class="garis-bawah"></div>

    <h4>Laporan Pemeriksaan Anak</h4>

    <p><strong>Nama Anak:</strong> <?= $anak['nama_anak']; ?></p>
    <p><strong>Tanggal Lahir:</strong> <?= $anak['tempat_lahir']; ?>, <?= $anak['tgl_lahir']; ?></p>
    <p><strong>Jenis Kelamin:</strong> <?= $anak['jenis_kelamin']; ?></p>

    <!-- Data Penimbangan -->
    <h4>Data Penimbangan</h4>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Usia</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>Deteksi</th>
                <th>Kategori</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan['penimbangan'])): ?>
                <?php foreach ($laporan['penimbangan'] as $row): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= $row['usia']; ?> bln</td>
                        <td><?= $row['bb']; ?></td>
                        <td><?= $row['tb']; ?></td>
                        <td><?= $row['deteksi']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td><?= $row['keterangan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" align="center">Tidak ada data penimbangan</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Data Imunisasi -->
    <h4>Data Imunisasi</h4>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Usia</th>
                <th>Jenis Imunisasi</th>
                <th>Imunisasi</th>
                <th>Vitamin A</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan['imunisasi'])): ?>
                <?php foreach ($laporan['imunisasi'] as $row): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= $row['usia']; ?> bln</td>
                        <td><?= $row['jenis_imunisasi']; ?></td>
                        <td><?= $row['imunisasi']; ?></td>
                        <td><?= $row['vit_a']; ?></td>
                        <td><?= $row['ket']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" align="center">Tidak ada data imunisasi</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Data Vitamin -->
    <h4>Data Vitamin</h4>
    <table>
        <thead>
            <tr>
                <th>Tanggal Pemberian</th>
                <th>Jenis Vitamin</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan['vitamin'])): ?>
                <?php foreach ($laporan['vitamin'] as $row): ?>
                    <tr>
                        <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?= $row['jenis_vitamin']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="2" align="center">Tidak ada data vitamin</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        window.print();
    </script>

</body>
</html>
