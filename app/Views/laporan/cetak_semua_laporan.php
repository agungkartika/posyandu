<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Semua Anak</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; margin: 30px; }
        h2, h3, h4 { text-align: center; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 6px; text-align: center; }
        .section-break { page-break-after: always; }
        .kop {
            text-align: center;
            line-height: 1.5;
        }
        .kop img {
            position: absolute;
            top: 30px;
            left: 40px;
            width: 70px;
        }
        .garis-bawah {
            border-bottom: 3px solid black;
            margin-top: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php foreach ($semua_laporan as $anak): ?>
    <div class="section-break">
        <!-- KOP -->
        <div class="kop">
            <!-- <img src="<?= base_url('build/img/posyandu-logo.png'); ?>" alt="Logo Posyandu"> -->
            <h3>POS PELAYANAN TERPADU MAWAR XIII</h3>
            <strong>DESA SUMBERSARI</strong><br>
            <strong>KECAMATAN CIPARAY KABUPATEN BANDUNG</strong><br>
        </div>
        <div class="garis-bawah"></div>

        <h2>Laporan Pemeriksaan Semua Anak</h2>
        <h3><?= $anak['nama_anak']; ?></h3>
        <p><strong>Tanggal Lahir:</strong> <?= $anak['tgl_lahir']; ?> |
            <strong>Jenis Kelamin:</strong> <?= $anak['jenis_kelamin']; ?></p>

        <!-- Penimbangan -->
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
                <?php if (!empty($anak['penimbangan'])): ?>
                    <?php foreach ($anak['penimbangan'] as $p): ?>
                        <tr>
                            <td><?= $p['tanggal']; ?></td>
                            <td><?= $p['usia']; ?> bln</td>
                            <td><?= $p['bb']; ?></td>
                            <td><?= $p['tb']; ?></td>
                            <td><?= $p['deteksi']; ?></td>
                            <td><?= $p['kategori']; ?></td>
                            <td><?= $p['keterangan']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Tidak ada data</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Imunisasi -->
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
                <?php if (!empty($anak['imunisasi'])): ?>
                    <?php foreach ($anak['imunisasi'] as $i): ?>
                        <tr>
                            <td><?= $i['tanggal']; ?></td>
                            <td><?= $i['usia']; ?> bln</td>
                            <td><?= $i['jenis_imunisasi']; ?></td>
                            <td><?= $i['imunisasi']; ?></td>
                            <td><?= $i['vit_a']; ?></td>
                            <td><?= $i['ket']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">Tidak ada data</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Vitamin -->
        <h4>Data Vitamin</h4>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Vitamin</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($anak['vitamin'])): ?>
                    <?php foreach ($anak['vitamin'] as $v): ?>
                        <tr>
                            <td><?= $v['tanggal']; ?></td>
                            <td><?= $v['jenis_vitamin']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">Tidak ada data</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>

<script>
    window.print();
</script>

</body>
</html>
