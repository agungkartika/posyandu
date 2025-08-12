<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard/petugas', 'Dashboard::petugas');

$routes->get('user/profile', 'User::profile');
$routes->post('user/profile', 'User::profile'); // form submit pakai method yang sama

$routes->get('user/tambahUser', 'User::tambahUser');
$routes->post('user/tambah', 'User::tambahUserInput');


// Anak module (CI4)
$routes->group('anak',  static function ($routes) {
    $routes->get('/', 'AnakController::index');                       // list
    $routes->post('create', 'AnakController::createDataAnak');        // create
    $routes->get('editDataAnak/(:num)', 'AnakController::editDataAnak/$1');   // form edit
    $routes->post('updateDataAnak/(:num)', 'AnakController::updateDataAnak/$1'); // update
    $routes->match(['get', 'post'], 'deleteDataAnak/(:num)', 'AnakController::deleteDataAnak/$1'); // delete
});

$routes->group('petugas',  static function ($routes) {
    $routes->get('/', 'Petugas::index');
    $routes->post('createDataPetugas', 'Petugas::createDataPetugas');
    $routes->post('updateDataPetugas/(:num)', 'Petugas::updateDataPetugas/$1');
    $routes->match(['get', 'post'], 'deleteDataPetugas/(:num)', 'Petugas::deleteDataPetugas/$1');
});

$routes->group('peserta', static function($routes) {
    $routes->get('dashboard', 'Peserta::anak');
    $routes->get('timbangan', 'Peserta::timbangan');
    $routes->get('imunisasi', 'Peserta::imunisasi');
    $routes->get('vitamin', 'Peserta::vitamin');
    $routes->get('jadwal', 'Peserta::jadwal');
});

$routes->group('penimbangan-anak', static function ($routes) {
    $routes->get('/', 'PenimbanganAnak::index');
    $routes->post('submit', 'PenimbanganAnak::submit');
    $routes->get('data', 'PenimbanganAnak::data');
    $routes->get('edit/(:num)', 'PenimbanganAnak::edit/$1');
    $routes->post('update/(:num)', 'PenimbanganAnak::update/$1');
    $routes->match(['get', 'post'], 'delete/(:num)', 'PenimbanganAnak::delete/$1');
});

$routes->group('imunisasi-anak', static function ($routes) {
    $routes->get('/', 'ImunisasiAnak::index');
    $routes->get('data-imunisasi', 'ImunisasiAnak::data_imunisasi');
    $routes->get('imunisasi', 'ImunisasiAnak::imunisasi');

    $routes->post('submit', 'ImunisasiAnak::submit');
    $routes->post('submit-imun', 'ImunisasiAnak::submit_imun');

    $routes->get('edit/(:num)', 'ImunisasiAnak::edit_data/$1');
    $routes->post('update/(:num)', 'ImunisasiAnak::update/$1');

    $routes->get('delete/(:num)', 'ImunisasiAnak::delete_data/$1');
});

$routes->group('vitamin-anak', static function ($routes) {
    $routes->get('/', 'Vitamin::index');
    $routes->get('data-vitamin', 'Vitamin::data');
    $routes->get('vitamin', 'Vitamin::vitamin');

    $routes->post('submit', 'Vitamin::submit');
    $routes->post('submit-vitamin', 'Vitamin::submit_vitamin');

    $routes->get('edit/(:num)', 'Vitamin::edit/$1');
    $routes->post('update/(:num)', 'Vitamin::update/$1');

    $routes->get('delete/(:num)', 'Vitamin::delete/$1');
});

$routes->group('jadwal-pemeriksaan', static function ($routes) {
    $routes->get('/', 'JadwalPemeriksaan::index');
    $routes->post('create', 'JadwalPemeriksaan::createData');
    $routes->get('delete/(:num)', 'JadwalPemeriksaan::deleteData/$1');
    $routes->post('generate', 'JadwalPemeriksaan::generate');   // <-- this fixes your 404
    $routes->get('cetakdata', 'JadwalPemeriksaan::cetakData');
});

$routes->get('laporan-anak/index', 'LaporanAnak::index');
$routes->get('laporan-anak/cetak/(:num)', 'LaporanAnak::cetakLaporan/$1');
$routes->get('laporan-anak/cetak-semua', 'LaporanAnak::cetakSemua');
$routes->get('laporan-anak/cetak-data-anak', 'LaporanAnak::cetakDataAnak');
