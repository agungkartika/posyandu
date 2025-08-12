<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Edit Data Imunisasi</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                    <form id="imunisasi-form" name="imunisasi-form" class="form-horizontal form-label-left" action="<?php echo base_url('imunisasi-anak/update/'). $imunisasi['id_imunisasi']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Nama Anak
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_imunisasi" value="<?php echo $imunisasi['id_imunisasi'] ?>" id="id_imunisasi" class="form-control">
                                    <input type="hidden" name="id_anak" id="id_anak" value="<?php echo $imunisasi['anak_id'] ?>" class="form-control" readonly>

                                    <input type="text" name="nama_anak" id="nama_anak"
                                        value="<?= esc($nama_anak ?? '-') ?>"
                                        class="form-control" readonly>
                                    <span class="input-group-btn">
                                        <button id="pilihData" name="pilihData" type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#DataAnakModal">Pilih</button>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Imunisasi
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input class="date-picker form-control" name="tgl_skrng" id="tgl_skrng" type="text" value="<?php echo $imunisasi['tgl_skrng'] ?>" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                                <script>
                                    function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                        }, 60000);
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="user_id">Jenis Imunisasi</label>
                            <div class="col-md-6">
                                <select name="jenis_imunisasi" id="jenis_imunisasi" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="BCG" <?php if($imunisasi['jenis_imunisasi'] == 'BCG') echo 'selected'; ?>>BCG</option>
                                    <option value="Polio" <?php if($imunisasi['jenis_imunisasi'] == 'Polio') echo 'selected'; ?>>Polio</option>
                                    <option value="DPT" <?php if($imunisasi['jenis_imunisasi'] == 'DPT') echo 'selected'; ?>>DPT</option>
                                    <option value="HB" <?php if($imunisasi['jenis_imunisasi'] == 'HB') echo 'selected'; ?>>HB</option>

                                </select>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($d_anak as $d) : ?>
                                                <tr>
                                                    <td><?= $d['nama_anak']; ?></td>
                                                    <td>
                                                        <button id="pilihAnak_Bidan" type="button" data-id="<?= $d['id_anak']; ?>" data-nama="<?= $d['nama_anak']; ?>" class="btnSelectAnak btn btn-primary btn-sm">Pilih</button>
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