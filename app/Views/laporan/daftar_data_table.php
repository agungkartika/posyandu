<a href="#" class="btn btn-primary mb-3">
    <i class="fa fa-print"></i> Cetak Semua (opsional)
</a>

<table id="datatable" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Tanggal Periksa</th>
            <th>Usia</th>
            <th>Berat Badan</th>
            <th>Tinggi Badan</th>
            <th>Deteksi</th>
            <th>Imunisasi</th>
            <th>Vit. A</th>
            <th>Keterangan</th>
            <th>Aksi</th> <!-- Kolom Aksi -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laporan as $d) { ?>
            <tr>
                <td><?php echo date_format(date_create($d->tgl_skrng), "j F Y"); ?></td>
                <td><?php echo $d->usia; ?> bulan</td>
                <td><?php echo $d->bb; ?> kg</td>
                <td><?php echo $d->tb; ?> cm</td>
                <td><?php echo $d->deteksi; ?></td>
                <td><?php echo $d->imunisasi; ?></td>
                <td><?php echo $d->vit_a; ?></td>
                <td><?php echo $d->ket; ?></td>
                <td>
                    <a href="<?= base_url('laporan-anak/cetak/' . $d->id_anak); ?>" 
                       class="btn btn-success btn-sm" target="_blank">
                        <i class="fa fa-print"></i> Cetak
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
