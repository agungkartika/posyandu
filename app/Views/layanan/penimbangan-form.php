<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Tambah Data Timbang</h3>
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
                    <form id="penimbangan-form" name="penimbangan-form" class="form-horizontal form-label-left"
                        action="<?php echo base_url('penimbangan-anak/submit'); ?>" method="POST"
                        enctype="multipart/form-data">

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">Nama Anak</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_anak" id="id_anak" class="form-control" readonly>
                                    <input type="text" name="nama_anak" id="nama_anak" class="form-control" readonly>
                                    <span class="input-group-btn">
                                        <button id="pilihData" name="pilihData" type="button"
                                            class="btn btn-outline-warning" data-toggle="modal"
                                            data-target="#DataAnakModal">Pilih</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Kelamin</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="jenis_kelamin" id="jenis_kelamin" readonly class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Umur</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="usia" id="umur" readonly class="form-control">
                            </div>
                            <label class="col-form-label label-align" for="bulan">bulan</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Timbang</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="date-picker form-control" name="tgl_skrng" id="tgl_skrng" type="text"
                                    onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'"
                                    onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                                <script>
                                    function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                        }, 60000);
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="bb">Berat Anak [BB]</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="number" step="any" id="bb" name="bb" class="form-control">
                            </div>
                            <label class="col-form-label label-align" for="bb">kg</label>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="tb">Tinggi Anak [TB]</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="number" step="any" id="tb" name="tb" class="form-control">
                            </div>
                            <label class="col-form-label label-align" for="tb">cm</label>
                        </div>

                        <!-- Pilihan Kategori N/T/O -->
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Kategori (N/T/O)</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategoriN" value="N" required>
                                    <label class="form-check-label" for="kategoriN">Naik (N)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategoriT" value="T">
                                    <label class="form-check-label" for="kategoriT">Tidak Naik (T)</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategoriO" value="O">
                                    <label class="form-check-label" for="kategoriO">Tidak datang (O)</label>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan Tambahan -->
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Catatan Tambahan</label>
                            <div class="col-md-6 col-sm-6">
                                <textarea id="keterangan" class="form-control" name="keterangan" placeholder="Tulis catatan tambahan..."></textarea>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" id="proses" name="proses" class="btn btn-success">Proses</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal Data Anak -->
                    <div class="modal fade bs-example-modal-lg" id="DataAnakModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                        <button type="button" class="btnSelectAnak btn btn-primary btn-sm"
                                                            data-id="<?= $d['id_anak']; ?>"
                                                            data-nama="<?= $d['nama_anak']; ?>"
                                                            data-jk="<?= $d['jenis_kelamin']; ?>"
                                                            data-umur="<?= $d['umur']; ?>">
                                                            Pilih
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).on('click', '.btnSelectAnak', function() {
                            var id = $(this).data('id');
                            var nama = $(this).data('nama');
                            var jk = $(this).data('jk');
                            var umur = $(this).data('umur');

                            $('#id_anak').val(id);
                            $('#nama_anak').val(nama);
                            $('#jenis_kelamin').val(jk);
                            $('#umur').val(umur);

                            $('#DataAnakModal').modal('hide');
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>