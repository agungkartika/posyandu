<div class="col-md-3 left_col sidebar_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a class="site_title"><span>POSYANDU</span></a>
        </div>

        <div class="clearfix"></div>
        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <?php
            $auth  = session()->get('auth') ?? [];
            $level = (int) ($auth['level_id'] ?? 0);
            ?>

            <?php if ($level == 1): // ADMIN 
            ?>
                <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?= base_url('dashboard/petugas') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                    </ul>
                </div>

                <div class="menu_section">
                    <h3>Master Data</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?= base_url('anak') ?>"><i class="fa fa-child"></i> Data Anak</a></li>
                        <li><a href="<?= base_url('petugas') ?>"><i class="fa fa-users"></i> Data Kader</a></li>
                    </ul>
                </div>

                <div class="menu_section">
                    <h3>Layanan</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?= base_url('penimbangan-anak/data') ?>"><i class="fa fa-list"></i> Timbangan Anak</a></li>
                        <li><a href="<?= base_url('imunisasi-anak/data-imunisasi') ?>"><i class="fa fa-plus-square"></i> Imunisasi</a></li>
                        <li><a href="<?= base_url('vitamin-anak/data-vitamin') ?>"><i class="fa fa-plus-square"></i> Vitamin Anak</a></li>
                        <li><a href="<?= base_url('jadwal-pemeriksaan') ?>"><i class="fa fa-pencil"></i> Jadwal Pemeriksaan</a></li>
                    </ul>
                </div>

                <div class="menu_section">
                    <h3>Laporan</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?= base_url('laporan-anak/index') ?>"><i class="fa fa-file-pdf-o"></i> Laporan Anak</a></li>
                    </ul>
                </div>

            <?php elseif ($level == 2): // PESERTA 
            ?>
                <div class="menu_section">
                    <h3>Dashboard</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?= base_url('peserta/dashboard') ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                    </ul>
                </div>

                <div class="menu_section">
                    <h3>Layanan</h3>
                    <ul class="nav side-menu">
                        <li><a href="<?= base_url('peserta/timbangan') ?>"><i class="fa fa-balance-scale"></i> Timbangan Anak</a></li>
                        <li><a href="<?= base_url('peserta/imunisasi') ?>"><i class="fa fa-medkit"></i> Imunisasi</a></li>
                        <li><a href="<?= base_url('peserta/vitamin') ?>"><i class="fa fa-leaf"></i> Vitamin Anak</a></li>
                        <li><a href="<?= base_url('peserta/jadwal') ?>"><i class="fa fa-calendar"></i> Jadwal Pemeriksaan</a></li>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>