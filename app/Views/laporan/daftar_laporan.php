<div class="right_col" role="main">
    <div class="container-fluid">
        <!-- Judul halaman -->
        <div class="row mb-2">
            <div class="col">
                <h3 class="mb-0">Laporan Pemeriksaan Anak</h3>
            </div>
        </div>

        <!-- Tombol cetak di atas entries -->
        <div class="row mb-2">
            <div class="col">
                <a href="<?= base_url('laporan-anak/cetak-semua'); ?>" class="btn btn-success btn-sm" target="_blank">
                    <i class="fa fa-print"></i> Cetak Semua Laporan
                </a>
                <a href="<?= base_url('laporan-anak/cetak-data-anak'); ?>" class="btn btn-secondary btn-sm" target="_blank">
                    <i class="fa fa-print"></i> Cetak Data Anak
                </a>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover">
                        <thead class="thead-light text-center">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Anak</th>
                                <th>Terakhir Periksa</th>
                                <th style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($laporan as $row): ?>
                                <tr>
                                    <td class="text-center"><?= $no++; ?></td>
                                    <td><?= esc($row['nama_anak']); ?></td>
                                    <td class="text-center">
                                        <?php if (!empty($row['terakhir_periksa'])): ?>
                                            <?= esc(date('d-m-Y', strtotime($row['terakhir_periksa']))); ?>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Belum pernah</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= site_url('laporan-anak/cetak/' . (int)$row['id_anak']); ?>"
                                            class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fa fa-print"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <?php if (empty($laporan)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data laporan anak</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>