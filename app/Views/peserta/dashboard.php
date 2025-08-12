<!-- page content -->
<div class="right_col" role="main">
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4 px-2">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-child"></i></div>
                <div class="count"><?= (int) ($count_anak ?? 0); ?></div>
                <h3>Anak Terdaftar</h3>
                <p>Data anak milik Anda</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4 px-2">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-medkit"></i></div>
                <!-- Imunisasi -->
                <div class="count"><?= (int) ($count_imunisasi ?? 0); ?></div>
                <h3>Imunisasi</h3>
                <p>Data imunisasi anak Anda</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4 px-2">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-leaf"></i></div>
                <div class="count"><?= (int) ($count_vitamin ?? 0); ?></div>
                <h3>Vitamin</h3>
                <p>Data vitamin anak Anda</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4 px-2">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-balance-scale"></i></div>
                <div class="count"><?= (int) ($count_timbangan ?? 0); ?></div>
                <h3>Timbangan</h3>
                <p>Data hasil penimbangan</p>
            </div>
        </div>

        <div class="animated flipInY col-lg-4 col-md-6 col-sm-6 col-xs-12 mb-4 px-2">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-calendar"></i></div>
                <div class="count"><?= (int) ($count_jadwal ?? 0); ?></div>
                <h3>Jadwal Pemeriksaan</h3>
                <p>Jadwal pemeriksaan yang tersedia</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Dashboard <small>Peserta</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="bs-example" data-example-id="simple-jumbotron">
                    <div class="jumbotron">
                        <?php
                        $displayName = $user['name'] ?? ($user['username'] ?? 'Peserta');
                        ?>
                        <h3>Selamat datang, <?= esc($displayName) ?></h3>

                        <p>Anda dapat melihat data pertumbuhan dan layanan Posyandu untuk anak Anda melalui menu yang tersedia.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>