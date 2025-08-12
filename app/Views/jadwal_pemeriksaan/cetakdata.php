<!DOCTYPE html>
<html>

<head>
    <title>Jadwal Pemeriksaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 40px;
        }

        h2 {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            font-size: 14px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        @media print {
            body {
                margin: 0;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>

    <h2>JADWAL PEMERIKSAAN</h2>

    <table>
        <thead>
            <tr>

                <th>No</th>
                <th>Nama Anak</th>
                <th>Nama Orang Tua</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Jam Pemeriksaan</th>
                <th>Kader</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($rows as $record) : ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= esc($record['anak']['nama_anak'] ?? '-') ?></td>
                    <td><?= esc($record['anak']['orang_tua'] ?? '-') ?></td>
                    <td><?= esc($record['tanggal']) ?></td>
                    <td><?= esc($record['jam']) ?></td>
                    <td><?= esc($record['petugas']['nama_petugas'] ?? '-') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

</body>

</html>
<script>
    window.print();
</script>