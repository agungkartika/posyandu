<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css" />
</head>

<body>
    <main class="container">
        <article class="card" style="max-width:420px;margin:8vh auto;">
            <header>
                <h3>Masuk</h3>
            </header>
            <form action="<?= site_url('login'); ?>" method="post">
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

                <label>
                    Username
                    <input type="text" name="username" value="<?= old('username'); ?>" required autofocus />
                </label>

                <label>
                    Password
                    <input type="password" name="password" required />
                </label>

                <button type="submit">Login</button>
            </form>
        </article>
    </main>
</body>

</html>