<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Edit Data Vitamin</h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                    <form id="vitamin-form"
                        class="form-horizontal form-label-left"
                        action="<?= site_url('vitamin-anak/update/') . $vitamin['id_vitamin']; ?>"
                        method="POST">
                        <?= csrf_field() ?>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Anak</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_vitamin" value="<?= esc($vitamin['id_vitamin'] ?? '') ?>" class="form-control">
                                    <input type="hidden" name="id_anak" id="id_anak" value="<?= esc($vitamin['anak_id'] ?? '') ?>" class="form-control" readonly>
                                    <input type="text" name="nama_anak" id="nama_anak" value="<?= esc($vitamin['nama_anak'] ?? '') ?>" class="form-control" readonly>
                                    <span class="input-group-btn">
                                        <button id="pilihData" name="pilihData" type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#DataAnakModal">Pilih</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Pemberian</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="date-picker form-control"
                                    name="tanggal_pemberian"
                                    id="tanggal_pemberian"
                                    type="date"
                                    value="<?= esc($vitamin['tanggal_pemberian'] ?? '') ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Vitamin</label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" name="jenis_vitamin" value="<?= esc($vitamin['jenis_vitamin'] ?? '') ?>" class="form-control">
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" class="btn btn-success">Update</button>
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
                                    <table id="datatable-anak" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Anak</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach (($d_anak ?? []) as $d): ?>
                                                <tr>
                                                    <td><?= esc($d['nama_anak']) ?></td>
                                                    <td>
                                                        <button type="button"
                                                            data-id="<?= esc($d['id_anak']) ?>"
                                                            data-nama="<?= esc($d['nama_anak']) ?>"
                                                            class="btnSelectAnak btn btn-primary btn-sm">
                                                            Pilih
                                                        </button>
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

                    <script>
                        document.addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('btnSelectAnak')) {
                                const id = e.target.getAttribute('data-id');
                                const nama = e.target.getAttribute('data-nama');
                                document.getElementById('id_anak').value = id;
                                document.getElementById('nama_anak').value = nama;
                                $('#DataAnakModal').modal('hide');
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>