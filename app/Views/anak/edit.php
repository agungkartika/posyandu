<!-- modals -->
<!-- Large modal -->
<div class="right_col" role="main">



    <form id="demo-form2" action="<?php echo base_url('anak/updateDataAnak/') . $row['id_anak']; ?>" class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $row['id_anak'] ?>">

        <div class="row">
            <div class="col-md-12 col-sm-12 form-group">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nik-anak">NIK Anak</label>
                    <div class="col-md-9">
                        <input type="text" id="nik-anak" name="nik-anak" required="required" class="form-control" data-inputmask="'mask' : '9999999999999999'" value="<?= $row['nik_anak'] ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama-anak">Nama Anak</label>
                    <div class="col-md-9">
                        <input type="text" id="nama-anak" name="nama-anak" required="required" class="form-control" value="<?= $row['nama_anak'] ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="tmt-lahir">Tempat Lahir</label>
                    <div class="col-md-9">
                        <input type="text" id="tmt-lahir" name="tmt-lahir" class="form-control" value="<?= $row['tempat_lahir'] ?>">
                    </div>
                </div>




                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align">Tanggal Lahir
                    </label>
                    <div class="col-md-9">
                        <input id="tgl-lahir" name="tgl-lahir" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" required="required" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)" value="<?= $row['tgl_lahir'] ?>">
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
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jenis-kelamin">Jenis Kelamin</label>
                    <div class="col-md-9">
                        <select name="jenis-kelamin" id="jenis-kelamin" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-Laki" <?php if ($row['jenis_kelamin'] == "Laki-Laki") {
                                                            echo "selected";
                                                        } ?>>Laki-Laki</option>
                            <option value="Perempuan" <?php if ($row['jenis_kelamin'] == "Perempuan") {
                                                            echo "selected";
                                                        } ?>>Perempuan</option>
                        </select>
                    </div>
                </div>


                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama-anak">Umur</label>
                    <div class="col-md-9">
                        <input type="text" id="umur" name="umur" required="required" class="form-control" value="<?= $row['umur'] ?>">
                    </div>
                </div>


                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama-anak">Anak Ke</label>
                    <div class="col-md-9">
                        <input type="text" id="anakKe" name="anakKe" required="required" class="form-control" value="<?= $row['anakKe'] ?>">
                    </div>
                </div>


                


                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nama-anak">Nama Orang Tua</label>
                    <div class="col-md-9">
                        <input type="text" id="orang_tua" name="orang_tua" required="required" class="form-control" value="<?= $row['orang_tua'] ?>">
                    </div>
                </div>
                <!-- <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="ibu_id">Nama Ibu</label>
                    <div class="col-md-9">
                        <select name="ibu_id" id="ibu_id" class="form-control" required>

                            <option value="">Pilih Ibu</option>
                            <?php
                            foreach ($ibu as $item) { ?>
                                <option value="<?= $item['id_ibu']; ?>"><?= $item['nama_ibu']; ?></option>


                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="modal-footer">
            <a href="<?= base_url() ?>anak" class="btn btn-warning">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>

</div>