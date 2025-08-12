<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Data Petugas</h3>
        </div>
    </div>
    <?php
    $msg = session()->getFlashdata('msg')
        ?? session()->getFlashdata('success')
        ?? session()->getFlashdata('error')
        ?? '';
    ?>
    <div class="flash-datae" data-flashdata="<?= esc($msg) ?>"></div>
    <?php if ($msg): ?>
    <?php endif; ?>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataPetugasModal">Tambah Data Petugas</button>
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
                                            <th>Nama lengkap</th>
                                            <th>Tempat/Tanggal Lahir</th>
                                            <th>Jabatan</th>
                                            <th>Lama Kerja</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($petugas as $e) : ?>
                                            <tr>
                                                <th scope="row">
                                                    <center><?= $i; ?></center>
                                                </th>
                                                <td><?= $e['nama_petugas']; ?></td>
                                                <td><?= $e['tempat_lahir'] . ', ' . $e['tgl_lahir']; ?></td>
                                                <td><?= $e['jabatan']; ?></td>
                                                <td><?= $e['lama_kerja'] . ' Tahun'; ?></td>
                                                <td>
                                                    <a data-toggle="modal" data-target="#editDataPetugasModal<?= $e['id_petugas']; ?>" class="btn btn-warning btn-circle btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('petugas/deleteDataPetugas/' . $e['id_petugas']); ?>" class="btn btn-danger btn-circle btn-sm tbl-hapus" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php $i++; ?>
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

    <!-- Modal Tambah -->
    <div class="modal fade bs-example-modal-lg" id="addDataPetugasModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Data Petugas</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form action="<?= base_url('petugas/createDataPetugas') ?>" method="POST" class="form-horizontal form-label-left">
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Petugas</label>
                            <div class="col-md-9">
                                <input type="text" name="nama-petugas" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Tempat Lahir</label>
                            <div class="col-md-9">
                                <input type="text" name="tmt-lahir" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <input type="date" name="tgl-lahir" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">No HP</label>
                            <div class="col-md-9">
                                <input type="text" name="no-hp" class="form-control" data-inputmask="'mask' : '9999-9999-9999'">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                <select name="jabatan" class="form-control" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="Ketua">Ketua</option>
                                    <option value="Bendahara">Bendahara</option>
                                    <option value="Sekretaris">Sekretaris</option>
                                    <option value="Anggota">Anggota</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Pendidikan Terakhir</label>
                            <div class="col-md-9">
                                <input type="text" name="pendidikan-terakhir" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Lama Kerja</label>
                            <div class="col-md-9">
                                <input type="number" name="lama-kerja" class="form-control" placeholder="Dalam tahun">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Tugas Pokok</label>
                            <div class="col-md-9">
                                <input type="text" name="tugas-pokok" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit (loop per petugas) -->
    <?php foreach ($petugas as $row) : ?>
        <div class="modal fade" id="editDataPetugasModal<?= $row['id_petugas']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('petugas/updateDataPetugas/' . $row['id_petugas']) ?>" method="POST" class="form-horizontal form-label-left">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Data Petugas</h4>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Nama Petugas</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama-petugas" class="form-control" value="<?= $row['nama_petugas']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tempat Lahir</label>
                                <div class="col-md-9">
                                    <input type="text" name="tmt-lahir" class="form-control" value="<?= $row['tempat_lahir']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tanggal Lahir</label>
                                <div class="col-md-9">
                                    <input type="date" name="tgl-lahir" class="form-control" value="<?= $row['tgl_lahir']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">No HP</label>
                                <div class="col-md-9">
                                    <input type="text" name="no-hp" class="form-control" value="<?= $row['no_hp']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Jabatan</label>
                                <div class="col-md-9">
                                    <select name="jabatan" class="form-control" required>
                                        <option value="">-- Pilih Jabatan --</option>
                                        <option value="Ketua" <?= $row['jabatan'] == 'Ketua' ? 'selected' : ''; ?>>Ketua</option>
                                        <option value="Bendahara" <?= $row['jabatan'] == 'Bendahara' ? 'selected' : ''; ?>>Bendahara</option>
                                        <option value="Sekretaris" <?= $row['jabatan'] == 'Sekretaris' ? 'selected' : ''; ?>>Sekretaris</option>
                                        <option value="Anggota" <?= $row['jabatan'] == 'Anggota' ? 'selected' : ''; ?>>Anggota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Pendidikan Terakhir</label>
                                <div class="col-md-9">
                                    <input type="text" name="pendidikan-terakhir" class="form-control" value="<?= $row['pendidikan_terakhir']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Lama Kerja</label>
                                <div class="col-md-9">
                                    <input type="number" name="lama-kerja" class="form-control" value="<?= $row['lama_kerja']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label">Tugas Pokok</label>
                                <div class="col-md-9">
                                    <input type="text" name="tugas-pokok" class="form-control" value="<?= $row['tugas_pokok']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>