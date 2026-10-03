-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260910.b4a124aefc
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Okt 2026 pada 02.55
-- Versi server: 8.4.11
-- Versi PHP: 8.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `e_apbdesa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `audit_logs`
--
CREATE TABLE `audit_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `aktivitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `record_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja`
--
CREATE TABLE `belanja` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `bidang_id` bigint UNSIGNED DEFAULT NULL,
  `kegiatan_id` bigint UNSIGNED DEFAULT NULL,
  `belanja_rekening_id` bigint UNSIGNED DEFAULT NULL,
  `sub_kegiatan_id` bigint UNSIGNED DEFAULT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(18,2) NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `belanja`
--

INSERT INTO `belanja` (`id`, `tahun_anggaran_id`, `bidang_id`, `kegiatan_id`, `belanja_rekening_id`, `sub_kegiatan_id`, `kode`, `uraian`, `anggaran`, `urutan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 1, 4, NULL, '5.1.1.01', 'Penghasilan Tetap Kepala Desa', 65000000.00, 0, 'dipublikasikan', '2026-09-30 07:05:51', '2026-10-02 04:04:24'),
(4, 1, 3, 18, 59, NULL, '5.2.2.05', 'Belanja Jasa Honorarium Petugas', 6000000.00, 0, 'dipublikasikan', '2026-09-30 07:49:54', '2026-09-30 07:53:14'),
(5, 1, 2, 1, 5, NULL, '5.1.1.02', 'Tunjangan Kepala Desa', 45000000.00, 0, 'dipublikasikan', '2026-10-02 13:26:06', '2026-10-02 13:26:06'),
(6, 1, 2, 2, 9, NULL, '5.1.2.01', 'Penghasilan Tetap Perangkat Desa', 500000000.00, 0, 'dipublikasikan', '2026-10-02 13:27:13', '2026-10-02 13:27:24'),
(7, 1, 2, 252, 59, NULL, '5.2.2.05', 'Belanja Jasa Honorarium Petugas', 5000000.00, 0, 'dipublikasikan', '2026-10-02 13:44:29', '2026-10-02 13:44:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja_rekenings`
--
CREATE TABLE `belanja_rekenings` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `level` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `belanja_rekenings`
--

INSERT INTO `belanja_rekenings` (`id`, `kode`, `uraian`, `parent_id`, `level`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '5', '', NULL, 1, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(2, '5.1', 'Belanja Pegawai', 1, 2, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(3, '5.1.1', 'Penghasilan Tetap dan Tunjangan Kepala Desa', 2, 3, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(4, '5.1.1.01', 'Penghasilan Tetap Kepala Desa', 3, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(5, '5.1.1.02', 'Tunjangan Kepala Desa', 3, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(6, '5.1.1.90', 'Tunjangan Hari Raya Kepala Desa', 3, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(7, '5.1.1.99', 'Penerimaan Lain-lain Kepala Desa yang Sah', 3, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(8, '5.1.2', 'Penghasilan Tetap dan Tunjangan Perangkat Desa', 2, 3, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(9, '5.1.2.01', 'Penghasilan Tetap Perangkat Desa', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(10, '5.1.2.02', 'Tunjangan Perangkat Desa', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(11, '5.1.2.90', 'Tunjangan Hari Raya Perangkat Desa', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(12, '5.1.2.91', 'Penghasilan Tetap Staf Perangkat Desa', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(13, '5.1.2.92', 'Tunjangan Staf Perangkat Desa', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(14, '5.1.2.93', 'Tunjangan Hari Raya Staf Perangkat Desa', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(15, '5.1.2.94', 'Penghasilan Tetap Staf BPD', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(16, '5.1.2.95', 'Tunjangan Staf BPD', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(17, '5.1.2.96', 'Tunjangan Hari Raya Staf BPD', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(18, '5.1.2.99', 'Penerimaan Lain-lain Perangkat Desa yang Sah', 8, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(19, '5.1.3', 'Jaminan Sosial Kepala Desa dan Perangkat Desa', 2, 3, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(20, '5.1.3.01', 'Jaminan Kesehatan Kepala Desa', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(21, '5.1.3.02', 'Jaminan Kesehatan Perangkat Desa', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(22, '5.1.3.03', 'Jaminan Ketenagakerjaan Kepala Desa', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(23, '5.1.3.04', 'Jaminan Ketenagakerjaan Perangkat Desa', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(24, '5.1.3.90', 'Jaminan Ketenagakerjaan Staf Perangkat Desa', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(25, '5.1.3.91', 'Jaminan Ketenagakerjaan Staf BPD', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(26, '5.1.3.99', 'jaminan Sosial Lainnya', 19, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(27, '5.1.4', 'Tunjangan BPD', 2, 3, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(28, '5.1.4.01', 'Tunjangan Kedudukan BPD', 27, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(29, '5.1.4.02', 'Tunjangan Kinerja BPD', 27, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(30, '5.1.4.90', 'Tunjangan Hari Raya BPD', 27, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(31, '5.1.4.91', 'Jaminan Ketenagakerjaan BPD', 27, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(32, '5.1.4.99', 'Jaminan Sosial Lainnya', 27, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(33, '5.1.5', 'Jaminan Sosial BPD', 2, 3, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(34, '5.1.5.01', 'Jaminan Kesehatan Anggota BPD', 33, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(35, '5.1.5.02', 'Jaminan Ketenagakerjaan Anggota BPD', 33, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(36, '5.2', 'Belanja Barang dan Jasa', 1, 2, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(37, '5.2.1', 'Belanja Barang Perlengkapan', 36, 3, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(38, '5.2.1.01', 'Belanja Alat Tulis Kantor dan Benda Pos', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(39, '5.2.1.02', 'Belanja Perlengkapan Alat-alat Listrik', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(40, '5.2.1.03', 'Belanja Perlengkapan Alat Rumah Tangga dan Bahan Kebersihan', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(41, '5.2.1.04', 'Belanja Bahan Bakar Minyak/Gas/Isi Ulang Tabung Pemadam Kebakaran', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(42, '5.2.1.05', 'Belanja Barang Cetak dan Penggandaan', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(43, '5.2.1.06', 'Belanja Barang Konsumsi (Makan/Minum)', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(44, '5.2.1.07', 'Belanja Bahan Material', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(45, '5.2.1.08', 'Belanja Bendera/Umbul-umbul/Spanduk', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(46, '5.2.1.09', 'Belanja Pakaian Dinas/Seragam/Atribut', 37, 4, 1, '2026-09-30 06:59:14', '2026-09-30 06:59:14'),
(47, '5.2.1.10', 'Belanja Bahan Obat-obatan', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(48, '5.2.1.11', 'Belanja Pakan Hewan, Obat-obatan Hewan', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(49, '5.2.1.12', 'Belanja Pupuk/Obat-obatan Pertanian', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(50, '5.2.1.90', 'Belanja Hadiah Berupa Barang untuk lomba-lomba', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(51, '5.2.1.91', 'Belanja Hadiah Berupa Uang untuk lomba-lomba', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(52, '5.2.1.92', 'Belanja Bibit Perikanan/Perkebunan/Peternakan dan Pertanian', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(53, '5.2.1.99', 'Belanja Barang Perlengkapan Lainnya', 37, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(54, '5.2.2', 'Belanja Jasa Honorarium', 36, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(55, '5.2.2.01', 'Belanja Jasa Honorarium Tim Pelaksana Kegiatan', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(56, '5.2.2.02', 'Belanja Jasa Honorarium Pembantu Tugas Umum Desa/Operator', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(57, '5.2.2.03', 'Belanja Jasa Honorarium/Insentif Pelayanan Desa', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(58, '5.2.2.04', 'Belanja Jasa Honorarium Tenaga Ahli/Profesi/Konsultan/Narasumber', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(59, '5.2.2.05', 'Belanja Jasa Honorarium Petugas', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(60, '5.2.2.06', 'Belanja Jasa Honorarium PKPKD dan PPKD', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(61, '5.2.2.07', 'Belanja Jasa Honorarium Staf Administrasi BPD', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(62, '5.2.2.08', 'Belanja Jasa Uang Saku Pelatihan/Seminar/Bimbingan Teknis', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(63, '5.2.2.90', 'Belanja Honorarium Petugas Pendata PBB', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(64, '5.2.2.91', 'Belanja Jasa Honorarium Pengelola Aset Desa', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(65, '5.2.2.92', 'Belanja Honorarium Tim Penyertaan Modal Desa', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(66, '5.2.2.93', 'Belanja Honorarium TIM Penyusun RPJMDesa', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(67, '5.2.2.94', 'Belanja Honorarium TIM Penyusun RKPDesa', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(68, '5.2.2.95', 'Belanja Honorarium Petugas Sopir Ambulance Desa', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(69, '5.2.2.96', 'Belanja Honorarium Petugas', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(70, '5.2.2.99', 'Belanja Jasa Honorarium Lainnya', 54, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(71, '5.2.3', 'Belanja Perjalanan Dinas', 36, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(72, '5.2.3.01', 'Belanja Perjalanan Dinas Dalam Kabupaten/Kota', 71, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(73, '5.2.3.02', 'Belanja Perjalanan Dinas Luar Kabupaten/Kota', 71, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(74, '5.2.3.03', 'Belanja Kursus Pelatihan', 71, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(75, '5.2.4', 'Belanja Jasa Sewa', 36, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(76, '5.2.4.01', 'Belanja Jasa Sewa Bangunan/Gedung/Ruang', 75, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(77, '5.2.4.02', 'Belanja Jasa Sewa Peralatan/Perlengkapan', 75, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(78, '5.2.4.03', 'Belanja Jasa Sewa Sarana Mobilitas', 75, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(79, '5.2.4.99', 'Belanja Jasa Sewa Lainnya', 75, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(80, '5.2.5', 'Belanja Operasional Perkantoran', 36, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(81, '5.2.5.01', 'Belanja Jasa Langganan Listrik', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(82, '5.2.5.02', 'Belanja Jasa Langganan Air Bersih', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(83, '5.2.5.03', 'Belanja Jasa Langganan Majalah/Surat Kabar', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(84, '5.2.5.04', 'Belanja Jasa Langganan Telepon', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(85, '5.2.5.05', 'Belanja Jasa Langganan Internet', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(86, '5.2.5.06', 'Belanja Jasa Kurir/Pos/Giro', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(87, '5.2.5.07', 'Belanja Jasa Perpanjangan Ijin/Pajak', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(88, '5.2.5.08', 'Belanja Insentif/Operasional RT/RW', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(89, '5.2.5.90', 'Belanja Jasa Transaksi Keuangan ( Admin Bank Dll)', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(90, '5.2.5.91', 'Belanja Sertifikasi', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(91, '5.2.5.92', 'Belanja Dekorasi dan Dokumentasi', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(92, '5.2.5.99', 'Belanja Operasional Perkantoran lainnya', 80, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(93, '5.2.6', 'Belanja Pemeliharaan', 36, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(94, '5.2.6.01', 'Belanja Pemeliharaan Mesin dan Peralatan Berat', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(95, '5.2.6.02', 'Belanja Pemeliharaan Kendaraan Bermotor', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(96, '5.2.6.03', 'Belanja Pemeliharaan Peralatan', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(97, '5.2.6.04', 'Belanja Pemeliharaan Bangunan', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(98, '5.2.6.05', 'Belanja Pemeliharaan Jalan', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(99, '5.2.6.06', 'Belanja Pemeliharaan Jembatan', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(100, '5.2.6.07', 'Belanja Pemeliharaan Irigasi/Saluran Sungai/Embung/Air Bersih', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(101, '5.2.6.08', 'Belanja Pemeliharaan Jaringan dan Instalasi (Listrik, telepon, internet, komunikasi dll)', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(102, '5.2.6.99', 'Belanja Pemeliharaan Lainnya', 93, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(103, '5.2.7', 'Belanja Barang dan Jasa yang Diserahkan kepada Masyarakat', 36, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(104, '5.2.7.01', 'Belanja Bahan Perlengkapan untuk Diserahkan kepada Masyarakat', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(105, '5.2.7.02', 'Belanja Bantuan Mesin/Peralatan/Kendaraan untuk Diserahkan kepada Masyarakat', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(106, '5.2.7.03', 'Belanja Bantuan Bangunan untuk Diserahkan kepada Masyarakat', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(107, '5.2.7.04', 'Belanja Beasiswa Berprestasi/Masyarakat Miskin', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(108, '5.2.7.05', 'Belanja Bantuan Bibit Tanaman/Hewan/Ikan', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(109, '5.2.7.90', 'Belanja Bantuan Bahan dan Barang untuk masyarakat', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(110, '5.2.7.91', 'Belanja Barang dan Jasa yang diserahkan kepada kelompok', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(111, '5.2.7.99', 'Belanja Barang untuk Diserahkan kepada Masyarakat Lainnya', 103, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(112, '5.3', 'Belanja Modal', 1, 2, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(113, '5.3.1', 'Belanja Modal Pengadaan Tanah', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(114, '5.3.1.01', 'Belanja Modal Pembebasan/Pembelian Tanah', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(115, '5.3.1.02', 'Belanja Modal Pembayaran Honorarium Tim Tanah', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(116, '5.3.1.03', 'Belanja Modal Pengukuran dan Pembuatan Sertifikat Tanah', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(117, '5.3.1.04', 'Belanja Modal Pengurukan dan Pematangan Tanah', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(118, '5.3.1.05', 'Belanja Modal Perjalanan Pengadaan Tanah', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(119, '5.3.1.06', 'Belanja Modal Pembayaran Iuran Jaminan Ketenagakerjaan bagi Pekerja (Pengurukan Pematangan Tanah)', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(120, '5.3.1.99', 'Belanja Modal Pengadaan Tanah Lainnya', 113, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(121, '5.3.2', 'Belanja Modal Pengadaan Peralatan, Mesin dan Alat Berat', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(122, '5.3.2.01', 'Belanja Modal Pembayaran Honor Tim Pelaksana Kegiatan (PM)', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(123, '5.3.2.02', 'Belanja Modal Peralatan Elektronik dan Alat Studio', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(124, '5.3.2.03', 'Belanja Modal Peralatan Komputer', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(125, '5.3.2.04', 'Belanja Modal Peralatan Mebelair dan Aksesoris Ruangan', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(126, '5.3.2.05', 'Belanja Modal Peralatan Dapur', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(127, '5.3.2.06', 'Belanja Modal Peralatan Alat Ukur', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(128, '5.3.2.07', 'Belanja Modal Peralatan Rambu-rambu/Patok Tanah', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(129, '5.3.2.08', 'Belanja Modal Peralatan Khusus Kesehatan', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(130, '5.3.2.09', 'Belanja Modal Peralatan Khusus Pertanian/Peternakan/Perikanan', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(131, '5.3.2.10', 'Belanja Modal Mesin', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(132, '5.3.2.11', 'Belanja Modal Pengadaan Alat-alat Berat', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(133, '5.3.2.99', 'Belanja Modal Peralatan, Mesin dan Alat Berat Lainnya', 121, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(134, '5.3.3', 'Belanja Modal Kendaraan', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(135, '5.3.3.01', 'Belanja Modal Honor Tim Pengadaan (Kendaraan)', 134, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(136, '5.3.3.02', 'Belanja Modal Kendaraan Darat Bermotor', 134, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(137, '5.3.3.03', 'Belanja Modal Kendaaran Darat Tidak Bermotor', 134, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(138, '5.3.3.04', 'Belanja Modal Kendaraan Air Bermotor', 134, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(139, '5.3.3.05', 'Belanja Modal Kendaraan Air Tidak Bermotor', 134, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(140, '5.3.3.99', 'Belanja Modal Kendaraan Lainnya', 134, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(141, '5.3.4', 'Belanja Modal Gedung, Bangunan dan Taman', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(142, '5.3.4.01', 'Belanja Modal Gedung, Bangunan, Taman - Honor Pelaksana Kegiatan', 141, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(143, '5.3.4.02', 'Belanja Modal Gedung, Bangunan, Taman - Upah Tenaga Kerja', 141, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(144, '5.3.4.03', 'Belanja Modal Gedung, Bangunan, Taman - Bahan Baku/Material', 141, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(145, '5.3.4.04', 'Belanja Modal Gedung, Bangunan, Taman - Sewa Peralatan', 141, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(146, '5.3.4.05', 'Belanja Modal Gedung, Bangunan, Taman - Administrasi Kegiatan', 141, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(147, '5.3.4.06', 'Belanja Modal Pembayaran Iuran Jaminan Ketenagakerjaan bagi Pekerja', 141, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(148, '5.3.5', 'Belanja Modal Jalan/Prasarana Jalan', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(149, '5.3.5.01', 'Belanja Modal Jalan - Honor Tim Pelaksana Kegiatan', 148, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(150, '5.3.5.02', 'Belanja Modal Jalan - Upah Tenaga Kerja', 148, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(151, '5.3.5.03', 'Belanja Modal Jalan - Bahan Baku/Material', 148, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(152, '5.3.5.04', 'Belanja Modal Jalan - Sewa Peralatan', 148, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(153, '5.3.5.05', 'Belanja Modal Jalan - Administrasi Kegiatan', 148, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(154, '5.3.5.06', 'Belanja Modal Pembayaran Iuran Jaminan Ketenagakerjaan bagi Pekerja', 148, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(155, '5.3.6', 'Belanja Modal Jembatan', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(156, '5.3.6.01', 'Belanja Modal Jembatan - Honor Pelaksana Kegiatan', 155, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(157, '5.3.6.02', 'Belanja Modal Jembatan - Upah Tenaga Kerja', 155, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(158, '5.3.6.03', 'Belanja Modal Jembatan - Bahan Baku/Material', 155, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(159, '5.3.6.04', 'Belanja Modal Jembatan - Sewa Peralatan', 155, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(160, '5.3.6.05', 'Belanja Modal Jembatan - Administrasi Kegiatan', 155, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(161, '5.3.6.06', 'Belanja Modal Pembayaran Iuran Jaminan Ketenagakerjaan bagi Pekerja', 155, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(162, '5.3.7', 'Belanja Modal Irigasi/Embung/Drainase/Air Limbah/Persampahan', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(163, '5.3.7.01', 'Belanja Modal Irigasi/Embung/Drainase/dll - Honor Tim Pelaksana Kegiatan', 162, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(164, '5.3.7.02', 'Belanja Modal Irigasi/Embung/Drainase/dll - Upah Tenaga Kerja', 162, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(165, '5.3.7.03', 'Belanja Modal Irigasi/Embung/Drainase/dll - Bahan Baku/Material', 162, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(166, '5.3.7.04', 'Belanja Modal Irigasi/Embung/Drainase/dll - Sewa Peralatan', 162, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(167, '5.3.7.05', 'Belanja Modal Irigasi/Embung/Drainase/dll - Administrasi Kegiatan', 162, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(168, '5.3.7.06', 'Belanja Modal Pembayaran Iuran Jaminan Ketenagakerjaan bagi Pekerja', 162, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(169, '5.3.8', 'Belanja Modal Jaringan/Instalasi', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(170, '5.3.8.01', 'Belanja Modal Jaringan/Instalasi - Honor Tim Pelaksana Kegiatan', 169, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(171, '5.3.8.02', 'Belanja Modal Jaringan/Instalasi - Upah Tenaga Kerja', 169, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(172, '5.3.8.03', 'Belanja Modal Jaringan/Instalasi - Bahan Baku/Material', 169, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(173, '5.3.8.04', 'Belanja Modal Jaringan/Instalasi - Sewa Peralatan', 169, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(174, '5.3.8.05', 'Belanja Modal Jaringan/Instalasi - Administrasi Kegiatan', 169, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(175, '5.3.8.06', 'Belanja Modal Pembayaran Iuran Jaminan Ketenagakerjaan bagi Pekerja', 169, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(176, '5.3.9', 'Belanja Modal Lainnya', 112, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(177, '5.3.9.01', 'Belanja Khusus Pendidikan dan Perpustakaan', 176, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(178, '5.3.9.02', 'Belanja Khusus Olahraga', 176, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(179, '5.3.9.03', 'Belanja Modal Khusus Kesenian/Kebudayaan/Keagamaan', 176, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(180, '5.3.9.04', 'Belanja Modal Tumbuhan/Tanaman', 176, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(181, '5.3.9.05', 'Belanja Modal Hewan', 176, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(182, '5.3.9.99', 'Belanja Modal Lainnya', 176, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(183, '5.4', 'Belanja Tidak Terduga', 1, 2, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(184, '5.4.1', 'Belanja Tidak Terduga', 183, 3, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15'),
(185, '5.4.1.01', 'Belanja Tidak Terduga', 184, 4, 1, '2026-09-30 06:59:15', '2026-09-30 06:59:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bidang`
--
CREATE TABLE `bidang` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bidang`
--

INSERT INTO `bidang` (`id`, `tahun_anggaran_id`, `kode`, `nama`, `urutan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(2, 1, '01', 'BIDANG PENYELENGGARAN PEMERINTAHAN DESA', 1, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(3, 1, '02', 'BIDANG PELAKSANAAN PEMBANGUNAN DESA', 2, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(4, 1, '03', 'BIDANG PEMBINAAN KEMASYARAKATAN', 3, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(5, 1, '04', 'BIDANG PEMBERDAYAAN MASYARAKAT', 4, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(6, 1, '05', 'BIDANG PENANGGULANGAN BENCANA, DARURAT DAN MENDESAK DESA', 5, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `desa`
--
CREATE TABLE `desa` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kecamatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kabupaten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provinsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `desa`
--

INSERT INTO `desa` (`id`, `nama`, `kecamatan`, `kabupaten`, `provinsi`, `alamat`, `website`, `email`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Desa Sungai Cuka', 'Kintap', 'Tanah Laut', 'Kalimantan Selatan', 'Jl. Sumber Jaya Rt 002 Rw 003', 'https://sumberjaya-tanahlaut.desa.id', 'Sumberjaya.sbbv@gmail.com', 'profil-desa/H1vt5oyBfd2FehFjtKoqGU8OXhQ1oJDNctHkY3lk.png', '2026-09-29 05:46:44', '2026-10-03 02:12:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_publikasi`
--
CREATE TABLE `dokumen_publikasi` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `tanggal_publikasi` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--
CREATE TABLE `kegiatan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `bidang_id` bigint UNSIGNED NOT NULL,
  `sub_bidang_id` bigint UNSIGNED DEFAULT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `tahun_anggaran_id`, `bidang_id`, `sub_bidang_id`, `kode`, `nama`, `urutan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 1, '01.01.01', 'Penyediaan Penghasilan Tetap dan Tunjangan Kepala Desa', 10101, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(2, 1, 2, 1, '01.01.02', 'Penyediaan Penghasilan Tetap dan Tunjangan Perangkat Desa', 10102, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(3, 1, 2, 1, '01.01.03', 'Penyediaan Jaminan Sosial bagi Kepala Desa dan Perangkat Desa', 10103, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(4, 1, 2, 1, '01.01.04', 'Penyediaan Operasional Pemerintah Desa (ATK, Honor PKPKD dan PPKD dll)', 10104, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(5, 1, 2, 1, '01.01.05', 'Penyediaan Tunjangan BPD', 10105, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(6, 1, 2, 1, '01.01.06', 'Penyediaan Operasional BPD (rapat, ATK, Makan Minum, Pakaian Seragam, Listrik dll)', 10106, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(7, 1, 2, 1, '01.01.07', 'Penyediaan Insentif/Operasional RT/RW', 10107, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(8, 1, 2, 1, '01.01.08', 'Penyediaan Operasional Pemerintah Desa yang bersumber dari Dana Desa', 10108, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(9, 1, 2, 1, '01.01.09', 'Penyediaan Jaminan Sosial bagi BPD', 10109, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(10, 1, 2, 1, '01.01.90', 'Penyediaan Penghasilan Tetap dan Tunjangan Staf Perangkat Desa', 10190, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(11, 1, 2, 1, '01.01.91', 'Penyediaan Penghasilan Tetap dan Tunjangan Staf BPD', 10191, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(12, 1, 2, 1, '01.01.92', 'Tambahan Penghasilan Tunjangan Hari Raya Kades Dan Perangkat Desa', 10192, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(13, 1, 2, 1, '01.01.93', 'Tambahan Penghasilan Tunjangan Hari Raya Staf Perangkat Desa dan Staf BPD', 10193, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(14, 1, 2, 1, '01.01.94', 'Tambahan Penghasilan Tunjangan Hari Raya Ketua dan Anggota BPD', 10194, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(15, 1, 2, 1, '01.01.95', 'Penyediaan Jaminan Sosial BPJS Ketenagakerjaan bagi BPD', 10195, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(16, 1, 2, 1, '01.01.96', 'Penyediaan Jaminan Sosial BPJS Ketenagakerjaan bagi Staf Perangkat Desa', 10196, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(17, 1, 2, 1, '01.01.97', 'Penyediaan Jaminan Sosial BPJS Ketenagakerjaan bagi Staf BPD', 10197, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(18, 1, 3, 2, '02.01.01', 'Penyelenggaraan PAUD/TK/TPA/TKA/TPQ/Madrasah Non-Formal Milik Desa (Honor, Pakaian dll)', 20101, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(19, 1, 3, 2, '02.01.02', 'Dukungan Penyelenggaraan PAUD (APE, Sarana PAUD dst)', 20102, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(20, 1, 3, 2, '02.01.03', 'Penyuluhan dan Pelatihan Pendidikan Bagi Masyarakat', 20103, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(21, 1, 3, 2, '02.01.04', 'Pemeliharaan Sarana Prasarana Perpustakaan/Taman Bacaan/Sanggar Belajar Milik Desa', 20104, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(22, 1, 3, 2, '02.01.05', 'Pemeliharaan Sarana Prasarana PAUD/TK/TPA/TKA/TPQ/Madrasah Non-formal Milik Desa', 20105, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(23, 1, 3, 2, '02.01.06', 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana/Prasarana/Alat Peraga PAUD/ TK/TPA/TKA/TPQ/Madrasah Nonformal', 20106, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(24, 1, 3, 2, '02.01.07', 'Pembangunan/Rehabilitasi/Peningkatan Sarana/Prasarana Perpustakaan/Taman Bacaan Desa/ Sanggar Belajar Milik Desa', 20107, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(25, 1, 3, 2, '02.01.08', 'Pengelolaan Perpustakaan Milik Desa (Pengadaan Buku, Honor, Taman Baca)', 20108, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(26, 1, 3, 2, '02.01.09', 'Pengembangan dan Pembinaan Sanggar Seni dan Belajar', 20109, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(27, 1, 3, 2, '02.01.10', 'Dukungan Pendidikan bagi Siswa Miskin/Berprestasi', 20110, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(28, 1, 3, 2, '02.01.90', 'Pembangunan dan Pemeliharaan Balain Pelathan/Keiatan Belajar Masyarakat', 20190, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(29, 1, 3, 2, '02.01.91', 'Fasilitasi dan Motivasi Kelompok Belajar di Desa', 20191, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(30, 1, 3, 2, '02.01.92', 'Pembangunan/Rehabilitasi/Pemeliharaan/peningkatan Gedung Serbaguna di Desa', 20192, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(31, 1, 3, 2, '02.01.93', 'Pembangunan/Rehabilitasi/Pemeliharaan/peningkatan Gedung Seni di Desa', 20193, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(32, 1, 3, 2, '02.01.94', 'Pembangunan/Rehabilitasi/Pemeliharaan/peningkatan Gedung dan Museum di Desa', 20194, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(33, 1, 3, 2, '02.01.95', 'Lomba Melukis/Menulis Keindahan Alam Hidup Hidup Bersih dan Sehat Anak Pantai', 20195, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(34, 1, 3, 2, '02.01.96', 'Lomba Melukis/Monografi di Desa', 20196, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(35, 1, 3, 2, '02.01.97', 'Pengelolaan Pelayanan Pendidikan dan Kebudayaan', 20197, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(36, 1, 3, 2, '02.01.99', 'Lain-lain Kegiatan Sub Bidang Pendidikan', 20199, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(37, 1, 3, 3, '02.02.01', 'Penyelenggaraan Pos Kesehatan Desa/Polindes Milik Desa (obat, Insentif, KB, dsb)', 20201, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(38, 1, 3, 3, '02.02.02', 'Penyelenggaraan Posyandu (Makanan Tambahan, Kelas Bumil, Lansia, Insentif)', 20202, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(39, 1, 3, 3, '02.02.03', 'Penyuluhan dan Pelatihan Bidang Kesehatan (Untuk Masyarakat, Tenaga dan Kader Kesehatan dll)', 20203, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(40, 1, 3, 3, '02.02.04', 'Penyelenggaraan Desa Siaga Kesehatan', 20204, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(41, 1, 3, 3, '02.02.05', 'Pembinaan Palang Merah Remaja (PMR) Tingkat Desa', 20205, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(42, 1, 3, 3, '02.02.06', 'Pengasuhan Bersama atau Bina Keluarga Balita (BKB)', 20206, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(43, 1, 3, 3, '02.02.07', 'Pembinaan dan Pengawasan Upaya Kesehatan Tradisional', 20207, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(44, 1, 3, 3, '02.02.08', 'Pemeliharaan Sarana Prasarana Posyandu/Polindes/PKD', 20208, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(45, 1, 3, 3, '02.02.09', 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana/PrasaranaPosyandu/Polindes/PKD **', 20209, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(46, 1, 3, 3, '02.02.90', 'Pemantauan dan Pencegahan Penyalahgunaan Narkotika dan Zat adiktif', 20290, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(47, 1, 3, 3, '02.02.91', 'Pembangunan Pengambahan Ruang Rawat Inap Poskesdes( Posyandu Apung/Perahu', 20291, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(48, 1, 3, 3, '02.02.92', 'Pengadaan Tambahan Peralatan Kesehatan Emergence Poskesdes', 20292, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(49, 1, 3, 3, '02.02.93', 'Penyelengaraan Promosi Kesehatan dan Gerakan Hidup Bersih dan Sehat', 20293, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(50, 1, 3, 3, '02.02.94', 'Sosialisasi Ancaman Penyakit ISPA Khususnya Bagi Buruh/Karyawan dari Desa yang Bekerja di Pabrik', 20294, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(51, 1, 3, 3, '02.02.95', 'Sosialisasi Ancaman Penyakit di musim Kemarau dan Penghujan', 20295, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(52, 1, 3, 3, '02.02.96', 'Sosialisasi Pencegahan dan Penanganan Penyakit Masyarakat', 20296, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(53, 1, 3, 3, '02.02.97', 'Penyelanggaraan Promosi Kesehatan dan Gerakan Hidup Bersih dan Sehat', 20297, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(54, 1, 3, 3, '02.02.98', 'Penambahan Peralatan pada Ambulance di Desa', 20298, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(55, 1, 3, 3, '02.02.99', 'Lain-lain Kegiatan Sub Bidang Kesehatan', 20299, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(56, 1, 3, 4, '02.03.01', 'Pemeliharaan Jalan Desa', 20301, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(57, 1, 3, 4, '02.03.02', 'Pemeliharaan Jalan Lingkungan Pemukiman/Gang', 20302, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(58, 1, 3, 4, '02.03.03', 'Pemeliharaan Jalan Usaha Tani', 20303, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(59, 1, 3, 4, '02.03.04', 'Pemeliharaan Jembatan Desa', 20304, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(60, 1, 3, 4, '02.03.05', 'Pemeliharaan Prasarana Jalan Desa (Gorong-gorong/Selokan/Parit/Drainase dll)', 20305, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(61, 1, 3, 4, '02.03.06', 'Pemeliharaan Gedung/Prasarana Balai Desa/Balai Kemasyarakatan', 20306, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(62, 1, 3, 4, '02.03.07', 'Pemeliharaan Pemakaman /Situs Bersejarah/Petilasan Milik Desa', 20307, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(63, 1, 3, 4, '02.03.08', 'Pemeliharaan Embung Milik Desa', 20308, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(64, 1, 3, 4, '02.03.09', 'Pemeliharaan Monumen/Gapura/Batas Desa', 20309, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(65, 1, 3, 4, '02.03.10', 'Pembangunan/Rehabilitas/Peningkatan/Pengerasan Jalan Desa **)', 20310, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(66, 1, 3, 4, '02.03.11', 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Lingkungan Permukiman **)', 20311, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(67, 1, 3, 4, '02.03.12', 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Usaha Tani **)', 20312, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(68, 1, 3, 4, '02.03.13', 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jembatan Milik Desa **)', 20313, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(69, 1, 3, 4, '02.03.14', 'Pembangunan/Rehabilitasi/Peningkatan Prasarana Jalan Desa (Gorong, selokan dll)', 20314, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(70, 1, 3, 4, '02.03.15', 'Pembangunan/Rehabilitasi/Peningkatan Balai Desa/Balai Kemasyarakatan **)', 20315, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(71, 1, 3, 4, '02.03.16', 'Pembangunan/Rehabilitasi/Peningkatan Pemakaman Milik Desa/Situs BersejarahMilik Desa/Petilasan', 20316, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(72, 1, 3, 4, '02.03.17', 'Pembuatan/Pemutakhiran Peta Wilayah dan Sosial Desa **)', 20317, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(73, 1, 3, 4, '02.03.18', 'Penyusunan Dokumen Perencanaan Tata Ruang Desa', 20318, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(74, 1, 3, 4, '02.03.19', 'Pembangunan/Rehabilitasi/Peningkatan Embung Desa **)', 20319, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(75, 1, 3, 4, '02.03.20', 'Pembangunan/Rehabilitasi/Peningkatan Monumen/Gapura/Batas Desa **)', 20320, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(76, 1, 3, 4, '02.03.21', 'Pengurukan Tanah dalam rangka mendukung Koperasi Desa Merah Putih (KDMP)', 20321, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(77, 1, 3, 4, '02.03.90', 'Penerangan Jalan,Taman dan Lingkungan', 20390, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(78, 1, 3, 4, '02.03.91', 'Pembangunan/Rehabilitasi/Peningkatan Taman Desa', 20391, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(79, 1, 3, 4, '02.03.92', 'Pembangunan/Rehabilitasi/Peningkatan Siring', 20392, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(80, 1, 3, 4, '02.03.94', 'Pembangunan/Rehabilitasi/Peningkatan Siring Sungai', 20394, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(81, 1, 3, 4, '02.03.95', 'Rehabilitasi dan Penambahan Unit Fasilitas Jamban Publik', 20395, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(82, 1, 3, 4, '02.03.96', 'Pengadaan Sarana dan Prasarana Pengelolaan Sampah di Desa', 20396, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(83, 1, 3, 4, '02.03.97', 'Pengadaan Sarana dan Prasarana Pengelolaan Sampah Rumah Tangga dan Kawasan Wisata di Desa', 20397, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(84, 1, 3, 4, '02.03.99', 'Lain-lain Kegiatan Sub Bidang Pekerjaan Umum dan Tata Ruang', 20399, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(85, 1, 3, 5, '02.04.01', 'Dukungan Pelaksanaan Program Pembangunan/Rehab Rumah Tidak Layak Huni GAKIN', 20401, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(86, 1, 3, 5, '02.04.02', 'Pemeliharaan Sumur Resapan Milik Desa', 20402, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(87, 1, 3, 5, '02.04.03', 'Pemeliharaan Sumber Air Bersih Milik Desa (Mata Air, Penampung Air, Sumur Bor dll)', 20403, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(88, 1, 3, 5, '02.04.04', 'Pemeliharaan Sambungan Air Bersih ke Rumah Tangga (Pipanisasi dll)', 20404, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(89, 1, 3, 5, '02.04.05', 'Pemeliharaan Sanitasi Pemukiman (Gorong-gorong, Selokan, Parit diluar Prasarana Jalan))', 20405, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(90, 1, 3, 5, '02.04.06', 'Pemeliharaan Fasilitas Jamban Umum/MCK Umum dll', 20406, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(91, 1, 3, 5, '02.04.07', 'Pemeliharaan Fasilitas Pengelolaan Sampah Desa (Penampungan,Bank Sampah, dll)', 20407, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(92, 1, 3, 5, '02.04.08', 'Pemeliharaan Sistem Pembuangan Air Limbah (Drainase, Air limbah Rumah Tangga)', 20408, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(93, 1, 3, 5, '02.04.09', 'Pemeliharaan Taman/Taman Bermain Anak Milik Desa', 20409, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(94, 1, 3, 5, '02.04.10', 'Pembangunan/Rehabilitasi/Peningkatan Sumur Resapan **)', 20410, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(95, 1, 3, 5, '02.04.11', 'Pembangunan/Rehabilitasi/Peningkatan Sumber Air Bersih Milik Desa **)', 20411, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(96, 1, 3, 5, '02.04.12', 'Pembangunan/Rehabilitasi/Peningkatan Sambungan Air Bersih ke Rumah Tangga **)', 20412, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(97, 1, 3, 5, '02.04.13', 'Pembangunan/Rehabilitasi/Peningkatan Sanitasi Permukiman **)', 20413, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(98, 1, 3, 5, '02.04.14', 'Pembangunan/Rehabilitasi/Peningkatan Fasilitas Jamban Umum/MCK umum, dll **)', 20414, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(99, 1, 3, 5, '02.04.15', 'Pembangunan/Rehabilitasi/Peningkatan Fasilitas Pengelolaan Sampah **)', 20415, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(100, 1, 3, 5, '02.04.16', 'Pembangunan/Rehabilitasi/Peningkatan Sistem Pembuangan Air Limbah **)', 20416, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(101, 1, 3, 5, '02.04.17', 'Pembangunan/Rehabilitasi/Peningkatan Taman/Taman Bermain Anak Milik Desa **)', 20417, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(102, 1, 3, 5, '02.04.90', 'Pengadaan, Pembangunan, Pengembangan dan pemeliharaan sarana dan prasarana lingkungan pemukiman', 20490, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(103, 1, 3, 5, '02.04.99', 'Lain-lain Kegiatan Sub Bidang Perumahan Rakyat dan Kawasan Pemukiman', 20499, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(104, 1, 3, 6, '02.05.01', 'Pengelolaan Hutan Milik Desa', 20501, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(105, 1, 3, 6, '02.05.02', 'Pengelolaan Lingkungan Hidup Milik Desa', 20502, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(106, 1, 3, 6, '02.05.03', 'Pelatihan/Sosialisasi/Penyuluhan/Penyadaran tentang LH danKehutanan **)', 20503, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(107, 1, 3, 6, '02.05.99', 'Lain-lain Kegiatan Sub Bidang Kehutanan dan Lingkungan Hidup', 20599, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(108, 1, 3, 7, '02.06.01', 'Pembuatan Rambu-rambu di Jalan Desa', 20601, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(109, 1, 3, 7, '02.06.02', 'Penyelenggaraan Informasi Publik Desa (Poster, Baliho Dll)', 20602, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(110, 1, 3, 7, '02.06.03', 'Pengelolaan dan Pembuatan Jaringan/Instalasi Komunikasi dan Informasi Lokal Desa', 20603, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(111, 1, 3, 7, '02.06.04', 'Pemeliharaan Sarana dan Prasarana Transportasi Desa', 20604, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(112, 1, 3, 7, '02.06.05', 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana & Prasarana Transportasi Desa', 20605, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(113, 1, 3, 7, '02.06.90', 'Pembangunan Tambatan Perahu di Desa', 20690, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(114, 1, 3, 7, '02.06.91', 'Pemasangan jaringan Internet', 20691, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(115, 1, 3, 7, '02.06.92', 'Pembangunan Tower Untuk Jaringan Internet di Desa', 20692, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(116, 1, 3, 7, '02.06.99', 'Lain-lain Kegiatan Sub Bidang Perhubungan, Komunikasi dan Informatika', 20699, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(117, 1, 3, 8, '02.07.01', 'Pemeliharaan Sarana dan Prasarana Energi Alternatif Tingkat Desa', 20701, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(118, 1, 3, 8, '02.07.02', 'Pembangunan/Rehabilitasi/Peningkatan Sarana & Prasarana Energi Alternatif Desa', 20702, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(119, 1, 3, 8, '02.07.90', 'Pembangunan Sarana dan Prasarana Listrik Mikro Hidro', 20790, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(120, 1, 3, 8, '02.07.91', 'Pembangunan dan Pengelolaan Energi Mandiri', 20791, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(121, 1, 3, 8, '02.07.92', 'Pembangunan dan Pemeliharaan Instalasi Biogas', 20792, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(122, 1, 3, 8, '02.07.93', 'Pembangunan Rintisan Listrik Desa Tenaga Angin/Matahari', 20793, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(123, 1, 3, 8, '02.07.94', 'Pelatihan Pemanfaatan limbah Organik Rumah Tangga, sosialisasi, pembentukan dan pelatihan Posyantek Desa dan Posyantek antar Desa dan Perkebunan untuk Bio-Massa Energi', 20794, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(124, 1, 3, 8, '02.07.95', 'Percontohan Instalasi dan pusat/ruang Belajar Teknologi Tepat Guna', 20795, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(125, 1, 3, 8, '02.07.99', 'lain-lain kegiatan sub bidang Energi dan Sumber Daya Mineral', 20799, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(126, 1, 3, 9, '02.08.01', 'Pemeliharaan Sarana dan Prasarana Pariwisata Milik Desa', 20801, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(127, 1, 3, 9, '02.08.02', 'Pembangunan/Rehabilitasi/Peningkatan Sarana dan Prasarana Pariwisata Milik **)', 20802, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(128, 1, 3, 9, '02.08.03', 'Pengembangan Pariwisata Tingkat Desa', 20803, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(129, 1, 3, 9, '02.08.90', 'Pembangunan Tembok Laut Kawasan wisata Laut', 20890, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(130, 1, 3, 9, '02.08.91', 'Rehabilitasi Pemeliharaan Jogging Path Track Wisatawan', 20891, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(131, 1, 3, 9, '02.08.92', 'Pembangunan Amphitheater di Ruang Publik Pantai', 20892, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(132, 1, 3, 9, '02.08.93', 'Penambahan bahan-bahan promosi dan buku edukasi tentang pantai dan laut', 20893, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(133, 1, 3, 9, '02.08.94', 'Pembangunan Show Room / Wisma Pamer Produk Desa', 20894, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(134, 1, 3, 9, '02.08.95', 'Festival Makanan Laut Higienis Pesisir Laut', 20895, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(135, 1, 3, 9, '02.08.96', 'Fasilitasi Pelaku Periwisata di Desa, Pelatihan Pengelola wisata Desa', 20896, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(136, 1, 3, 9, '02.08.97', 'Penyelanggaraan dan persiapan Desa Wisata', 20897, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(137, 1, 3, 9, '02.08.99', 'Lain-Lain Legiatan Sub Bidang Pariwisata', 20899, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(138, 1, 4, 10, '03.01.01', 'Pengadaan/Penyelenggaraan Pos Keamanan Desa', 30101, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(139, 1, 4, 10, '03.01.02', 'Penguatan & Peningkatan Kapasitas Tenaga Keamanan/Ketertiban oleh Pemdes', 30102, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(140, 1, 4, 10, '03.01.03', 'Koordinasi Pembinaan Keamanan, Ketertiban & Perlindungan Masy. Skala Lokal Desa', 30103, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(141, 1, 4, 10, '03.01.04', 'Persiapan Kesiapsiagaan/Tanggap Bencana Skala Lokal Desa', 30104, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(142, 1, 4, 10, '03.01.05', 'Penyediaan Pos Kesiapsiagaan Bencana Skala Lokal Desa', 30105, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(143, 1, 4, 10, '03.01.06', 'Bantuan Hukum Untuk Aparatur Desa dan Masyarakat Miskin', 30106, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(144, 1, 4, 10, '03.01.07', 'Pelatihan/Penyuluhan/Sosialisasi kepada Masy. di Bid. Hukum & Pelindungan Masy.', 30107, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(145, 1, 4, 10, '03.01.90', 'Pembinaan Keamanan dan Ketertiban', 30190, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(146, 1, 4, 10, '03.01.91', 'Pembinaan Kerukunan warga Masyarakat Desa', 30191, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(147, 1, 4, 10, '03.01.92', 'Pelestarian dan Pengembangan Gotong Royong Masyarakat Desa', 30192, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(148, 1, 4, 10, '03.01.93', 'Memberikan Insentif dan Fasilitasi Linmas Desa', 30193, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(149, 1, 4, 10, '03.01.94', 'Memelihara Perdamaian, menangani Konflik dan melakukakn mediasi di Desa', 30194, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(150, 1, 4, 10, '03.01.95', 'Pembentukan dan Fasilitasi Paralegal Desa', 30195, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(151, 1, 4, 10, '03.01.96', 'Pelatihan Paralegal Desa', 30196, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(152, 1, 4, 10, '03.01.97', 'Pelatihan Penyelesaian mediasi Sengketa Tanah, atau Kekerasan dalam rumah Tangga', 30197, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(153, 1, 4, 10, '03.01.98', 'Fasilitasi Kelompok-Kelompok Rentan, Kelompok Masyakat Miskin, Perempuan, masyarakat Adat dan Difabel', 30198, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(154, 1, 4, 10, '03.01.99', 'Lain-lain Kegiatan Sub Bidang Ketenteraman, Ketertiban Umum dan Perlindungan Masyarakat', 30199, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(155, 1, 4, 11, '03.02.01', 'Pembinaan Group Kesenian dan Kebudayaan Tingkat Desa', 30201, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(156, 1, 4, 11, '03.02.02', 'Pengiriman Kontingen Group Kesenian & Kebudayaan (Wakil Desa tkt. Kec/Kab/Kot)', 30202, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(157, 1, 4, 11, '03.02.03', 'Penyelenggaraan Festival Kesenian, Adat/Kebudayaan, dan Keagamaan (HUT RI, Raya Keagamaan dll)', 30203, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(158, 1, 4, 11, '03.02.04', 'Pemeliharaan Sarana Prasarana Kebudayaan, Rumah Adat dan Keagamaan Milik Desa', 30204, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(159, 1, 4, 11, '03.02.05', 'Pembangunan/Rehabilitasi Sarana Prasarana Kebudayaan/Rumah Adat/Kegamaan Milik Desa **)', 30205, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(160, 1, 4, 11, '03.02.90', 'Pembinaan Kerukunan Umat Beragama', 30290, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(161, 1, 4, 11, '03.02.91', 'Pembentukan dan fasilitasi Lembaga Kemasyarakatan dan Lembaga Adat Desa', 30291, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(162, 1, 4, 11, '03.02.92', 'Pengembangan Seni Budaya Non Tradisional', 30292, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(163, 1, 4, 11, '03.02.93', 'Pelatihan Lembaga Kemasyarakatan Desa dan Lembaga Adat Desa', 30293, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(164, 1, 4, 11, '03.02.99', 'Lain-lain Kegiatan Sub Bidang Kebudayaan dan Keagamaan', 30299, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(165, 1, 4, 12, '03.03.01', 'Pengiriman Kontingen Kepemudaan & Olahraga Sebagai Wakil Desa tkt Kec/Kab/Kota', 30301, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(166, 1, 4, 12, '03.03.02', 'Penyelenggaraan Pelatihan Kepemudaan Tingkat Desa', 30302, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(167, 1, 4, 12, '03.03.03', 'Penyelenggaraan Festival/Lomba Kepemudaan dan Olahraga Tingkat Desa', 30303, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(168, 1, 4, 12, '03.03.04', 'Pemeliharaan Sarana dan Prasarana Kepemudaan dan Olahraga Milik Desa', 30304, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(169, 1, 4, 12, '03.03.05', 'Pembangunan/Rehabilitasi/Peningkatan Sarana dan Prasarana Kepemudaan & Olahraga Milik Desa', 30305, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(170, 1, 4, 12, '03.03.06', 'Pembinaan Karang Taruna/Klub Kepemudaan/Olahraga Tingkat Desa', 30306, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(171, 1, 4, 12, '03.03.90', 'Peningkatan Kepasitas Kelompok Pemuda', 30390, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(172, 1, 4, 12, '03.03.99', 'Lain-lain Kegiatan Sub Bidang Kepemudaan dan Olahraga', 30399, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(173, 1, 4, 13, '03.04.01', 'Pembinaan Lembaga Adat', 30401, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(174, 1, 4, 13, '03.04.02', 'Pembinaan LKMD/LPM/LPMD', 30402, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(175, 1, 4, 13, '03.04.03', 'Pembinaan PKK', 30403, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(176, 1, 4, 13, '03.04.04', 'Pelatihan Pembinaan Lembaga Kemasyarakatan', 30404, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(177, 1, 4, 13, '03.04.90', 'Pendidikan Anak Usia Dini', 30490, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(178, 1, 4, 13, '03.04.91', 'Pembinaan LPM', 30491, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(179, 1, 4, 13, '03.04.92', 'Pembentukan Desa Siaga', 30492, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(180, 1, 4, 13, '03.04.93', 'Pembentukan dan Fasilitasi Kader Pembangunan dan Pemberdayaan Masyarakat Desa Teknis dan Pemberdayaan Desa', 30493, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(181, 1, 4, 13, '03.04.94', 'Peningkatan Peran serta Masyarakat Dalam Pembangunan Desa', 30494, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(182, 1, 4, 13, '03.04.95', 'Peningkatan Kapasitas Kader Pemberdayaan Masyarakat Desa Teknis dan KPMD Pemberdayaan', 30495, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(183, 1, 4, 13, '03.04.99', 'Lain-lain Sub Bidang Kelembagaan Masyarakat', 30499, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(184, 1, 5, 14, '04.01.01', 'Pemeliharaan Karamba/Kolam Perikanan Darat Milik Desa', 40101, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(185, 1, 5, 14, '04.01.02', 'Pemeliharaan Pelabuhan Perikanan Sungai/Kecil Milik Desa', 40102, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(186, 1, 5, 14, '04.01.03', 'Pembangunan/Rehabilitasi/Peningkatan Karamba/Kolam Perikanan Darat Milik Desa', 40103, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(187, 1, 5, 14, '04.01.04', 'Pembangunan/Rehabilitasi/Peningkatan Pelabuhan Perikanan Sungai/Kecil Milik Desa', 40104, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(188, 1, 5, 14, '04.01.05', 'Bantuan Perikanan (Bibit/Pakan/dll)', 40105, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(189, 1, 5, 14, '04.01.06', 'Bimtek/Pelatihan/Pengenalan TTG untuk Perikanan Darat/Nelayan **)', 40106, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(190, 1, 5, 14, '04.01.90', 'Pembangunan dan Pemeliharaan serta Pengelolaan Saluran Untuk Budidaya Perikanan', 40190, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(191, 1, 5, 14, '04.01.91', 'Pembangunan dan Pengelolaan Tempat Pelelangan Ikan(TPI)', 40191, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(192, 1, 5, 14, '04.01.92', 'Pembangunan dan Pengelolaan Lumbung Pangan dan Penetapan Cadangan Pangan Ikan', 40192, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(193, 1, 5, 14, '04.01.93', 'Pengelolaan Balai Benih Ikan', 40193, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(194, 1, 5, 14, '04.01.94', 'Pengembangan TTG Penelolaan Hasil Perikanan', 40194, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(195, 1, 5, 14, '04.01.95', 'Penetapan Komoditas Unggulan Perikan', 40195, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(196, 1, 5, 14, '04.01.96', 'Peningkatan Kapasilitas Kelompok Nelayan', 40196, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(197, 1, 5, 14, '04.01.97', 'Pelatihan Pengelolaan Hasil Laut dan Pantai Untuk Petani Budidaya dan Nelayan Tangkap', 40197, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(198, 1, 5, 14, '04.01.99', 'Lain-lain Kegiatan Sub Bidang Kelautan dan Perikanan', 40199, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(199, 1, 5, 15, '04.02.01', 'Peningkatan Produksi Tanaman Pangan (alat produksi/pengelolaan/penggilingan)', 40201, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(200, 1, 5, 15, '04.02.02', 'Peningkatan Produksi Peternakan (alat produksi/pengelolaan/kandang)', 40202, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(201, 1, 5, 15, '04.02.03', 'Penguatan Ketahanan Pangan Tingkat Desa (Lumbung Desa dll)', 40203, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(202, 1, 5, 15, '04.02.04', 'Pemeliharaan Saluran Irigasi Tersier/Sederhana', 40204, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(203, 1, 5, 15, '04.02.05', 'Pelatihan/Bimtek/Pengenalan Teknologi Tepat Guna untuk Pertanian/Peternakan', 40205, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(204, 1, 5, 15, '04.02.06', 'Pembangunan/Rehabilitasi/Peningkatan Saluran Irigasi Tersier/Sederhana', 40206, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(205, 1, 5, 15, '04.02.99', 'Lain-lain Kegiatan Sub Bidang Pertanian dan Peternakan', 40299, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(206, 1, 5, 16, '04.03.01', 'Peningkatan Kapasitas Kepala Desa', 40301, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(207, 1, 5, 16, '04.03.02', 'Peningkatan Kapasitas Perangkat Desa', 40302, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(208, 1, 5, 16, '04.03.03', 'Peningkatan Kapasitas BPD', 40303, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(209, 1, 5, 16, '04.03.90', 'Peningkatan Kapasitas Staf Perangkat dan Staf BPD', 40390, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(210, 1, 5, 16, '04.03.99', 'Lain-lain Kegiatan Sub Bidang Peningkatan Kapasitas Aparatur Desa', 40399, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(211, 1, 5, 17, '04.04.01', 'Pelatihan dan Penyuluhan Pemberdayaan Perempuan', 40401, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(212, 1, 5, 17, '04.04.02', 'Pelatihan dan Penyuluhan Perlindungan Anak', 40402, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(213, 1, 5, 17, '04.04.03', 'Pelatihan dan Penguatan Penyandang Difabel (Penyandang Disabilitas)', 40403, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(214, 1, 5, 17, '04.04.90', 'Peningkatan Kapasitas Kelompok Perempuan', 40490, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(215, 1, 5, 17, '04.04.91', 'Peningkatan Kapasitas Kelompok Masyarakat Miskin', 40491, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(216, 1, 5, 17, '04.04.92', 'Peningkatan Kapasitas Kelompok Pemerhati dan Perlindungan Anak', 40492, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(217, 1, 5, 17, '04.04.93', 'Pemberdayaan Posyandu UP2K dan BKB', 40493, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(218, 1, 5, 17, '04.04.94', 'Peningkatan Kapasitas Masyarakat / Kelompok Masyarakat', 40494, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(219, 1, 5, 17, '04.04.95', 'Pencegahan dan Penanganan Stunting', 40495, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(220, 1, 5, 17, '04.04.99', 'Lain-lain Kegiatan Sub Bidang Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga', 40499, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(221, 1, 5, 18, '04.05.01', 'Pelatihan Manajemen Koperasi/KUD/UMKM', 40501, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(222, 1, 5, 18, '04.05.02', 'Pengembangan Sarana Prasarana Usaha Mikro, Kecil, Menengah dan Koperasi', 40502, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(223, 1, 5, 18, '04.05.03', 'Pengadaan Teknologi Tepat Guna Untuk Pengembangan Ekonomi Pedesaan Non Pertanian', 40503, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(224, 1, 5, 18, '04.05.99', 'Lain-lain Sub Bidang Koperasi, Usaha Micro Kecil dan Menengah (UMKM)', 40599, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(225, 1, 5, 19, '04.06.01', 'Pembentukan BUM Desa (Persiapan dan Pembentukan Awal BUMDesa)', 40601, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(226, 1, 5, 19, '04.06.02', 'Pelatihan Pengelolaan BUM Desa (Pelatihan yg dilaksanakan oleh Pemdes)', 40602, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(227, 1, 5, 19, '04.06.90', 'Pendirian dan Pengelolaan BUMDesa', 40690, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(228, 1, 5, 19, '04.06.91', 'Pengembangan Bisnis dan Pemetaan Kelayakan BUMDesa dan BUM Antar Desa', 40691, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(229, 1, 5, 19, '04.06.92', 'Investasi Uasaha Ekonomi Melalui kerjasaam BUMDesa', 40692, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(230, 1, 5, 19, '04.06.93', 'Analisa Kelayakan Usaha', 40693, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(231, 1, 5, 19, '04.06.94', 'Pengembangan Bisnis dan Pemataan kelayakan usaha BUMDESMA', 40694, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(232, 1, 5, 19, '04.06.99', 'Lain-lain Kegiatan Sub Bidang Dukungan Penanaman Modal', 40699, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(233, 1, 5, 20, '04.07.01', 'Pemeliharaan Pasar Desa/Kios Milik Desa', 40701, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(234, 1, 5, 20, '04.07.02', 'Pembangunan/Rehab Pasar Desa/Kios Milik Desa', 40702, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(235, 1, 5, 20, '04.07.03', 'Pengembangan Industri Kecil Tingkat Desa', 40703, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(236, 1, 5, 20, '04.07.04', 'Pembentukan/Fasilitasi/Pelatihan/Pendampingan kelompok usaha ekonomi produktif', 40704, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(237, 1, 5, 20, '04.07.90', 'Pengelolaan Pasar Desa dan Kios Desa', 40790, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(238, 1, 5, 20, '04.07.91', 'Pelatihan Hak-Hak Perburuhan Kerja Sama Desa dengan Perusahaan', 40791, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(239, 1, 5, 20, '04.07.92', 'Workshop Business Plan', 40792, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(240, 1, 5, 20, '04.07.99', 'Lain-lain Sub Bidang Perdagangan dan Perindustrian', 40799, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(241, 1, 6, 21, '05.01.00', 'Kegiatan Penanggulangan Bencana', 50100, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(242, 1, 6, 22, '05.02.00', 'Penanganan Keadaan Darurat', 50200, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(243, 1, 6, 23, '05.03.00', 'Penanganan Keadaan Mendesak', 50300, 'dipublikasikan', '2026-09-30 08:23:35', '2026-09-30 08:23:35'),
(244, 1, 2, 1, '01.01.99', 'Lain-lain Sub Bidang Siltap dan Operasional Pemerintahan Desa', 10199, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(245, 1, 2, 24, '01.02.01', 'Penyediaan Sarana (Aset Tetap) Perkantoran/Pemerintahan', 10201, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(246, 1, 2, 24, '01.02.02', 'Pemeliharaan Gedung/Prasarana Kantor Desa', 10202, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(247, 1, 2, 24, '01.02.03', 'Pembangunan/Rehabilitasi/Peningkatan Gedung/Prasarana Kantor Desa **)', 10203, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(248, 1, 2, 24, '01.02.90', 'Penetapan Pos Keamanan dan Kesiap Siagaan', 10290, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(249, 1, 2, 24, '01.02.91', 'Pemeliharaan Sarana dan Prsarana Pemerintahan Desa', 10291, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(250, 1, 2, 24, '01.02.99', 'Lain-lain Sub Bidang Sarana Prasarana Pemerintahan Desa', 10299, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(251, 1, 2, 25, '01.03.01', 'Pelayanan Administrasi Umum dan Kependudukan', 10301, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(252, 1, 2, 25, '01.03.02', 'Penyusunan, Pendataan, dan Pemutakhiran Profil Desa **)', 10302, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(253, 1, 2, 25, '01.03.03', 'Pengelolaan Administrasi dan Kearsipan Pemerintahan Desa', 10303, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(254, 1, 2, 25, '01.03.04', 'Penyuluhan dan Penyadaran Masyarakat tentang Kependudukan dan Capil', 10304, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(255, 1, 2, 25, '01.03.05', 'Pemetaan dan Analisis Kemiskinan Desa secara Partisipatif', 10305, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(256, 1, 2, 25, '01.03.90', 'Pendataan Kependudukan', 10390, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(257, 1, 2, 25, '01.03.91', 'Penyelanggaraan Evaluasi Tingkat Perkembangan Desa', 10391, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(258, 1, 2, 25, '01.03.92', 'Pendataan Tenaga Kerja di Desa', 10392, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(259, 1, 2, 25, '01.03.93', 'Pendataan Penduduk yang Bekerja pada sektor Pertanian dan sektor non Pertanian', 10393, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(260, 1, 2, 25, '01.03.94', 'Pendataan Penduduk menurut jumlah Penduduk usia Kerja, angkatan Kerja', 10394, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(261, 1, 2, 25, '01.03.95', 'Pendataan Penduduk berumur 15 Tahun keatas yang bekerja menurut Lapangan Kerja', 10395, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(262, 1, 2, 25, '01.03.96', 'Pendataan Potensi Desa', 10396, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(263, 1, 2, 25, '01.03.97', 'Pemutahiran data berbasis SDGs Desa', 10397, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(264, 1, 2, 25, '01.03.98', 'Pendataan dan Pemutahiran data IDM', 10398, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(265, 1, 2, 25, '01.03.99', 'Lain-lain Sub Bidang Administrasi Kependudukan, Capil, Statistik dan Kearsipan', 10399, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(266, 1, 2, 26, '01.04.01', 'Penyelenggaraan Musyawarah Perencanaan Desa/Pembahasan APBDes (Reguler)', 10401, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(267, 1, 2, 26, '01.04.02', 'Penyelenggaraan Musyawarah Desa Lainnya (Musdus, Rembug desa Non Reguler)', 10402, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(268, 1, 2, 26, '01.04.03', 'Penyusunan Dokumen Perencanaan Desa (RPJMDesa/RKPDesa dll)', 10403, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(269, 1, 2, 26, '01.04.04', 'Penyusunan Dokumen Keuangan Desa (APBDes, APBDes Perubahan, LPJ dll)', 10404, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(270, 1, 2, 26, '01.04.05', 'Pengelolaan Administrasi/ Inventarisasi/Penilaian Aset Desa', 10405, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(271, 1, 2, 26, '01.04.06', 'Penyusunan Kebijakan Desa (Perdes/Perkades selain Perencanaan/Keuangan)', 10406, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(272, 1, 2, 26, '01.04.07', 'Penyusunan Laporan Kepala Desa, LPPDesa dan Informasi Kepada Masyarakat', 10407, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(273, 1, 2, 26, '01.04.08', 'Pengembangan Sistem Informasi Desa', 10408, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(274, 1, 2, 26, '01.04.09', 'Koordinasi/Kerjasama Penyelenggaraan Pemerintahan & Pembangunan Desa', 10409, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(275, 1, 2, 26, '01.04.10', 'Dukungan Pelaksanaan & Sosialisasi Pilkades, Penyaringan dan Penjaringan Perangkat Desa, dan Pemilihan BPD (yang menjadi wewenang Desa)', 10410, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(276, 1, 2, 26, '01.04.11', 'Penyelenggaraan Lomba antar Kewilayahan & Pengiriman Kontingen dalam Mengikuti Lomba Desa', 10411, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(277, 1, 2, 26, '01.04.12', 'Dukungan Biaya Operasional dan Biaya Lainnya untuk Desa Persiapan', 10412, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(278, 1, 2, 26, '01.04.90', 'Penyelanggaraan Kerja Sama Antar Desa', 10490, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(279, 1, 2, 26, '01.04.91', 'Pembentukan Badan Permusyawatan Desa', 10491, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(280, 1, 2, 26, '01.04.92', 'Penetapan / Pengukuhan Kepala Desa dan Perangkat Desa', 10492, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(281, 1, 2, 26, '01.04.93', 'Penyusunan Produk Hukum Desa', 10493, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(282, 1, 2, 26, '01.04.94', 'Pengembangan dan Pengelolaan sistem administrasi dan Informasi di Desa', 10494, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(283, 1, 2, 26, '01.04.95', 'Penetapan dan / Pengukuhan Badan Permusyawatan Desa', 10495, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(284, 1, 2, 26, '01.04.96', 'Penetapan Organisasi Pemerintahan Desa', 10496, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(285, 1, 2, 26, '01.04.97', 'Pemberhatian/Pengangkatan dan Mutasi Staf dan Perangkat Desa serta Staf BPD', 10497, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(286, 1, 2, 26, '01.04.98', 'Penyelanggaraan Pemilihan Kepala Desa', 10498, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(287, 1, 2, 26, '01.04.99', 'Lain-lain Sub Bidang Tata Praja Pemerintahan, Perencanaan, Keuangan & Pelaporan', 10499, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(288, 1, 2, 27, '01.05.01', 'Sertifikasi Tanah Kas Desa', 10501, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(289, 1, 2, 27, '01.05.02', 'Administrasi Pertanahan (Pendaftaran Tanah dan Pemberian Registrasi Agenda Pertanahan)', 10502, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(290, 1, 2, 27, '01.05.03', 'Fasilitasi Sertifikasi Tanah untuk Masyarakat Miskin', 10503, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(291, 1, 2, 27, '01.05.04', 'Kegiatan Mediasi Konflik Pertanahan', 10504, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(292, 1, 2, 27, '01.05.05', 'Kegiatan Penyuluhan Pertanahan', 10505, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(293, 1, 2, 27, '01.05.06', 'Adminstrasi Pajak Bumi dan Bangunan (PBB)', 10506, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(294, 1, 2, 27, '01.05.07', 'Penentuan/Penegasan Batas/patok Tanah Kas Desa', 10507, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(295, 1, 2, 27, '01.05.08', 'Penyediaan Tanah Kas Desa', 10508, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(296, 1, 2, 27, '01.05.90', 'Penyusunan Tata Ruang Desa', 10590, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(297, 1, 2, 27, '01.05.91', 'Pengelolaan Tanah Desa', 10591, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(298, 1, 2, 27, '01.05.92', 'Pengembangan Tata Ruang dan Peta Sosial Desa', 10592, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(299, 1, 2, 27, '01.05.93', 'Pemberian Ijin Hak Pengelolaan Atas Tanah Desa', 10593, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(300, 1, 2, 27, '01.05.94', 'Pelatihan Penyelesaian Mediasi Sengketa Aset Desa untuk Warga Desa', 10594, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(301, 1, 2, 27, '01.05.99', 'Lain-lain Sub Bidang Pertanahan', 10599, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--
CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2026_01_01_000001_create_eapbdesa_tables', 1),
(3, '2026_01_02_000001_create_pendapatan_rekenings_table', 2),
(4, '2026_01_03_000001_create_sub_bidang_and_link_kegiatan', 3),
(5, '2026_01_03_000002_create_belanja_rekenings_table', 4),
(6, '2026_10_02_122124_create_pembiayaan_rekenings_table', 5),
(7, '2026_10_02_200958_add_logo_to_desa_table', 6),
(8, '2026_10_02_224527_create_visitor_logs_table', 6),
(9, '2026_10_03_093812_add_username_to_users_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembiayaan`
--
CREATE TABLE `pembiayaan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `pembiayaan_rekening_id` bigint UNSIGNED DEFAULT NULL,
  `jenis` enum('penerimaan','pengeluaran') COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(18,2) NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembiayaan`
--

INSERT INTO `pembiayaan` (`id`, `tahun_anggaran_id`, `pembiayaan_rekening_id`, `jenis`, `kode`, `uraian`, `anggaran`, `urutan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(3, 1, 13, 'penerimaan', '6.1.1.01.', 'SILPA Tahun Sebelumnya', 614709504.00, 0, 'dipublikasikan', '2026-10-02 04:47:26', '2026-10-02 12:43:30'),
(4, 1, 18, 'pengeluaran', '6.2.1.01.', 'Pembentukan Dana Cadangan', 370000000.00, 0, 'dipublikasikan', '2026-10-02 04:47:42', '2026-10-02 12:43:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembiayaan_rekenings`
--
CREATE TABLE `pembiayaan_rekenings` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `level` tinyint UNSIGNED NOT NULL,
  `jenis` enum('penerimaan','pengeluaran') COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembiayaan_rekenings`
--

INSERT INTO `pembiayaan_rekenings` (`id`, `kode`, `uraian`, `parent_id`, `level`, `jenis`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '6.', 'PEMBIAYAAN', NULL, 1, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(2, '6.1.', 'Penerimaan Pembiayaan', 1, 2, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(3, '6.2.', 'Pengeluaran Pembiayaan', 1, 2, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(4, '6.1.1.', 'SILPA Tahun Sebelumnya', 2, 3, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(5, '6.1.2.', 'Pencairan Dana Cadangan', 2, 3, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(6, '6.1.3.', 'Hasil Penjualan Kekayaan Desa Yang Dipisahkan', 2, 3, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(7, '6.1.4.', 'Penerimaan Kembali Penyertaan Modal', 2, 3, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(8, '6.1.9.', 'Penerimaan Pembiayaan Lainnya', 2, 3, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(9, '6.2.1.', 'Pembentukan Dana Cadangan', 3, 3, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(10, '6.2.2.', 'Penyertaan Modal Desa', 3, 3, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(11, '6.2.3.', 'Setor Kembali Pendapatan Transfer', 3, 3, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(12, '6.2.9.', 'Pengeluaran Pembiayaan Lainnya', 3, 3, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(13, '6.1.1.01.', 'SILPA Tahun Sebelumnya', 4, 4, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(14, '6.1.2.01.', 'Pencairan Dana Cadangan', 5, 4, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(15, '6.1.3.01.', 'Hasil Penjualan Kekayaan Desa Yang Dipisahkan', 6, 4, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(16, '6.1.4.01.', 'Penerimaan Kembali Penyertaan Modal', 7, 4, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(17, '6.1.9.99.', 'Penerimaan Pembiayaan Lainnya', 8, 4, 'penerimaan', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(18, '6.2.1.01.', 'Pembentukan Dana Cadangan', 9, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(19, '6.2.2.01.', 'Penyertaan Modal Desa', 10, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(20, '6.2.3.01.', 'Dana Desa', 11, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(21, '6.2.3.02.', 'Bagian dari Hasil Pajak dan Retribusi Daerah Kabupaten/Kota', 11, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(22, '6.2.3.03.', 'Alokasi Dana Desa', 11, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(23, '6.2.3.04.', 'Bantuan Keuangan APBD Provinsi', 11, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(24, '6.2.3.05.', 'Bantuan Keuangan APBD Kabupaten/Kota', 11, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27'),
(25, '6.2.9.99.', 'Pengeluaran Pembiayaan Lainnya', 12, 4, 'pengeluaran', 1, '2026-10-02 04:42:27', '2026-10-02 04:42:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendapatan`
--
CREATE TABLE `pendapatan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `pendapatan_rekening_id` bigint UNSIGNED DEFAULT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelompok` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `anggaran` decimal(18,2) NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendapatan`
--

INSERT INTO `pendapatan` (`id`, `tahun_anggaran_id`, `pendapatan_rekening_id`, `kode`, `kelompok`, `uraian`, `anggaran`, `urutan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(8, 1, 29, '4.2.1.01', 'Pendapatan Transfer', 'Dana Desa', 500000000.00, 0, 'dipublikasikan', '2026-09-29 19:15:17', '2026-09-29 19:15:17'),
(9, 1, 31, '4.2.2.01', 'Pendapatan Transfer', 'Bagi Hasil Pajak dan Retribusi Daerah Kabupaten/Kota', 50000000.00, 0, 'dipublikasikan', '2026-09-29 19:15:17', '2026-09-29 19:15:17'),
(10, 1, 33, '4.2.3.01', 'Pendapatan Transfer', 'Alokasi Dana Desa', 500000000.00, 0, 'dipublikasikan', '2026-09-29 19:15:17', '2026-09-29 19:15:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendapatan_rekenings`
--
CREATE TABLE `pendapatan_rekenings` (
  `id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uraian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `level` tinyint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pendapatan_rekenings`
--

INSERT INTO `pendapatan_rekenings` (`id`, `kode`, `uraian`, `parent_id`, `level`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '4', 'Pendapatan', NULL, 1, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(2, '4.1', 'Pendapatan Asli Desa', 1, 2, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(3, '4.1.1', 'Hasil Usaha Desa', 2, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(4, '4.1.1.01', 'Bagi Hasil BUMDes', 3, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(5, '4.1.1.99', 'Lain-lain Hasil Usaha Desa', 3, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(6, '4.1.2', 'Hasil Aset Desa', 2, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(7, '4.1.2.01', 'Pengelolaan Tanah Kas Desa', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(8, '4.1.2.02', 'Tambatan Perahu', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(9, '4.1.2.03', 'Pasar Desa', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(10, '4.1.2.04', 'Tempat Pemandian Umum', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(11, '4.1.2.05', 'Jaringan Irigasi Desa', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(12, '4.1.2.06', 'Pelelangan Ikan Milik Desa', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(13, '4.1.2.07', 'Hasil Kios Milik Desa', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(14, '4.1.2.08', 'Pemanfaatan Sarana/Prasarana Olahraga', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(15, '4.1.2.99', 'Lain-lain Hasil Aset Desa', 6, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(16, '4.1.3', 'Swadaya, Partisipasi dan Gotong Royong', 2, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(17, '4.1.3.01', 'Hasil Swadaya, Partisipasi dan Gotong Royong', 16, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(18, '4.1.3.99', 'Lain-lain Swadaya, Partisipasi dan Gotong Royong', 16, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(19, '4.1.4', 'Lain-Lain Pendapatan Asli Desa', 2, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(20, '4.1.4.01', 'Hasil Pungutan Desa', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(21, '4.1.4.90', 'Hibah Lomba / Fastival/Kegiatan Lainnya', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(22, '4.1.4.91', 'Bagi Hasil Usaha BUMDesa dan BUMDesa Bersama', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(23, '4.1.4.92', 'Hibah dari Bantuan Pusat untuk Modal BUMDesa', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(24, '4.1.4.93', 'Hibah dari Bantuan Propinsi untuk Modal BUMDesa', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(25, '4.1.4.94', 'Hadiah dari Lomba Desa dan Lomba-Lomba Lainnya', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(26, '4.1.4.99', 'Lain-Lain Pendapatan Asli Desa', 19, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(27, '4.2', 'Pendapatan Transfer', 1, 2, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(28, '4.2.1', 'Dana Desa', 27, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(29, '4.2.1.01', 'Dana Desa', 28, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(30, '4.2.2', 'Bagi Hasil Pajak dan Retribusi', 27, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(31, '4.2.2.01', 'Bagi Hasil Pajak dan Retribusi Daerah Kabupaten/Kota', 30, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(32, '4.2.3', 'Alokasi Dana Desa', 27, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(33, '4.2.3.01', 'Alokasi Dana Desa', 32, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(34, '4.2.4', 'Bantuan Keuangan Provinsi', 27, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(35, '4.2.4.01', 'Bantuan Keuangan dari APBD Provinsi', 34, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(36, '4.2.4.99', 'Lain-lain Bantuan Keuangan APBD Provinsi', 34, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(37, '4.2.5', 'Bantuan Keuangan Kabupaten/Kota', 27, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(38, '4.2.5.01', 'Bantuan Keuangan dari APBD Kabupaten/Kota', 37, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(39, '4.2.5.99', 'Lain-lain Bantuan Keuangan dari APBD Kabupaten/Kota', 37, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(40, '4.3', 'Pendapatan Lain-lain', 1, 2, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(41, '4.3.1', 'Penerimaan dari Hasil Kerjasama Antar Desa', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(42, '4.3.1.01', 'Penerimaan dari Hasil Kerjasama Antar Desa', 41, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(43, '4.3.2', 'Penerimaan dari Hasil Kerjasama dengan Pihak Ketiga', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(44, '4.3.2.01', 'Penerimaan dari Hasil Kerjasama dengan Pihak Ketiga', 43, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(45, '4.3.3', 'Penerimaan Bantuan dari Perusahaan yang Berlokasi di Desa', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(46, '4.3.3.01', 'Penerimaan Bantuan dari Perusahaan yang Berlokasi di Desa', 45, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(47, '4.3.4', 'Hibah dan Sumbangan dari Pihak Ketiga', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(48, '4.3.4.01', 'Hibah dan sumbangan dari Pihak Ketiga', 47, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(49, '4.3.5', 'Koreksi Kesalahan Belanja Tahun-tahun Sebelumnya', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(50, '4.3.5.01', 'Pengembalian Belanja Tahun-tahun Sebelumnya', 49, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(51, '4.3.6', 'Bunga Bank', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(52, '4.3.6.01', 'Bunga Bank', 51, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(53, '4.3.9', 'Lain-lain pendapatan Desa yang sah', 40, 3, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06'),
(54, '4.3.9.99', 'Lain-lain pendapatan Desa yang sah', 53, 4, 1, '2026-09-29 18:00:06', '2026-09-29 18:00:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `realisasi_belanja`
--
CREATE TABLE `realisasi_belanja` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `belanja_id` bigint UNSIGNED NOT NULL,
  `bulan` tinyint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` decimal(18,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `realisasi_belanja`
--

INSERT INTO `realisasi_belanja` (`id`, `tahun_anggaran_id`, `belanja_id`, `bulan`, `tanggal`, `nilai`, `keterangan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(2, 1, 2, 10, '2026-10-02', 27000000.00, 'Siltap Kepala Desa', 'dipublikasikan', '2026-10-02 11:33:38', '2026-10-02 11:33:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `realisasi_pembiayaan`
--
CREATE TABLE `realisasi_pembiayaan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `pembiayaan_id` bigint UNSIGNED NOT NULL,
  `bulan` tinyint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` decimal(18,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `realisasi_pembiayaan`
--

INSERT INTO `realisasi_pembiayaan` (`id`, `tahun_anggaran_id`, `pembiayaan_id`, `bulan`, `tanggal`, `nilai`, `keterangan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 10, '2026-10-02', 12000000.00, 'Silpa Tahun Sebelumnya', 'dipublikasikan', '2026-10-02 11:34:19', '2026-10-02 11:34:19'),
(2, 1, 4, 10, '2026-10-02', 350000000.00, 'Dana Cadangan', 'dipublikasikan', '2026-10-02 11:34:42', '2026-10-02 11:34:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `realisasi_pendapatan`
--
CREATE TABLE `realisasi_pendapatan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `pendapatan_id` bigint UNSIGNED NOT NULL,
  `bulan` tinyint UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` decimal(18,2) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `realisasi_pendapatan`
--

INSERT INTO `realisasi_pendapatan` (`id`, `tahun_anggaran_id`, `pendapatan_id`, `bulan`, `tanggal`, `nilai`, `keterangan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(4, 1, 8, 10, '2026-10-02', 350000000.00, 'Dana Desa', 'dipublikasikan', '2026-10-02 11:32:39', '2026-10-02 11:39:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_bidang`
--
CREATE TABLE `sub_bidang` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `bidang_id` bigint UNSIGNED NOT NULL,
  `kode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipublikasikan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sub_bidang`
--

INSERT INTO `sub_bidang` (`id`, `tahun_anggaran_id`, `bidang_id`, `kode`, `nama`, `urutan`, `status_publikasi`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '01.01', 'Penyelenggaran Belanja Siltap, Tunjangan dan Operasional Pemerintahan Desa', 101, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(2, 1, 3, '02.01', 'Sub Bidang Pendidikan', 201, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(3, 1, 3, '02.02', 'Sub Bidang Kesehatan', 202, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(4, 1, 3, '02.03', 'Sub Bidang Pekerjaan Umum dan Penataan Ruang', 203, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(5, 1, 3, '02.04', 'Sub Bidang Kawasan Pemukiman', 204, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(6, 1, 3, '02.05', 'Sub Bidang Kehutanan dan Lingkungan Hidup', 205, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(7, 1, 3, '02.06', 'Sub Bidang Perhubungan, Komunikasi dan Informatika', 206, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(8, 1, 3, '02.07', 'Sub Bidang Energi dan Sumberdaya Mineral', 207, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(9, 1, 3, '02.08', 'Sub Bidang Pariwisata', 208, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(10, 1, 4, '03.01', 'Sub Bidang Ketenteraman, Ketertiban Umum dan Perlindungan Masyarakat', 301, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(11, 1, 4, '03.02', 'Sub Bidang Kebudayaan dan Keagamaan', 302, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(12, 1, 4, '03.03', 'Sub Bidang Kepemudaan dan Olahraga', 303, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(13, 1, 4, '03.04', 'Sub Bidang Kelembagaan Masyarakat', 304, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(14, 1, 5, '04.01', 'Sub Bidang Kelautan dan Perikanan', 401, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(15, 1, 5, '04.02', 'Sub Bidang Pertanian dan Peternakan', 402, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(16, 1, 5, '04.03', 'Sub Bidang Peningkatan Kapasitas Aparatur Desa', 403, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(17, 1, 5, '04.04', 'Sub Bidang Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga', 404, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(18, 1, 5, '04.05', 'Sub Bidang Koperasi, Usaha Micro Kecil dan Menengah (UMKM)', 405, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(19, 1, 5, '04.06', 'Sub Bidang Dukungan Penanaman Modal', 406, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(20, 1, 5, '04.07', 'Sub Bidang Perdagangan dan Perindustrian', 407, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(21, 1, 6, '05.01', 'Sub Bidang Penanggulangan Bencana', 501, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(22, 1, 6, '05.02', 'Sub Bidang Keadaan Darurat', 502, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(23, 1, 6, '05.03', 'Sub Bidang Keadaan Mendesak', 503, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(24, 1, 2, '01.02', 'Penyediaan Sarana Prasarana Pemerintahan Desa', 102, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(25, 1, 2, '01.03', 'Pengelolaan Administrasi Kependudukan, Pencatatan Sipil, Statistik dan Kearsipan', 103, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(26, 1, 2, '01.04', 'Penyelenggaraan Tata Praja Pemerintahan, Perencanaan, Keuangan dan Pelaporan', 104, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34'),
(27, 1, 2, '01.05', 'Sub Bidang Pertanahan', 105, 'dipublikasikan', '2026-09-30 08:23:34', '2026-09-30 08:23:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kegiatan`
--
CREATE TABLE `sub_kegiatan` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun_anggaran_id` bigint UNSIGNED NOT NULL,
  `kegiatan_id` bigint UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `urutan` int UNSIGNED NOT NULL DEFAULT '0',
  `status_publikasi` enum('draft','dipublikasikan','tidak_dipublikasikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun_anggaran`
--
CREATE TABLE `tahun_anggaran` (
  `id` bigint UNSIGNED NOT NULL,
  `tahun` smallint UNSIGNED NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'nonaktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tahun_anggaran`
--

INSERT INTO `tahun_anggaran` (`id`, `tahun`, `status`, `created_at`, `updated_at`) VALUES
(1, 2026, 'aktif', '2026-09-29 05:46:44', '2026-10-02 17:07:10'),
(2, 2027, 'nonaktif', '2026-10-02 17:07:06', '2026-10-02 17:07:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--
CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator Desa', 'admin', 'admin@eapbdesa.test', NULL, '$2y$12$o31uBN3kmhoMttuhh35rd.sJp3D0byvCYH26szjFSNQ.SBwGNpxOi', NULL, '2026-09-29 05:46:44', '2026-10-03 02:03:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `visitor_logs`
--
CREATE TABLE `visitor_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `visitor_key` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visited_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `visitor_logs`
--

INSERT INTO `visitor_logs` (`id`, `visitor_key`, `ip_hash`, `user_agent_hash`, `path`, `visited_date`, `created_at`, `updated_at`) VALUES
(1, '09ebae78-5c24-47d5-aba2-dac942ed05e5', '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'c4ea766a755ddee08f488270809d57453d14de55e76ff46b7a9b02b099f0d440', '/', '2026-10-02', '2026-10-02 14:57:17', '2026-10-02 14:57:17'),
(2, '09ebae78-5c24-47d5-aba2-dac942ed05e5', '12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0', 'c4ea766a755ddee08f488270809d57453d14de55e76ff46b7a9b02b099f0d440', 'pendapatan/2026', '2026-10-03', '2026-10-02 16:01:07', '2026-10-02 16:01:07');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `belanja`
--
ALTER TABLE `belanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `belanja_tahun_anggaran_id_foreign` (`tahun_anggaran_id`),
  ADD KEY `belanja_bidang_id_foreign` (`bidang_id`),
  ADD KEY `belanja_kegiatan_id_foreign` (`kegiatan_id`),
  ADD KEY `belanja_sub_kegiatan_id_foreign` (`sub_kegiatan_id`),
  ADD KEY `belanja_belanja_rekening_id_foreign` (`belanja_rekening_id`);

--
-- Indeks untuk tabel `belanja_rekenings`
--
ALTER TABLE `belanja_rekenings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `belanja_rekenings_kode_unique` (`kode`),
  ADD KEY `belanja_rekenings_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bidang_tahun_anggaran_id_foreign` (`tahun_anggaran_id`);

--
-- Indeks untuk tabel `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dokumen_publikasi`
--
ALTER TABLE `dokumen_publikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_publikasi_tahun_anggaran_id_foreign` (`tahun_anggaran_id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kegiatan_tahun_anggaran_id_foreign` (`tahun_anggaran_id`),
  ADD KEY `kegiatan_bidang_id_foreign` (`bidang_id`),
  ADD KEY `kegiatan_sub_bidang_id_foreign` (`sub_bidang_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pembiayaan`
--
ALTER TABLE `pembiayaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembiayaan_tahun_anggaran_id_foreign` (`tahun_anggaran_id`),
  ADD KEY `pembiayaan_pembiayaan_rekening_id_foreign` (`pembiayaan_rekening_id`);

--
-- Indeks untuk tabel `pembiayaan_rekenings`
--
ALTER TABLE `pembiayaan_rekenings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pembiayaan_rekenings_kode_unique` (`kode`),
  ADD KEY `pembiayaan_rekenings_parent_id_foreign` (`parent_id`),
  ADD KEY `pembiayaan_rekenings_jenis_index` (`jenis`),
  ADD KEY `pembiayaan_rekenings_level_index` (`level`);

--
-- Indeks untuk tabel `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pendapatan_year_rekening_unique` (`tahun_anggaran_id`,`pendapatan_rekening_id`),
  ADD KEY `pendapatan_pendapatan_rekening_id_foreign` (`pendapatan_rekening_id`);

--
-- Indeks untuk tabel `pendapatan_rekenings`
--
ALTER TABLE `pendapatan_rekenings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pendapatan_rekenings_kode_unique` (`kode`),
  ADD KEY `pendapatan_rekenings_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `realisasi_belanja`
--
ALTER TABLE `realisasi_belanja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `realisasi_belanja_belanja_id_foreign` (`belanja_id`),
  ADD KEY `realisasi_belanja_tahun_anggaran_id_bulan_index` (`tahun_anggaran_id`,`bulan`);

--
-- Indeks untuk tabel `realisasi_pembiayaan`
--
ALTER TABLE `realisasi_pembiayaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `realisasi_pembiayaan_pembiayaan_id_foreign` (`pembiayaan_id`),
  ADD KEY `realisasi_pembiayaan_tahun_anggaran_id_bulan_index` (`tahun_anggaran_id`,`bulan`);

--
-- Indeks untuk tabel `realisasi_pendapatan`
--
ALTER TABLE `realisasi_pendapatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `realisasi_pendapatan_pendapatan_id_foreign` (`pendapatan_id`),
  ADD KEY `realisasi_pendapatan_tahun_anggaran_id_bulan_index` (`tahun_anggaran_id`,`bulan`);

--
-- Indeks untuk tabel `sub_bidang`
--
ALTER TABLE `sub_bidang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_bidang_tahun_anggaran_id_kode_unique` (`tahun_anggaran_id`,`kode`),
  ADD KEY `sub_bidang_bidang_id_foreign` (`bidang_id`);

--
-- Indeks untuk tabel `sub_kegiatan`
--
ALTER TABLE `sub_kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_kegiatan_tahun_anggaran_id_foreign` (`tahun_anggaran_id`),
  ADD KEY `sub_kegiatan_kegiatan_id_foreign` (`kegiatan_id`);

--
-- Indeks untuk tabel `tahun_anggaran`
--
ALTER TABLE `tahun_anggaran`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tahun_anggaran_tahun_unique` (`tahun`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- Indeks untuk tabel `visitor_logs`
--
ALTER TABLE `visitor_logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `visitor_logs_visitor_date_unique` (`visitor_key`,`visited_date`),
  ADD KEY `visitor_logs_visited_date_index` (`visited_date`),
  ADD KEY `visitor_logs_visitor_key_index` (`visitor_key`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanja`
--
ALTER TABLE `belanja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `belanja_rekenings`
--
ALTER TABLE `belanja_rekenings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT untuk tabel `bidang`
--
ALTER TABLE `bidang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `desa`
--
ALTER TABLE `desa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dokumen_publikasi`
--
ALTER TABLE `dokumen_publikasi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pembiayaan`
--
ALTER TABLE `pembiayaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pembiayaan_rekenings`
--
ALTER TABLE `pembiayaan_rekenings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `pendapatan`
--
ALTER TABLE `pendapatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pendapatan_rekenings`
--
ALTER TABLE `pendapatan_rekenings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `realisasi_belanja`
--
ALTER TABLE `realisasi_belanja`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `realisasi_pembiayaan`
--
ALTER TABLE `realisasi_pembiayaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `realisasi_pendapatan`
--
ALTER TABLE `realisasi_pendapatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `sub_bidang`
--
ALTER TABLE `sub_bidang`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `sub_kegiatan`
--
ALTER TABLE `sub_kegiatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tahun_anggaran`
--
ALTER TABLE `tahun_anggaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `visitor_logs`
--
ALTER TABLE `visitor_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `belanja`
--
ALTER TABLE `belanja`
  ADD CONSTRAINT `belanja_belanja_rekening_id_foreign` FOREIGN KEY (`belanja_rekening_id`) REFERENCES `belanja_rekenings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `belanja_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `belanja_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `belanja_sub_kegiatan_id_foreign` FOREIGN KEY (`sub_kegiatan_id`) REFERENCES `sub_kegiatan` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `belanja_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `belanja_rekenings`
--
ALTER TABLE `belanja_rekenings`
  ADD CONSTRAINT `belanja_rekenings_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `belanja_rekenings` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `bidang`
--
ALTER TABLE `bidang`
  ADD CONSTRAINT `bidang_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dokumen_publikasi`
--
ALTER TABLE `dokumen_publikasi`
  ADD CONSTRAINT `dokumen_publikasi_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kegiatan_sub_bidang_id_foreign` FOREIGN KEY (`sub_bidang_id`) REFERENCES `sub_bidang` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kegiatan_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembiayaan`
--
ALTER TABLE `pembiayaan`
  ADD CONSTRAINT `pembiayaan_pembiayaan_rekening_id_foreign` FOREIGN KEY (`pembiayaan_rekening_id`) REFERENCES `pembiayaan_rekenings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembiayaan_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembiayaan_rekenings`
--
ALTER TABLE `pembiayaan_rekenings`
  ADD CONSTRAINT `pembiayaan_rekenings_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `pembiayaan_rekenings` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pendapatan`
--
ALTER TABLE `pendapatan`
  ADD CONSTRAINT `pendapatan_pendapatan_rekening_id_foreign` FOREIGN KEY (`pendapatan_rekening_id`) REFERENCES `pendapatan_rekenings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pendapatan_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendapatan_rekenings`
--
ALTER TABLE `pendapatan_rekenings`
  ADD CONSTRAINT `pendapatan_rekenings_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `pendapatan_rekenings` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `realisasi_belanja`
--
ALTER TABLE `realisasi_belanja`
  ADD CONSTRAINT `realisasi_belanja_belanja_id_foreign` FOREIGN KEY (`belanja_id`) REFERENCES `belanja` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `realisasi_belanja_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `realisasi_pembiayaan`
--
ALTER TABLE `realisasi_pembiayaan`
  ADD CONSTRAINT `realisasi_pembiayaan_pembiayaan_id_foreign` FOREIGN KEY (`pembiayaan_id`) REFERENCES `pembiayaan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `realisasi_pembiayaan_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `realisasi_pendapatan`
--
ALTER TABLE `realisasi_pendapatan`
  ADD CONSTRAINT `realisasi_pendapatan_pendapatan_id_foreign` FOREIGN KEY (`pendapatan_id`) REFERENCES `pendapatan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `realisasi_pendapatan_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_bidang`
--
ALTER TABLE `sub_bidang`
  ADD CONSTRAINT `sub_bidang_bidang_id_foreign` FOREIGN KEY (`bidang_id`) REFERENCES `bidang` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_bidang_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kegiatan`
--
ALTER TABLE `sub_kegiatan`
  ADD CONSTRAINT `sub_kegiatan_kegiatan_id_foreign` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sub_kegiatan_tahun_anggaran_id_foreign` FOREIGN KEY (`tahun_anggaran_id`) REFERENCES `tahun_anggaran` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
