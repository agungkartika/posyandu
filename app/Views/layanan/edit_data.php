<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Edit Data Timbang</h3>
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
                <div class="x_content">
                    <br />
                    <form id="penimbangan-form" name="penimbangan-form" class="form-horizontal form-label-left" action="<?php echo base_url('penimbangan-anak/update/') . $timbangan['id_penimbangan']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Nama Anak
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_penimbangan" value="<?= esc($timbangan['id_penimbangan'] ?? '') ?>" id="id_penimbangan" class="form-control">
                                    <input type="hidden" name="id_anak" id="id_anak" value="<?= esc($timbangan['anak_id'] ?? '') ?>" class="form-control" readonly>

                                    <input type="text" name="nama_anak" id="nama_anak" value="<?= esc($nama_anak ?? '') ?>" class="form-control" readonly>

                                    <span class="input-group-btn">
                                        <button id="pilihData" name="pilihData" type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#DataAnakModal">Pilih</button>
                                    </span>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Kelamin</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="text" name="jenis_kelamin" id="jenis_kelamin" value="<?php echo $timbangan['jenis_kelamin'] ?>" readonly="" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Umur</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="text" name="usia" id="umur" value="<?php echo $timbangan['usia'] ?>" readonly="" class="form-control">
                                </div>
                            </div><label class="col-form-label label-align" for="bulan">bulan
                            </label>
                        </div>

                        <!-- <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Nama Ibu
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="hidden" name="ibu_id" id="ibu_id" class="form-control" readonly>
                                    <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" readonly>
                                </div>
                            </div>
                        </div> -->



                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Timbang
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input class="date-picker form-control" name="tgl_skrng" id="tgl_skrng" value="<?php echo $timbangan['tgl_skrng'] ?>" type="text" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                                <script>
                                    function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                        }, 60000);
                                    }
                                </script>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="usia">Usia
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type=number step=any id="usia" name="usia" class="form-control">
                            </div>
                            <label class="col-form-label label-align" for="bulan">bulan
                            </label>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="bb">Berat Anak [BB]
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type=number step=any id="bb" name="bb" value="<?php echo $timbangan['bb'] ?>" class="form-control">
                            </div>
                            <label class="col-form-label label-align" for="bb">kg
                            </label>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="tb">Tinggi Anak [TB]
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type=number step=any id="tb" name="tb" value="<?php echo $timbangan['tb'] ?>" class="form-control">
                            </div>
                            <label class="col-form-label label-align" for="tb">cm
                            </label>
                        </div>
                        <!-- <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Deteksi</label>
                            <div class="col-md-6 col-sm-6 ">
                                <p style="margin-top: 5px !important;margin-bottom: -2rem !important;">
                                    <input type="radio" class="flat" name="deteksi[]" id="deteksiS" value="Sesuai" checked="" /> Sesuai
                                    <input type="radio" class="flat" name="deteksi[]" id="deteksiT" value="Tidak Sesuai" /> Tidak Sesuai
                                </p>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Kategori (N/T/O)</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-check form-check-inline">
                                    <?php $kategori = $timbangan['kategori'] ?? ''; ?>
                                    <input class="form-check-input" type="radio" name="kategori" id="kategoriN" value="N" <?= ($kategori == 'N') ? 'checked' : ''; ?> required>
                                    <label class="form-check-label" for="kategoriN">Naik (N)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategoriT" value="T" <?= ($kategori == 'T') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="kategoriT">Tidak Naik (T)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategoriO" value="O" <?= ($kategori == 'O') ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="kategoriO">Tidak datang (O)</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">Keterangan
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <textarea id="keterangan" class="form-control" name="keterangan" placeholder="isiketerangan" data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." data-parsley-validation-threshold="10"><?php echo $timbangan['keterangan'] ?></textarea>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" id="proses" name="update" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>



                    <!-- Modal Data Anak -->
                    <div class="modal fade bs-example-modal-lg" id="DataAnakModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Daftar Data Anak</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Anak</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Umur</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($d_anak as $d) : ?>
                                                <tr>
                                                    <td><?= $d['nama_anak']; ?></td>
                                                    <td><?= $d['jenis_kelamin']; ?></td>
                                                    <td><?= $d['umur']; ?></td>
                                                    <td>
                                                        <button id="pilihAnak" type="button" data-id="<?= $d['id_anak']; ?>" data-nama="<?= $d['nama_anak']; ?>" data-jk="<?= $d['jenis_kelamin']; ?>" data-umur="<?= $d['umur']; ?>" class="btnSelectAnak btn btn-primary btn-sm">Pilih</button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>