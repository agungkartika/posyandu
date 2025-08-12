<?php
// application/views/templates/sidebar-peserta.php
?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?= base_url('peserta/dashboard'); ?>" class="site_title"><i class="fa fa-heartbeat"></i> <span>Posyandu Mawar</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?= base_url('img/profile/' . ($user['image'] ?? 'default.png')) ?>"class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Selamat Datang,</span>
                <h2><?= $user['name']; ?></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Menu Peserta</h3>
                <ul class="nav side-menu">
                    <li><a href="<?= base_url('peserta/dashboard'); ?>"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a href="<?= base_url('peserta/anak'); ?>"><i class="fa fa-child"></i> Data Anak</a></li>
                    <li><a href="<?= base_url('peserta/imunisasi'); ?>"><i class="fa fa-medkit"></i> Imunisasi</a></li>
                    <li><a href="<?= base_url('peserta/vitamin'); ?>"><i class="fa fa-plus"></i> Vitamin</a></li>
                    <li><a href="<?= base_url('peserta/timbangan'); ?>"><i class="fa fa-balance-scale"></i> Penimbangan</a></li>
                    <li><a href="<?= base_url('peserta/jadwal'); ?>"><i class="fa fa-calendar"></i> Jadwal Pemeriksaan</a></li>
                    <li><a href="<?= base_url('user/profile'); ?>"><i class="fa fa-user"></i> Profil</a></li>
                    <li><a href="<?= base_url('logout'); ?>" class="tbl-logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>
