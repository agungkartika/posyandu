<div class="right_col" role="main">
    <?php
    $msg = session()->getFlashdata('msg')
        ?? session()->getFlashdata('success')
        ?? session()->getFlashdata('error')
        ?? '';
    $errors = session()->getFlashdata('errors') ?? [];
    ?>
    <div class="flash-datap" data-flashdata="<?= esc($msg) ?>"></div>

    <?php if ($msg): ?>
        <div class="alert alert-info"><?= esc($msg) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= esc($e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Tambah User</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left"
                        action="<?= site_url('user/tambah'); ?>"
                        method="POST" enctype="multipart/form-data" novalidate>
                        <?= csrf_field() ?>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">
                                Username <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="username" name="username"
                                    class="form-control"
                                    value="<?= old('username') ?>" required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" name="name"
                                    class="form-control"
                                    value="<?= old('name') ?>" required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">
                                Password <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input id="password" class="form-control" type="password" name="password" required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">
                                Level <span class="required">*</span>
                            </label>
                            <div class="col-md-3 col-sm-3">
                                <select name="level_id" class="form-control" required>
                                    <option value="">Pilih Level</option>
                                    <?php if (!empty($levels)): ?>
                                        <?php foreach ($levels as $lv): ?>
                                            <option value="<?= esc($lv['id_level']) ?>"
                                                <?= set_select('level_id', $lv['id_level']) ?>>
                                                <?= esc($lv['level']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">
                                Foto Profil
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <small class="text-muted">Maks 2 MB. jpg, jpeg, png, gif.</small>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a href="<?= site_url('dashboard/petugas') ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div><!-- x_content -->
            </div>
        </div>
    </div>
</div>