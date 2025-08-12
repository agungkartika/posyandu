<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Data Pemeriksaan</h3>
        </div>
    </div>

    <?php
    $msg = session()->getFlashdata('msg')
        ?? session()->getFlashdata('success')
        ?? session()->getFlashdata('error')
        ?? '';
    ?>
    <div class="flash-datap" data-flashdata="<?= esc($msg) ?>"></div>
    <?php if ($msg): ?><?php endif; ?>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">

                    <!-- gunakan route CI4 dengan hyphen (sesuai Routes) -->
                    <form action="<?= site_url('jadwal-pemeriksaan/generate') ?>" method="post" class="form-inline mb-3">
                        <?= csrf_field() ?>
                        <div class="form-group mr-2">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" name="tanggal" class="form-control ml-2" required>
                        </div>
                        <div class="form-group mr-2">
                            <label for="jam">Jam Mulai:</label>
                            <input type="time" name="jam" class="form-control ml-2" required>
                        </div>
                        <div class="form-group mr-2">
                            <label for="durasi">Durasi (menit):</label>
                            <input type="number" name="durasi" class="form-control ml-2" value="15" required>
                        </div>
                        <button type="submit" class="btn btn-success ml-2">🔁 Generate Jadwal Otomatis</button>
                    </form>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataJadwalModal">Tambah Data</button>
                    <a href="<?= site_url('jadwal-pemeriksaan/cetakdata') ?>" class="btn btn-secondary" target="_blank">
                        <i class="fa fa-print"></i>
                    </a>
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
                                            <th>Tanggal Pemeriksaan</th>
                                            <th>Jam Pemeriksaan</th>
                                            <th>Kader</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1;
                                        foreach ($items as $e): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= esc($e['nama_anak'] ?? '-') ?></td>
                                                <td><?= esc($e['orang_tua'] ?? '-') ?></td>
                                                <td><?= esc($e['tanggal'] ?? '-') ?></td>
                                                <td><?= esc($e['jam'] ?? '-') ?></td>
                                                <td><?= esc($e['nama_petugas'] ?? '-') ?></td>
                                                <td>
                                                    <a
                                                        href="<?= site_url('jadwal-pemeriksaan/delete/' . ($e['id_jadwal_pemeriksaan'] ?? '')) ?>"
                                                        class="btn btn-danger btn-circle btn-sm tbl-hapus"
                                                        title="Delete"
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

    <!-- Modal Tambah Jadwal -->
    <div class="modal fade bs-example-modal-lg" id="addDataJadwalModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Form Data Jadwal Pemeriksaan</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>

                <form action="<?= site_url('jadwal-pemeriksaan/create') ?>" class="form-horizontal form-label-left" method="POST">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Anak</label>
                            <select name="id_anak" class="form-control" required>
                                <option value="">Pilih</option>
                                <?php foreach ($anakList as $rowAnak): ?>
                                    <option value="<?= esc($rowAnak['id_anak']) ?>"><?= esc($rowAnak['nama_anak']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Dari tanggal</label>
                            <input type="date" name="dari" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Sampai tanggal</label>
                            <input type="date" name="sampai" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Kader</label>
                            <select name="id_petugas" class="form-control" required>
                                <option value="">Pilih</option>
                                <?php foreach ($petugas as $p): ?>
                                    <option value="<?= esc($p['id_petugas']) ?>"><?= esc($p['nama_petugas']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Lama Waktu Pemeriksaan (menit)</label>
                            <input type="number" name="lama" class="form-control" value="15">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>