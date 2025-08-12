<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Data Anak</h3>
        </div>
    </div>

    <?php $msg = session()->getFlashdata('msg') ?? session()->getFlashdata('success') ?? session()->getFlashdata('error') ?? ''; ?>
    <div class="flash-dataw" data-flashdata="<?= esc($msg) ?>"></div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <?php $auth = session()->get('auth') ?? []; $level = (int)($auth['level_id'] ?? 0); ?>

                    <?php if ($level === 1): ?>


                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDataAnakModal">
                            Tambah Data Anak
                        </button>
                    <?php endif; ?>
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
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Anak Ke</th>
                                            <th>Nama Orang Tua</th>
                                            <th>Akun Orang Tua</th> <!-- Tambahan -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($anak as $n): ?>
                                            <tr>
                                                <td><?= $i++; ?></td>
                                                <td><?= $n['nama_anak']; ?></td>
                                                <td><?= $n['tempat_lahir'] . ', ' . $n['tgl_lahir']; ?></td>
                                                <td><?= $n['jenis_kelamin']; ?></td>
                                                <td><?= $n['umur']; ?></td>
                                                <td><?= $n['anakKe']; ?></td>
                                                <td><?= $n['orang_tua']; ?></td>
                                                <td><?= $n['nama_user'] ?? '-'; ?></td> <!-- Ambil dari join -->
                                                <td>
                                                    <a href="<?= base_url(); ?>anak/editDataAnak/<?= $n['id_anak']; ?>" class="btn btn-warning btn-circle btn-sm">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url(); ?>anak/deleteDataAnak/<?= $n['id_anak']; ?>" class="btn btn-danger btn-circle btn-sm tbl-hapus" title="Delete">
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

    <!-- Modal Tambah Anak -->
    <div class="modal fade bs-example-modal-lg" id="addDataAnakModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Form Data Anak</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>

                <form action="<?= base_url('anak/create') ?>" method="POST" class="form-horizontal">
                    <div class="modal-body">

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">NIK Anak</label>
                            <div class="col-md-9">
                                <input type="text" name="nik-anak" class="form-control" required data-inputmask="'mask' : '9999999999999999'">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Anak</label>
                            <div class="col-md-9">
                                <input type="text" name="nama-anak" class="form-control" required>
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
                                <input type="date" name="tgl-lahir" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Jenis Kelamin</label>
                            <div class="col-md-9">
                                <select name="jenis-kelamin" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Umur</label>
                            <div class="col-md-9">
                                <input type="text" name="umur" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Anak Ke</label>
                            <div class="col-md-9">
                                <input type="text" name="anakKe" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Nama Orang Tua</label>
                            <div class="col-md-9">
                                <input type="text" name="orang_tua" class="form-control" required>
                            </div>
                        </div>

                        <!-- Dropdown user_id -->
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Pilih User Orang Tua</label>
                            <div class="col-md-9">
                                <select name="user_id" class="form-control" required>
                                    <option value="">-- Pilih User --</option>
                                    <?php foreach ($user_ortu as $u): ?>
                                        <option value="<?= $u['id_users']; ?>"><?= $u['username']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
</div>