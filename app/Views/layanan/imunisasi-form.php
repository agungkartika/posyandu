<div class="right_col" role="main">
    <div class="page-title">
        <div class="title_left">
            <h3>Tambah Data Imunisasi</h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_content">
                    <br />
                    <form id="imunisasi-form" name="imunisasi-form" class="form-horizontal form-label-left"
                          action="<?php echo base_url('imunisasi-anak/submit'); ?>" method="POST">
                        <!-- Nama Anak -->
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Nama Anak</label>
                            <div class="col-md-6 col-sm-6">
                                <div class="input-group">
                                    <input type="hidden" name="id_anak" id="id_anak" class="form-control" readonly>
                                    <input type="text" name="nama_anak" id="nama_anak" class="form-control" readonly>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-outline-warning"
                                                data-toggle="modal" data-target="#DataAnakModal">
                                            Pilih
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Imunisasi -->
                        <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Imunisasi</label>
                            <div class="col-md-6 col-sm-6">
                                <input class="date-picker form-control" name="tgl_skrng" id="tgl_skrng" type="text"
                                       onfocus="this.type='date'" onmouseover="this.type='date'"
                                       onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                                <script>
                                    function timeFunctionLong(input) {
                                        setTimeout(function() {
                                            input.type = 'text';
                                        }, 60000);
                                    }
                                </script>
                            </div>
                        </div>

                        <!-- Jenis Imunisasi -->
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Jenis Imunisasi</label>
                            <div class="col-md-6">
                                <select name="jenis_imunisasi" id="jenis_imunisasi" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="BCG">BCG</option>
                                    <option value="Polio">Polio</option>
                                    <option value="DPT">DPT</option>
                                    <option value="HB">HB</option>
                                </select>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="form-group row">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" class="btn btn-success">Proses</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal Data Anak -->
                    <div class="modal fade bs-example-modal-lg" id="DataAnakModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Daftar Data Anak</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
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
                                                    <button type="button" class="btnSelectAnak btn btn-primary btn-sm"
                                                            data-id="<?= $d['id_anak']; ?>"
                                                            data-nama="<?= $d['nama_anak']; ?>">
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

                    <!-- jQuery & DataTables -->
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#datatable').DataTable();

                            // Event Delegation untuk tombol Pilih
                            $('#datatable tbody').on('click', '.btnSelectAnak', function () {
                                var id   = $(this).data('id');
                                var nama = $(this).data('nama');

                                $('#id_anak').val(id);
                                $('#nama_anak').val(nama);

                                $('#DataAnakModal').modal('hide');
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
