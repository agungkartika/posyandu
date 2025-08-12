-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Agu 2025 pada 12.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anak`
--

CREATE TABLE `anak` (
  `id_anak` int(11) NOT NULL,
  `nik_anak` varchar(16) NOT NULL,
  `nama_anak` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `umur` int(11) NOT NULL,
  `anakKe` int(11) NOT NULL,
  `orang_tua` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ibu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `anak`
--

INSERT INTO `anak` (`id_anak`, `nik_anak`, `nama_anak`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `umur`, `anakKe`, `orang_tua`, `user_id`, `ibu_id`) VALUES
(15, '3543534534534123', 'james bond', 'amerika serikat', '2022-08-05', 'Laki-Laki', 412, 0, 'Kunti', 0, 2),
(16, '123456789_______', 'Arianto', 'Marelan Pasar 2', '1994-08-28', 'Laki-Laki', 0, 0, 'gundo', 0, 4),
(19, '34333333333_____', 'siti', 'jakarta', '2025-06-10', 'Perempuan', 20, 20, 'Hamidah', 0, 0),
(22, '23213213213213__', 'wqdasdas', 'dasdas', '2001-12-23', 'Laki-Laki', 10, 2, 'asas', 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidan`
--

CREATE TABLE `bidan` (
  `id_bidan` int(11) NOT NULL,
  `nama_bidan` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `pendidikan_terakhir` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bidan`
--

INSERT INTO `bidan` (`id_bidan`, `nama_bidan`, `tempat_lahir`, `tanggal_lahir`, `no_hp`, `pendidikan_terakhir`, `user_id`) VALUES
(3, 'nuraida2', 'binjai', '2022-08-03', '0945-8458-364', 'S2', 1),
(4, 'Suhesi', 'Lombok', '1986-09-12', '0834-5943-594', 'D3', 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ibu`
--

CREATE TABLE `ibu` (
  `id_ibu` int(11) NOT NULL,
  `nama_ibu` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `gol_dar` varchar(2) NOT NULL,
  `pendidikan` varchar(200) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `nama_suami` varchar(50) NOT NULL,
  `tempat_lahir_suami` varchar(30) NOT NULL,
  `tgl_lahir_suami` date NOT NULL,
  `pendidikan_suami` varchar(200) NOT NULL,
  `pekerjaan_suami` varchar(30) NOT NULL,
  `alamat` text NOT NULL,
  `kecamatan` varchar(30) NOT NULL,
  `kota` varchar(30) NOT NULL,
  `no_tlp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `ibu`
--

INSERT INTO `ibu` (`id_ibu`, `nama_ibu`, `tempat_lahir`, `tgl_lahir`, `gol_dar`, `pendidikan`, `pekerjaan`, `nama_suami`, `tempat_lahir_suami`, `tgl_lahir_suami`, `pendidikan_suami`, `pekerjaan_suami`, `alamat`, `kecamatan`, `kota`, `no_tlp`) VALUES
(2, 'Linda3', 'Karawang', '1987-09-20', 'S', 's1', 'Ibu Rumah Tangga', 'Waluyu Santoso', 'Blora', '1985-03-08', 'SMK', 'Karyawan Swasta', 'Jl. Sukapura Jaya RT 04/010', 'Cilincing', 'Jakarta Utara', '0822-7402-739'),
(3, 'Faridah Hanum', 'marelan', '2022-08-06', 'B', 'smp', 'rumah tangga', 'dahrul', 'medan', '2022-08-31', 'SD', 'Ahli Strategi', 'medan, belawan hamparan perak Jl.Desa Lama Dusun 2, medan, belawan hamparan perak Jl.Desa Lama Dusun 2', 'hamparan perak', 'belawan', '0822-7402-739'),
(4, 'Siti Aisyah', 'Medan', '1986-08-20', 'O', 'D3', 'Rumah tangga', 'Akbar Hanavi', 'Jakarta', '1984-07-20', 'S1', 'PNS', 'Marelan', 'Hamparan Perak', 'Medan', '0852-9673-123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `imunisasi`
--

CREATE TABLE `imunisasi` (
  `id_imunisasi` int(11) NOT NULL,
  `anak_id` int(11) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `ibu_id` int(11) NOT NULL,
  `tgl_skrng` date NOT NULL,
  `usia` int(11) NOT NULL,
  `imunisasi` varchar(30) NOT NULL,
  `vit_a` enum('Merah','Biru') NOT NULL,
  `ket` text NOT NULL,
  `jenis_imunisasi` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `imunisasi`
--

INSERT INTO `imunisasi` (`id_imunisasi`, `anak_id`, `tgl_lahir`, `jenis_kelamin`, `ibu_id`, `tgl_skrng`, `usia`, `imunisasi`, `vit_a`, `ket`, `jenis_imunisasi`, `created_by`) VALUES
(15, 15, '0000-00-00', 'Laki-Laki', 0, '2025-06-21', 0, '', 'Merah', '', 'BCG', 1),
(17, 22, '0000-00-00', 'Laki-Laki', 0, '2025-08-12', 0, '', 'Merah', '', 'Polio', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id` int(11) NOT NULL,
  `id_anak` int(11) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `durasi_pemeriksaan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id`, `id_anak`, `tanggal_mulai`, `tanggal_selesai`, `waktu_mulai`, `waktu_selesai`, `durasi_pemeriksaan`) VALUES
(7, 20, '2025-06-27', '2025-06-28', '09:08:00', '10:08:00', 5),
(8, 19, '2025-06-12', '2025-06-12', '07:22:00', '08:23:00', 20),
(9, 16, '2025-06-28', '2025-06-28', '10:29:00', '11:29:00', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pemeriksaan`
--

CREATE TABLE `jadwal_pemeriksaan` (
  `id_jadwal_pemeriksaan` int(11) NOT NULL,
  `id_anak` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `jadwal_pemeriksaan`
--

INSERT INTO `jadwal_pemeriksaan` (`id_jadwal_pemeriksaan`, `id_anak`, `tanggal`, `jam`, `id_petugas`) VALUES
(3, 15, '2025-06-30', '09:11:00', 2),
(4, 16, '2025-06-30', '07:18:00', 4),
(5, 0, '2025-08-15', '09:00:00', 0),
(6, 0, '2025-08-15', '10:00:00', 0),
(7, 0, '2025-08-15', '09:00:00', 0),
(8, 0, '2025-08-15', '10:00:00', 0),
(9, 0, '2025-08-15', '09:00:00', 0),
(10, 0, '2025-08-15', '10:00:00', 0),
(11, 15, '2025-08-01', '00:32:00', 3),
(12, 16, '2025-08-01', '00:47:00', 2),
(13, 19, '2025-08-01', '01:02:00', 3),
(14, 15, '2026-02-01', '23:56:00', 3),
(15, 16, '2026-02-01', '00:11:00', 2),
(16, 19, '2026-02-01', '00:26:00', 2),
(17, 15, '2025-08-12', '01:22:00', 2),
(18, 16, '2025-08-12', '01:37:00', 3),
(19, 19, '2025-08-12', '01:52:00', 2),
(20, 15, '2025-08-11', '19:06:00', 3),
(21, 16, '2025-08-11', '19:36:00', 2),
(22, 19, '2025-08-11', '20:06:00', 3),
(23, 15, '2026-12-21', '15:01:00', 2),
(24, 16, '2026-12-21', '15:16:00', 2),
(25, 19, '2026-12-21', '15:31:00', 2),
(26, 22, '2026-12-21', '15:46:00', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kader`
--

CREATE TABLE `kader` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kader`
--

INSERT INTO `kader` (`id`, `nama`) VALUES
(1, 'Kader A'),
(2, 'Kader B'),
(3, 'Kader C'),
(4, 'Kader D');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `user_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `login_attempts`
--

INSERT INTO `login_attempts` (`user_id`, `date_time`) VALUES
(1, '2021-01-30 10:23:29'),
(1, '2021-01-30 10:34:46'),
(1, '2021-01-30 10:43:56'),
(1, '2021-01-31 02:28:21'),
(1, '2021-01-31 03:22:35'),
(1, '2021-01-31 09:10:44'),
(1, '2021-01-31 09:26:10'),
(1, '2021-01-31 09:29:54'),
(1, '2021-01-31 09:30:32'),
(1, '2021-02-03 01:44:40'),
(1, '2021-02-05 07:31:28'),
(2, '2021-02-07 11:30:13'),
(1, '2021-02-07 12:51:05'),
(2, '2021-02-07 01:55:44'),
(1, '2021-02-07 01:56:42'),
(1, '2021-02-07 02:20:01'),
(2, '2021-02-07 02:26:00'),
(2, '2021-02-07 05:10:55'),
(1, '2021-02-07 05:12:08'),
(2, '2021-02-07 05:20:27'),
(1, '2021-02-07 05:21:00'),
(1, '2021-02-07 08:28:31'),
(1, '2021-02-07 09:37:56'),
(1, '2021-02-11 03:17:12'),
(1, '2021-02-11 03:21:59'),
(1, '2021-02-11 09:34:17'),
(1, '2021-02-11 09:50:11'),
(1, '2021-02-12 07:32:48'),
(1, '2021-02-12 10:15:28'),
(1, '2021-02-12 10:44:02'),
(1, '2022-08-14 01:07:07'),
(1, '2022-08-14 02:28:11'),
(1, '2022-08-14 02:33:31'),
(2, '2022-08-14 05:29:47'),
(1, '2022-08-14 05:30:08'),
(2, '2022-08-14 06:49:13'),
(1, '2022-08-14 07:02:59'),
(8, '2022-08-14 07:42:09'),
(1, '2022-08-14 08:08:27'),
(1, '2022-08-14 07:21:05'),
(9, '2022-08-14 07:23:03'),
(9, '2022-08-15 07:46:49'),
(9, '2022-08-15 07:50:37'),
(1, '2022-08-20 06:05:34'),
(1, '2022-09-21 07:12:27'),
(1, '2022-09-23 07:12:18'),
(1, '2022-10-01 11:40:20'),
(1, '2025-06-09 02:30:12'),
(1, '2025-06-09 03:57:05'),
(1, '2025-06-09 04:00:59'),
(1, '2025-06-26 02:05:58'),
(1, '2025-06-26 02:26:28'),
(1, '2025-06-26 03:44:38'),
(1, '2025-06-26 03:48:17'),
(1, '2025-06-27 01:17:06'),
(1, '2025-06-27 01:18:15'),
(1, '2025-06-27 01:46:14'),
(1, '2025-06-30 03:59:33'),
(1, '2021-01-30 10:23:29'),
(1, '2021-01-30 10:34:46'),
(1, '2021-01-30 10:43:56'),
(1, '2021-01-31 02:28:21'),
(1, '2021-01-31 03:22:35'),
(1, '2021-01-31 09:10:44'),
(1, '2021-01-31 09:26:10'),
(1, '2021-01-31 09:29:54'),
(1, '2021-01-31 09:30:32'),
(1, '2021-02-03 01:44:40'),
(1, '2021-02-05 07:31:28'),
(2, '2021-02-07 11:30:13'),
(1, '2021-02-07 12:51:05'),
(2, '2021-02-07 01:55:44'),
(1, '2021-02-07 01:56:42'),
(1, '2021-02-07 02:20:01'),
(2, '2021-02-07 02:26:00'),
(2, '2021-02-07 05:10:55'),
(1, '2021-02-07 05:12:08'),
(2, '2021-02-07 05:20:27'),
(1, '2021-02-07 05:21:00'),
(1, '2021-02-07 08:28:31'),
(1, '2021-02-07 09:37:56'),
(1, '2021-02-11 03:17:12'),
(1, '2021-02-11 03:21:59'),
(1, '2021-02-11 09:34:17'),
(1, '2021-02-11 09:50:11'),
(1, '2021-02-12 07:32:48'),
(1, '2021-02-12 10:15:28'),
(1, '2021-02-12 10:44:02'),
(1, '2022-08-14 01:07:07'),
(1, '2022-08-14 02:28:11'),
(1, '2022-08-14 02:33:31'),
(2, '2022-08-14 05:29:47'),
(1, '2022-08-14 05:30:08'),
(2, '2022-08-14 06:49:13'),
(1, '2022-08-14 07:02:59'),
(8, '2022-08-14 07:42:09'),
(1, '2022-08-14 08:08:27'),
(1, '2022-08-14 07:21:05'),
(9, '2022-08-14 07:23:03'),
(9, '2022-08-15 07:46:49'),
(9, '2022-08-15 07:50:37'),
(1, '2022-08-20 06:05:34'),
(1, '2022-09-21 07:12:27'),
(1, '2022-09-23 07:12:18'),
(1, '2022-10-01 11:40:20'),
(1, '2025-06-09 02:30:12'),
(1, '2025-06-09 03:57:05'),
(1, '2025-06-09 04:00:59'),
(1, '2025-06-26 02:05:58'),
(1, '2025-06-26 02:26:28'),
(1, '2025-06-26 03:44:38'),
(1, '2025-06-26 03:48:17'),
(1, '2025-06-27 01:17:06'),
(1, '2025-06-27 01:18:15'),
(1, '2025-06-27 01:46:14'),
(1, '2025-06-30 03:59:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penimbangan`
--

CREATE TABLE `penimbangan` (
  `id_penimbangan` int(11) NOT NULL,
  `anak_id` int(11) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `ibu_id` int(11) NOT NULL,
  `tgl_skrng` date NOT NULL,
  `usia` int(11) NOT NULL,
  `bb` double NOT NULL,
  `tb` double NOT NULL,
  `deteksi` enum('Sesuai','Tidak Sesuai') NOT NULL,
  `kategori` text NOT NULL,
  `keterangan` text NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `penimbangan`
--

INSERT INTO `penimbangan` (`id_penimbangan`, `anak_id`, `tgl_lahir`, `jenis_kelamin`, `ibu_id`, `tgl_skrng`, `usia`, `bb`, `tb`, `deteksi`, `kategori`, `keterangan`, `created_by`) VALUES
(10, 15, '0000-00-00', 'Laki-Laki', 0, '2025-06-26', 31, 1, 2, 'Sesuai', 'N', '', 1),
(11, 19, '0000-00-00', 'Perempuan', 0, '2025-06-26', 20, 1, 1213, 'Sesuai', 'O', '', 2),
(13, 19, '0000-00-00', 'Perempuan', 0, '2025-06-28', 20, 1, 2.4, 'Sesuai', 'T', '', 1),
(16, 22, '0000-00-00', 'Laki-Laki', 0, '2023-12-03', 10, 123, 21, 'Sesuai', 'N', 'asdasd', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(50) NOT NULL,
  `tempat_lahir` varchar(30) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `jabatan` enum('Ketua','Bendahara','Sekretaris','Anggota') NOT NULL,
  `pendidikan_terakhir` varchar(30) NOT NULL,
  `lama_kerja` int(11) NOT NULL,
  `tugas_pokok` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `tempat_lahir`, `tgl_lahir`, `no_hp`, `jabatan`, `pendidikan_terakhir`, `lama_kerja`, `tugas_pokok`, `user_id`) VALUES
(2, 'bayuasd', 'marelan', '2022-08-20', '0852-9735-267', 'Bendahara', 'SMA', 2, 'jaga harimau', 0),
(3, 'joko', 'medan', '2022-08-25', '3434-3434-343', 'Ketua', 'S1', 123, 'mencabut bulu dada', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_users` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_users`, `name`, `username`, `image`, `password`, `level_id`, `is_active`, `date_created`) VALUES
(1, 'Putri Nugraheni', 'punug', 'icon-02.png', '$2y$12$uvFfTJK6QaQnBzWfBaLfXuKaLTiTFbisBmrm7uH5j9wsrfFr4PGfu', 2, 1, 0),
(2, 'Lutfiana', 'fia', 'icon-02.png', '$2y$12$uvFfTJK6QaQnBzWfBaLfXuKaLTiTFbisBmrm7uH5j9wsrfFr4PGfu', 1, 1, 111),
(8, 'bayu setiawan', 'bayus90', 'icon-02.png', '$2y$12$uvFfTJK6QaQnBzWfBaLfXuKaLTiTFbisBmrm7uH5j9wsrfFr4PGfu', 2, 1, 1660437715),
(9, 'Bayu Setiawan', 'm90', 'pexels-engin-akyurt-2098602.jpg', '123456', 2, 1, 1660479768),
(10, 'asdasd', 'asdasd', '1754943748_750f9e4b523865bb3e45.jpg', '$2y$10$ymv0sEWQx5fjzEoC1.nnEO/XrzrZjU1NO94hPougYVEn2ONj3BHey', 2, 1, 1754943748);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_level`
--

CREATE TABLE `users_level` (
  `id_level` int(11) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users_level`
--

INSERT INTO `users_level` (`id_level`, `level`) VALUES
(1, 'Petugas'),
(2, 'Peserta');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vitamin`
--

CREATE TABLE `vitamin` (
  `id_vitamin` int(11) NOT NULL,
  `anak_id` int(11) NOT NULL,
  `tanggal_pemberian` date NOT NULL,
  `jenis_vitamin` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `vitamin`
--

INSERT INTO `vitamin` (`id_vitamin`, `anak_id`, `tanggal_pemberian`, `jenis_vitamin`, `created_by`) VALUES
(1, 16, '2025-06-27', 'C', 1),
(2, 15, '2025-06-27', 'A', 1),
(5, 16, '2025-08-12', 'C', 2),
(6, 22, '2025-08-12', 'A', 2);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anak`
--
ALTER TABLE `anak`
  ADD PRIMARY KEY (`id_anak`);

--
-- Indeks untuk tabel `bidan`
--
ALTER TABLE `bidan`
  ADD PRIMARY KEY (`id_bidan`);

--
-- Indeks untuk tabel `ibu`
--
ALTER TABLE `ibu`
  ADD PRIMARY KEY (`id_ibu`);

--
-- Indeks untuk tabel `imunisasi`
--
ALTER TABLE `imunisasi`
  ADD PRIMARY KEY (`id_imunisasi`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_pemeriksaan`
--
ALTER TABLE `jadwal_pemeriksaan`
  ADD PRIMARY KEY (`id_jadwal_pemeriksaan`);

--
-- Indeks untuk tabel `kader`
--
ALTER TABLE `kader`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penimbangan`
--
ALTER TABLE `penimbangan`
  ADD PRIMARY KEY (`id_penimbangan`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_users`),
  ADD KEY `level_id` (`level_id`);

--
-- Indeks untuk tabel `users_level`
--
ALTER TABLE `users_level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `vitamin`
--
ALTER TABLE `vitamin`
  ADD PRIMARY KEY (`id_vitamin`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anak`
--
ALTER TABLE `anak`
  MODIFY `id_anak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `bidan`
--
ALTER TABLE `bidan`
  MODIFY `id_bidan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `ibu`
--
ALTER TABLE `ibu`
  MODIFY `id_ibu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `imunisasi`
--
ALTER TABLE `imunisasi`
  MODIFY `id_imunisasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `jadwal_pemeriksaan`
--
ALTER TABLE `jadwal_pemeriksaan`
  MODIFY `id_jadwal_pemeriksaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `kader`
--
ALTER TABLE `kader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penimbangan`
--
ALTER TABLE `penimbangan`
  MODIFY `id_penimbangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_users` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users_level`
--
ALTER TABLE `users_level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `vitamin`
--
ALTER TABLE `vitamin`
  MODIFY `id_vitamin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
