<div class="right_col" role="main">
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h3>Data Vitamin</h3>
                    <?php
                    $msg = session()->getFlashdata('msg')
                        ?? session()->getFlashdata('success')
                        ?? session()->getFlashdata('error')
                        ?? '';
                    ?>
                    <div class="flash-datav" data-flashdata="<?= esc($msg) ?>"></div>
                    <?php if ($msg): ?><?php endif; ?>

                    <a href="<?= site_url('vitamin-anak') ?>" class="btn btn-primary">Tambah Data Vitamin</a>
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
                                            <th>Tanggal Pemberian</th>
                                            <th>Jenis Vitamin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Controller sebaiknya mengirim variabel: $rows (array of vitamin + join anak)
                                        $rows = $rows ?? ($row ?? []); // fallback kalau controller kirim $row
                                        $i = 1;
                                        foreach ($rows as $n):
                                            $namaAnak = $n['nama_anak'] ?? '-';
                                            $tgl      = $n['tanggal_pemberian'] ?? '-';
                                            $jenis    = $n['jenis_vitamin'] ?? '-';
                                            $id       = $n['id_vitamin'] ?? null;
                                        ?>
                                            <tr>
                                                <th scope="row" class="text-center"><?= $i++; ?></th>
                                                <td><?= esc($namaAnak) ?></td>
                                                <td><?= esc($tgl) ?></td>
                                                <td><?= esc($jenis) ?></td>
                                                <td>
                                                    <a href="<?= site_url('vitamin-anak/edit/' . $id) ?>" class="btn btn-warning btn-circle btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="<?= site_url('vitamin-anak/delete/' . $id) ?>"
                                                        class="btn btn-danger btn-circle btn-sm tbl-hapus"
                                                        data-toggle="tooltip" title="Delete"
                                                        onclick="return confirm('Hapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($rows)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada data.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div><!--/.card-box-->
                        </div>
                    </div>
                </div><!--/.x_content-->
            </div>
        </div>
    </div>
</div>