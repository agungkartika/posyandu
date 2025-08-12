<h2>Selamat datang, <?= $this->session->userdata('name') ?></h2>

<ul>
  <li><a href="<?= base_url('peserta/timbangan') ?>">Layanan Timbangan Anak</a></li>
  <li><a href="<?= base_url('peserta/imunisasi') ?>">Data Imunisasi</a></li>
  <li><a href="<?= base_url('peserta/vitamin') ?>">Vitamin Anak</a></li>
  <li><a href="<?= base_url('peserta/jadwal') ?>">Jadwal Pemeriksaan</a></li>
</ul>
