<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Daftar Penimbangan Anak Yang Telah Dilakukan</h3>
                    <?php
                    $msg = session()->getFlashdata('msg')
                        ?? session()->getFlashdata('success')
                        ?? session()->getFlashdata('error')
                        ?? '';
                    ?>
                    <div class="flash-datap" data-flashdata="<?= esc($msg) ?>"></div>
                    <?php if ($msg): ?><?php endif; ?>

                    <!-- Sesuaikan rute tombol tambah sesuai routes CI4-mu -->
                    <a href="<?= site_url('penimbangan-anak') ?>" class="btn btn-primary">Tambah Data Timbang</a>


                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Anak</th>
                                            <th>Tanggal Penimbangan</th>
                                            <th>Umur</th>
                                            <th>Berat Anak</th>
                                            <th>Tinggi Anak</th>
                                            <th>Kategori</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($row as $n): ?>
                                            <?php
                                            // Data sudah dipasok dari controller via getAllWithInfo()
                                            $namaAnak   = $n['nama_anak']       ?? '-';
                                            $tgl        = $n['tgl_skrng']       ?? '-';
                                            $usia       = $n['usia']            ?? '-';
                                            $bb         = $n['bb']              ?? '-';
                                            $tb         = $n['tb']              ?? '-';
                                            $ket        = $n['keterangan']      ?? '-';
                                            $id         = $n['id_penimbangan']  ?? '';
                                            // Map kategori
                                            $kategori = match ($n['kategori'] ?? '') {
                                                'N' => 'Naik',
                                                'T' => 'Tidak Naik',
                                                'O' => 'Tidak Datang',
                                                default => '-',
                                            };
                                            ?>
                                            <tr>
                                                <td>
                                                    <center><?= $i++; ?></center>
                                                </td>
                                                <td><?= esc($namaAnak) ?></td>
                                                <td><?= esc($tgl) ?></td>
                                                <td><?= esc($usia) ?>&nbsp;Bulan</td>
                                                <td><?= esc($bb) ?></td>
                                                <td><?= esc($tb) ?></td>
                                                <td><?= esc($kategori) ?></td>
                                                <td><?= esc($ket) ?></td>
                                                <td>
                                                    <a href="<?= site_url('penimbangan-anak/edit/' . $id) ?>" class="btn btn-warning btn-circle btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a data-toggle="tooltip" href="<?= site_url('penimbangan-anak/delete/' . $id) ?>"
                                                        class="btn btn-danger btn-circle btn-sm tbl-hapus" title="Delete"
                                                        onclick="return confirm('Hapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>