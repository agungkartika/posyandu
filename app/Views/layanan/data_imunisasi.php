<div class="right_col" role="main">

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Data Imunisasi Anak</h3>
                    <?php
                    $msg = session()->getFlashdata('msg')
                        ?? session()->getFlashdata('success')
                        ?? session()->getFlashdata('error')
                        ?? '';
                    ?>
                    <div class="flash-datap" data-flashdata="<?= esc($msg) ?>"></div>
                    <?php if ($msg): ?><?php endif; ?>

                    <a href="<?= base_url('imunisasi-anak') ?>" class="btn btn-primary">Tambah Data Imunisasi</a>
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
                                            <th>Nama Orang Tua</th>
                                            <th>Tanggal Imunisasi</th>
                                            <th>Jenis Imunisasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Kompatibel: controller boleh mengirim $row atau $rows
                                        $list = $row ?? ($rows ?? []);
                                        $i = 1;
                                        ?>

                                        <?php if (!empty($list)): ?>
                                            <?php foreach ($list as $n): ?>
                                                <?php
                                                // Pastikan kunci ada; gunakan fallback agar tidak error
                                                $idImunisasi   = (int)($n['id_imunisasi'] ?? 0);
                                                $namaAnak      = $n['nama_anak']   ?? '-';
                                                // Controller bisa kirim 'nama_ibu' atau 'orang_tua'
                                                $namaOrangTua  = $n['orang_tua']    ?? ($n['orang_tua'] ?? '-');
                                                $tglImunisasi  = $n['tgl_skrng']   ?? '-';
                                                $jenisImun     = $n['jenis_imunisasi'] ?? '-';
                                                ?>
                                                <tr>
                                                    <th scope="row">
                                                        <center><?= $i++; ?></center>
                                                    </th>
                                                    <td><?= esc($namaAnak) ?></td>
                                                    <td><?= esc($namaOrangTua) ?></td>
                                                    <td><?= esc($tglImunisasi) ?></td>
                                                    <td><?= esc($jenisImun) ?></td>
                                                    <td>
                                                        <a href="<?= base_url('imunisasi-anak/edit/' . $idImunisasi) ?>"
                                                            class="btn btn-warning btn-circle btn-sm" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <a href="<?= base_url('imunisasi-anak/delete/' . $idImunisasi) ?>"
                                                            class="btn btn-danger btn-circle btn-sm tbl-hapus" title="Delete"
                                                            onclick="return confirm('Hapus data ini?');">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div><!-- /.card-box -->
                        </div>
                    </div>
                </div><!-- /.x_content -->
            </div>
        </div>
    </div>
</div>