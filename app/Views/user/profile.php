<div class="right_col" role="main">
    <?php
    $msg    = session()->getFlashdata('msg')
        ?? session()->getFlashdata('success')
        ?? session()->getFlashdata('error')
        ?? '';
    $errors = session()->getFlashdata('errors') ?? [];
    $u      = $user ?? [];
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
                    <h2>Edit Profile</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <br />
                    <form class="form-horizontal form-label-left"
                        action="<?= site_url('user/profile'); ?>"
                        method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="username">
                                Username <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="username" name="username" class="form-control"
                                    value="<?= esc($u['username'] ?? '') ?>" readonly required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="name">
                                Nama Lengkap <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input type="text" id="name" name="name" class="form-control"
                                    value="<?= esc($u['name'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align" for="image">
                                Foto Profil
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <div class="row">
                                    <div class="col-md-3 col-sm-3 mb-2">
                                        <?php
                                        $img = $u['image'] ?? 'icon-user.png';
                                        ?>
                                        <img src="<?= base_url('img/profile/' . $img) ?>"
                                            class="img-thumbnail" alt="profile" />
                                    </div>
                                    <div class="col-md-9 col-sm-9">
                                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                        <small class="text-muted d-block mt-1">Maks 2MB (jpg, jpeg, png, gif)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="current-password" class="col-form-label col-md-3 col-sm-3 label-align">
                                Current Password
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input id="current-password" class="form-control" type="password" name="current-password">
                                <small class="text-success"><i>Kosongkan jika tidak diubah</i></small>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="new-password" class="col-form-label col-md-3 col-sm-3 label-align">
                                New Password
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input id="new-password" class="form-control" type="password" name="new-password">
                                <small class="text-success"><i>Kosongkan jika tidak diubah</i></small>
                            </div>
                        </div>

                        <div class="item form-group">
                            <label for="repeat-password" class="col-form-label col-md-3 col-sm-3 label-align">
                                Repeat Password
                            </label>
                            <div class="col-md-6 col-sm-6">
                                <input id="repeat-password" class="form-control" type="password" name="repeat-password">
                                <small class="text-success"><i>Kosongkan jika tidak diubah</i></small>
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button type="submit" name="submit" class="btn btn-success">Update</button>
                                <a href="<?= site_url('dashboard') ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
                    </form>
                </div><!-- /.x_content -->
            </div>
        </div>
    </div>
</div>