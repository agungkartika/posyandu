<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="<?= base_url('build/img/'); ?>icon-posyandu.png">

    <title>Posyandu Mawar XIII</title>

    <!-- Bootstrap -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?= base_url('vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('vendors/nprogress/nprogress.css') ?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= base_url('vendors/animate.css/animate.min.css') ?>" rel="stylesheet">
    <!-- Toastr alert -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('css/toastr.min.css') ?>">

    <!-- Custom Theme Style -->
    <link href="<?= base_url('css/custom.css') ?>" rel="stylesheet">
</head>

<body>
    <div class="bg-images"></div>
    <div class="bg-text">
        <section class="login_content">
            <form class="user validate-form" action="<?= site_url('login'); ?>" method="post">
                <h1>Silahkan Login</h1>
                <?= csrf_field(); ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="contrast" role="alert"><?= esc(session()->getFlashdata('error')); ?></div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors')): $errors = session()->getFlashdata('errors'); ?>
                    <div class="contrast" role="alert">
                        <?php foreach ($errors as $err): ?>
                            <div><?= esc($err); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username'); ?>" required autofocus>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-danger btn-user btn-block">Login</button>
                <div class="clearfix"></div>

                <div class="separator">
                    <div class="clearfix"></div>
                    <br />

                    <div>
                        <span>Copyright &copy; Posyandu Mawar XIII<?= date('Y'); ?></span>
                    </div>
                </div>
            </form>
        </section>
    </div>
</body>

</html>