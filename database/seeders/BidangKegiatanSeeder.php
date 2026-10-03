<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BidangKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = DB::table('tahun_anggaran')->orderByDesc('tahun')->first();

        if (!$tahun) {
            throw new RuntimeException('Belum ada Tahun Anggaran. Buat Tahun Anggaran terlebih dahulu.');
        }

        $tahunId = $tahun->id;

        $master = [
            ['01', 'BIDANG PENYELENGGARAN PEMERINTAHAN DESA'],
            ['01.01', 'Penyelenggaran Belanja Siltap, Tunjangan dan Operasional Pemerintahan Desa'],
            ['01.01.01', 'Penyediaan Penghasilan Tetap dan Tunjangan Kepala Desa'],
            ['01.01.02', 'Penyediaan Penghasilan Tetap dan Tunjangan Perangkat Desa'],
            ['01.01.03', 'Penyediaan Jaminan Sosial bagi Kepala Desa dan Perangkat Desa'],
            ['01.01.04', 'Penyediaan Operasional Pemerintah Desa (ATK, Honor PKPKD dan PPKD dll)'],
            ['01.01.05', 'Penyediaan Tunjangan BPD'],
            ['01.01.06', 'Penyediaan Operasional BPD (rapat, ATK, Makan Minum, Pakaian Seragam, Listrik dll)'],
            ['01.01.07', 'Penyediaan Insentif/Operasional RT/RW'],
            ['01.01.08', 'Penyediaan Operasional Pemerintah Desa yang bersumber dari Dana Desa'],
            ['01.01.09', 'Penyediaan Jaminan Sosial bagi BPD'],
            ['01.01.90', 'Penyediaan Penghasilan Tetap dan Tunjangan Staf Perangkat Desa'],
            ['01.01.91', 'Penyediaan Penghasilan Tetap dan Tunjangan Staf BPD'],
            ['01.01.92', 'Tambahan Penghasilan Tunjangan Hari Raya Kades Dan Perangkat Desa'],
            ['01.01.93', 'Tambahan Penghasilan Tunjangan Hari Raya Staf Perangkat Desa dan Staf BPD'],
            ['01.01.94', 'Tambahan Penghasilan Tunjangan Hari Raya Ketua dan Anggota BPD'],
            ['01.01.95', 'Penyediaan Jaminan Sosial BPJS Ketenagakerjaan bagi BPD'],
            ['01.01.96', 'Penyediaan Jaminan Sosial BPJS Ketenagakerjaan bagi Staf Perangkat Desa'],
            ['01.01.97', 'Penyediaan Jaminan Sosial BPJS Ketenagakerjaan bagi Staf BPD'],
            ['01.01.99', 'Lain-lain Sub Bidang Siltap dan Operasional Pemerintahan Desa'],
            ['01.02', 'Penyediaan Sarana Prasarana Pemerintahan Desa'],
            ['01.02.01', 'Penyediaan Sarana (Aset Tetap) Perkantoran/Pemerintahan'],
            ['01.02.02', 'Pemeliharaan Gedung/Prasarana Kantor Desa'],
            ['01.02.03', 'Pembangunan/Rehabilitasi/Peningkatan Gedung/Prasarana Kantor Desa **)'],
            ['01.02.90', 'Penetapan Pos Keamanan dan Kesiap Siagaan'],
            ['01.02.91', 'Pemeliharaan Sarana dan Prsarana Pemerintahan Desa'],
            ['01.02.99', 'Lain-lain Sub Bidang Sarana Prasarana Pemerintahan Desa'],
            ['01.03', 'Pengelolaan Administrasi Kependudukan, Pencatatan Sipil, Statistik dan Kearsipan'],
            ['01.03.01', 'Pelayanan Administrasi Umum dan Kependudukan'],
            ['01.03.02', 'Penyusunan, Pendataan, dan Pemutakhiran Profil Desa **)'],
            ['01.03.03', 'Pengelolaan Administrasi dan Kearsipan Pemerintahan Desa'],
            ['01.03.04', 'Penyuluhan dan Penyadaran Masyarakat tentang Kependudukan dan Capil'],
            ['01.03.05', 'Pemetaan dan Analisis Kemiskinan Desa secara Partisipatif'],
            ['01.03.90', 'Pendataan Kependudukan'],
            ['01.03.91', 'Penyelanggaraan Evaluasi Tingkat Perkembangan Desa'],
            ['01.03.92', 'Pendataan Tenaga Kerja di Desa'],
            ['01.03.93', 'Pendataan Penduduk yang Bekerja pada sektor Pertanian dan sektor non Pertanian'],
            ['01.03.94', 'Pendataan Penduduk menurut jumlah Penduduk usia Kerja, angkatan Kerja'],
            ['01.03.95', 'Pendataan Penduduk berumur 15 Tahun keatas yang bekerja menurut Lapangan Kerja'],
            ['01.03.96', 'Pendataan Potensi Desa'],
            ['01.03.97', 'Pemutahiran data berbasis SDGs Desa'],
            ['01.03.98', 'Pendataan dan Pemutahiran data IDM'],
            ['01.03.99', 'Lain-lain Sub Bidang Administrasi Kependudukan, Capil, Statistik dan Kearsipan'],
            ['01.04', 'Penyelenggaraan Tata Praja Pemerintahan, Perencanaan, Keuangan dan Pelaporan'],
            ['01.04.01', 'Penyelenggaraan Musyawarah Perencanaan Desa/Pembahasan APBDes (Reguler)'],
            ['01.04.02', 'Penyelenggaraan Musyawarah Desa Lainnya (Musdus, Rembug desa Non Reguler)'],
            ['01.04.03', 'Penyusunan Dokumen Perencanaan Desa (RPJMDesa/RKPDesa dll)'],
            ['01.04.04', 'Penyusunan Dokumen Keuangan Desa (APBDes, APBDes Perubahan, LPJ dll)'],
            ['01.04.05', 'Pengelolaan Administrasi/ Inventarisasi/Penilaian Aset Desa'],
            ['01.04.06', 'Penyusunan Kebijakan Desa (Perdes/Perkades selain Perencanaan/Keuangan)'],
            ['01.04.07', 'Penyusunan Laporan Kepala Desa, LPPDesa dan Informasi Kepada Masyarakat'],
            ['01.04.08', 'Pengembangan Sistem Informasi Desa'],
            ['01.04.09', 'Koordinasi/Kerjasama Penyelenggaraan Pemerintahan & Pembangunan Desa'],
            ['01.04.10', 'Dukungan Pelaksanaan & Sosialisasi Pilkades, Penyaringan dan Penjaringan Perangkat Desa, dan Pemilihan BPD (yang menjadi wewenang Desa)'],
            ['01.04.11', 'Penyelenggaraan Lomba antar Kewilayahan & Pengiriman Kontingen dalam Mengikuti Lomba Desa'],
            ['01.04.12', 'Dukungan Biaya Operasional dan Biaya Lainnya untuk Desa Persiapan'],
            ['01.04.90', 'Penyelanggaraan Kerja Sama Antar Desa'],
            ['01.04.91', 'Pembentukan Badan Permusyawatan Desa'],
            ['01.04.92', 'Penetapan / Pengukuhan Kepala Desa dan Perangkat Desa'],
            ['01.04.93', 'Penyusunan Produk Hukum Desa'],
            ['01.04.94', 'Pengembangan dan Pengelolaan sistem administrasi dan Informasi di Desa'],
            ['01.04.95', 'Penetapan dan / Pengukuhan Badan Permusyawatan Desa'],
            ['01.04.96', 'Penetapan Organisasi Pemerintahan Desa'],
            ['01.04.97', 'Pemberhatian/Pengangkatan dan Mutasi Staf dan Perangkat Desa serta Staf BPD'],
            ['01.04.98', 'Penyelanggaraan Pemilihan Kepala Desa'],
            ['01.04.99', 'Lain-lain Sub Bidang Tata Praja Pemerintahan, Perencanaan, Keuangan & Pelaporan'],
            ['01.05', 'Sub Bidang Pertanahan'],
            ['01.05.01', 'Sertifikasi Tanah Kas Desa'],
            ['01.05.02', 'Administrasi Pertanahan (Pendaftaran Tanah dan Pemberian Registrasi Agenda Pertanahan)'],
            ['01.05.03', 'Fasilitasi Sertifikasi Tanah untuk Masyarakat Miskin'],
            ['01.05.04', 'Kegiatan Mediasi Konflik Pertanahan'],
            ['01.05.05', 'Kegiatan Penyuluhan Pertanahan'],
            ['01.05.06', 'Adminstrasi Pajak Bumi dan Bangunan (PBB)'],
            ['01.05.07', 'Penentuan/Penegasan Batas/patok Tanah Kas Desa'],
            ['01.05.08', 'Penyediaan Tanah Kas Desa'],
            ['01.05.90', 'Penyusunan Tata Ruang Desa'],
            ['01.05.91', 'Pengelolaan Tanah Desa'],
            ['01.05.92', 'Pengembangan Tata Ruang dan Peta Sosial Desa'],
            ['01.05.93', 'Pemberian Ijin Hak Pengelolaan Atas Tanah Desa'],
            ['01.05.94', 'Pelatihan Penyelesaian Mediasi Sengketa Aset Desa untuk Warga Desa'],
            ['01.05.99', 'Lain-lain Sub Bidang Pertanahan'],
            ['02', 'BIDANG PELAKSANAAN PEMBANGUNAN DESA'],
            ['02.01', 'Sub Bidang Pendidikan'],
            ['02.01.01', 'Penyelenggaraan PAUD/TK/TPA/TKA/TPQ/Madrasah Non-Formal Milik Desa (Honor, Pakaian dll)'],
            ['02.01.02', 'Dukungan Penyelenggaraan PAUD (APE, Sarana PAUD dst)'],
            ['02.01.03', 'Penyuluhan dan Pelatihan Pendidikan Bagi Masyarakat'],
            ['02.01.04', 'Pemeliharaan Sarana Prasarana Perpustakaan/Taman Bacaan/Sanggar Belajar Milik Desa'],
            ['02.01.05', 'Pemeliharaan Sarana Prasarana PAUD/TK/TPA/TKA/TPQ/Madrasah Non-formal Milik Desa'],
            ['02.01.06', 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana/Prasarana/Alat Peraga PAUD/ TK/TPA/TKA/TPQ/Madrasah Nonformal'],
            ['02.01.07', 'Pembangunan/Rehabilitasi/Peningkatan Sarana/Prasarana Perpustakaan/Taman Bacaan Desa/ Sanggar Belajar Milik Desa'],
            ['02.01.08', 'Pengelolaan Perpustakaan Milik Desa (Pengadaan Buku, Honor, Taman Baca)'],
            ['02.01.09', 'Pengembangan dan Pembinaan Sanggar Seni dan Belajar'],
            ['02.01.10', 'Dukungan Pendidikan bagi Siswa Miskin/Berprestasi'],
            ['02.01.90', 'Pembangunan dan Pemeliharaan Balain Pelathan/Keiatan Belajar Masyarakat'],
            ['02.01.91', 'Fasilitasi dan Motivasi Kelompok Belajar di Desa'],
            ['02.01.92', 'Pembangunan/Rehabilitasi/Pemeliharaan/peningkatan Gedung Serbaguna di Desa'],
            ['02.01.93', 'Pembangunan/Rehabilitasi/Pemeliharaan/peningkatan Gedung Seni di Desa'],
            ['02.01.94', 'Pembangunan/Rehabilitasi/Pemeliharaan/peningkatan Gedung dan Museum di Desa'],
            ['02.01.95', 'Lomba Melukis/Menulis Keindahan Alam Hidup Hidup Bersih dan Sehat Anak Pantai'],
            ['02.01.96', 'Lomba Melukis/Monografi di Desa'],
            ['02.01.97', 'Pengelolaan Pelayanan Pendidikan dan Kebudayaan'],
            ['02.01.99', 'Lain-lain Kegiatan Sub Bidang Pendidikan'],
            ['02.02', 'Sub Bidang Kesehatan'],
            ['02.02.01', 'Penyelenggaraan Pos Kesehatan Desa/Polindes Milik Desa (obat, Insentif, KB, dsb)'],
            ['02.02.02', 'Penyelenggaraan Posyandu (Makanan Tambahan, Kelas Bumil, Lansia, Insentif)'],
            ['02.02.03', 'Penyuluhan dan Pelatihan Bidang Kesehatan (Untuk Masyarakat, Tenaga dan Kader Kesehatan dll)'],
            ['02.02.04', 'Penyelenggaraan Desa Siaga Kesehatan'],
            ['02.02.05', 'Pembinaan Palang Merah Remaja (PMR) Tingkat Desa'],
            ['02.02.06', 'Pengasuhan Bersama atau Bina Keluarga Balita (BKB)'],
            ['02.02.07', 'Pembinaan dan Pengawasan Upaya Kesehatan Tradisional'],
            ['02.02.08', 'Pemeliharaan Sarana Prasarana Posyandu/Polindes/PKD'],
            ['02.02.09', 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana/PrasaranaPosyandu/Polindes/PKD **'],
            ['02.02.90', 'Pemantauan dan Pencegahan Penyalahgunaan Narkotika dan Zat adiktif'],
            ['02.02.91', 'Pembangunan Pengambahan Ruang Rawat Inap Poskesdes( Posyandu Apung/Perahu'],
            ['02.02.92', 'Pengadaan Tambahan Peralatan Kesehatan Emergence Poskesdes'],
            ['02.02.93', 'Penyelengaraan Promosi Kesehatan dan Gerakan Hidup Bersih dan Sehat'],
            ['02.02.94', 'Sosialisasi Ancaman Penyakit ISPA Khususnya Bagi Buruh/Karyawan dari Desa yang Bekerja di Pabrik'],
            ['02.02.95', 'Sosialisasi Ancaman Penyakit di musim Kemarau dan Penghujan'],
            ['02.02.96', 'Sosialisasi Pencegahan dan Penanganan Penyakit Masyarakat'],
            ['02.02.97', 'Penyelanggaraan Promosi Kesehatan dan Gerakan Hidup Bersih dan Sehat'],
            ['02.02.98', 'Penambahan Peralatan pada Ambulance di Desa'],
            ['02.02.99', 'Lain-lain Kegiatan Sub Bidang Kesehatan'],
            ['02.03', 'Sub Bidang Pekerjaan Umum dan Penataan Ruang'],
            ['02.03.01', 'Pemeliharaan Jalan Desa'],
            ['02.03.02', 'Pemeliharaan Jalan Lingkungan Pemukiman/Gang'],
            ['02.03.03', 'Pemeliharaan Jalan Usaha Tani'],
            ['02.03.04', 'Pemeliharaan Jembatan Desa'],
            ['02.03.05', 'Pemeliharaan Prasarana Jalan Desa (Gorong-gorong/Selokan/Parit/Drainase dll)'],
            ['02.03.06', 'Pemeliharaan Gedung/Prasarana Balai Desa/Balai Kemasyarakatan'],
            ['02.03.07', 'Pemeliharaan Pemakaman /Situs Bersejarah/Petilasan Milik Desa'],
            ['02.03.08', 'Pemeliharaan Embung Milik Desa'],
            ['02.03.09', 'Pemeliharaan Monumen/Gapura/Batas Desa'],
            ['02.03.10', 'Pembangunan/Rehabilitas/Peningkatan/Pengerasan Jalan Desa **)'],
            ['02.03.11', 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Lingkungan Permukiman **)'],
            ['02.03.12', 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jalan Usaha Tani **)'],
            ['02.03.13', 'Pembangunan/Rehabilitasi/Peningkatan/Pengerasan Jembatan Milik Desa **)'],
            ['02.03.14', 'Pembangunan/Rehabilitasi/Peningkatan Prasarana Jalan Desa (Gorong, selokan dll)'],
            ['02.03.15', 'Pembangunan/Rehabilitasi/Peningkatan Balai Desa/Balai Kemasyarakatan **)'],
            ['02.03.16', 'Pembangunan/Rehabilitasi/Peningkatan Pemakaman Milik Desa/Situs BersejarahMilik Desa/Petilasan'],
            ['02.03.17', 'Pembuatan/Pemutakhiran Peta Wilayah dan Sosial Desa **)'],
            ['02.03.18', 'Penyusunan Dokumen Perencanaan Tata Ruang Desa'],
            ['02.03.19', 'Pembangunan/Rehabilitasi/Peningkatan Embung Desa **)'],
            ['02.03.20', 'Pembangunan/Rehabilitasi/Peningkatan Monumen/Gapura/Batas Desa **)'],
            ['02.03.21', 'Pengurukan Tanah dalam rangka mendukung Koperasi Desa Merah Putih (KDMP)'],
            ['02.03.90', 'Penerangan Jalan,Taman dan Lingkungan'],
            ['02.03.91', 'Pembangunan/Rehabilitasi/Peningkatan Taman Desa'],
            ['02.03.92', 'Pembangunan/Rehabilitasi/Peningkatan Siring'],
            ['02.03.94', 'Pembangunan/Rehabilitasi/Peningkatan Siring Sungai'],
            ['02.03.95', 'Rehabilitasi dan Penambahan Unit Fasilitas Jamban Publik'],
            ['02.03.96', 'Pengadaan Sarana dan Prasarana Pengelolaan Sampah di Desa'],
            ['02.03.97', 'Pengadaan Sarana dan Prasarana Pengelolaan Sampah Rumah Tangga dan Kawasan Wisata di Desa'],
            ['02.03.99', 'Lain-lain Kegiatan Sub Bidang Pekerjaan Umum dan Tata Ruang'],
            ['02.04', 'Sub Bidang Kawasan Pemukiman'],
            ['02.04.01', 'Dukungan Pelaksanaan Program Pembangunan/Rehab Rumah Tidak Layak Huni GAKIN'],
            ['02.04.02', 'Pemeliharaan Sumur Resapan Milik Desa'],
            ['02.04.03', 'Pemeliharaan Sumber Air Bersih Milik Desa (Mata Air, Penampung Air, Sumur Bor dll)'],
            ['02.04.04', 'Pemeliharaan Sambungan Air Bersih ke Rumah Tangga (Pipanisasi dll)'],
            ['02.04.05', 'Pemeliharaan Sanitasi Pemukiman (Gorong-gorong, Selokan, Parit diluar Prasarana Jalan))'],
            ['02.04.06', 'Pemeliharaan Fasilitas Jamban Umum/MCK Umum dll'],
            ['02.04.07', 'Pemeliharaan Fasilitas Pengelolaan Sampah Desa (Penampungan,Bank Sampah, dll)'],
            ['02.04.08', 'Pemeliharaan Sistem Pembuangan Air Limbah (Drainase, Air limbah Rumah Tangga)'],
            ['02.04.09', 'Pemeliharaan Taman/Taman Bermain Anak Milik Desa'],
            ['02.04.10', 'Pembangunan/Rehabilitasi/Peningkatan Sumur Resapan **)'],
            ['02.04.11', 'Pembangunan/Rehabilitasi/Peningkatan Sumber Air Bersih Milik Desa **)'],
            ['02.04.12', 'Pembangunan/Rehabilitasi/Peningkatan Sambungan Air Bersih ke Rumah Tangga **)'],
            ['02.04.13', 'Pembangunan/Rehabilitasi/Peningkatan Sanitasi Permukiman **)'],
            ['02.04.14', 'Pembangunan/Rehabilitasi/Peningkatan Fasilitas Jamban Umum/MCK umum, dll **)'],
            ['02.04.15', 'Pembangunan/Rehabilitasi/Peningkatan Fasilitas Pengelolaan Sampah **)'],
            ['02.04.16', 'Pembangunan/Rehabilitasi/Peningkatan Sistem Pembuangan Air Limbah **)'],
            ['02.04.17', 'Pembangunan/Rehabilitasi/Peningkatan Taman/Taman Bermain Anak Milik Desa **)'],
            ['02.04.90', 'Pengadaan, Pembangunan, Pengembangan dan pemeliharaan sarana dan prasarana lingkungan pemukiman'],
            ['02.04.99', 'Lain-lain Kegiatan Sub Bidang Perumahan Rakyat dan Kawasan Pemukiman'],
            ['02.05', 'Sub Bidang Kehutanan dan Lingkungan Hidup'],
            ['02.05.01', 'Pengelolaan Hutan Milik Desa'],
            ['02.05.02', 'Pengelolaan Lingkungan Hidup Milik Desa'],
            ['02.05.03', 'Pelatihan/Sosialisasi/Penyuluhan/Penyadaran tentang LH danKehutanan **)'],
            ['02.05.99', 'Lain-lain Kegiatan Sub Bidang Kehutanan dan Lingkungan Hidup'],
            ['02.06', 'Sub Bidang Perhubungan, Komunikasi dan Informatika'],
            ['02.06.01', 'Pembuatan Rambu-rambu di Jalan Desa'],
            ['02.06.02', 'Penyelenggaraan Informasi Publik Desa (Poster, Baliho Dll)'],
            ['02.06.03', 'Pengelolaan dan Pembuatan Jaringan/Instalasi Komunikasi dan Informasi Lokal Desa'],
            ['02.06.04', 'Pemeliharaan Sarana dan Prasarana Transportasi Desa'],
            ['02.06.05', 'Pembangunan/Rehabilitasi/Peningkatan/Pengadaan Sarana & Prasarana Transportasi Desa'],
            ['02.06.90', 'Pembangunan Tambatan Perahu di Desa'],
            ['02.06.91', 'Pemasangan jaringan Internet'],
            ['02.06.92', 'Pembangunan Tower Untuk Jaringan Internet di Desa'],
            ['02.06.99', 'Lain-lain Kegiatan Sub Bidang Perhubungan, Komunikasi dan Informatika'],
            ['02.07', 'Sub Bidang Energi dan Sumberdaya Mineral'],
            ['02.07.01', 'Pemeliharaan Sarana dan Prasarana Energi Alternatif Tingkat Desa'],
            ['02.07.02', 'Pembangunan/Rehabilitasi/Peningkatan Sarana & Prasarana Energi Alternatif Desa'],
            ['02.07.90', 'Pembangunan Sarana dan Prasarana Listrik Mikro Hidro'],
            ['02.07.91', 'Pembangunan dan Pengelolaan Energi Mandiri'],
            ['02.07.92', 'Pembangunan dan Pemeliharaan Instalasi Biogas'],
            ['02.07.93', 'Pembangunan Rintisan Listrik Desa Tenaga Angin/Matahari'],
            ['02.07.94', 'Pelatihan Pemanfaatan limbah Organik Rumah Tangga, sosialisasi, pembentukan dan pelatihan Posyantek Desa dan Posyantek antar Desa dan Perkebunan untuk Bio-Massa Energi'],
            ['02.07.95', 'Percontohan Instalasi dan pusat/ruang Belajar Teknologi Tepat Guna'],
            ['02.07.99', 'lain-lain kegiatan sub bidang Energi dan Sumber Daya Mineral'],
            ['02.08', 'Sub Bidang Pariwisata'],
            ['02.08.01', 'Pemeliharaan Sarana dan Prasarana Pariwisata Milik Desa'],
            ['02.08.02', 'Pembangunan/Rehabilitasi/Peningkatan Sarana dan Prasarana Pariwisata Milik **)'],
            ['02.08.03', 'Pengembangan Pariwisata Tingkat Desa'],
            ['02.08.90', 'Pembangunan Tembok Laut Kawasan wisata Laut'],
            ['02.08.91', 'Rehabilitasi Pemeliharaan Jogging Path Track Wisatawan'],
            ['02.08.92', 'Pembangunan Amphitheater di Ruang Publik Pantai'],
            ['02.08.93', 'Penambahan bahan-bahan promosi dan buku edukasi tentang pantai dan laut'],
            ['02.08.94', 'Pembangunan Show Room / Wisma Pamer Produk Desa'],
            ['02.08.95', 'Festival Makanan Laut Higienis Pesisir Laut'],
            ['02.08.96', 'Fasilitasi Pelaku Periwisata di Desa, Pelatihan Pengelola wisata Desa'],
            ['02.08.97', 'Penyelanggaraan dan persiapan Desa Wisata'],
            ['02.08.99', 'Lain-Lain Legiatan Sub Bidang Pariwisata'],
            ['03', 'BIDANG PEMBINAAN KEMASYARAKATAN'],
            ['03.01', 'Sub Bidang Ketenteraman, Ketertiban Umum dan Perlindungan Masyarakat'],
            ['03.01.01', 'Pengadaan/Penyelenggaraan Pos Keamanan Desa'],
            ['03.01.02', 'Penguatan & Peningkatan Kapasitas Tenaga Keamanan/Ketertiban oleh Pemdes'],
            ['03.01.03', 'Koordinasi Pembinaan Keamanan, Ketertiban & Perlindungan Masy. Skala Lokal Desa'],
            ['03.01.04', 'Persiapan Kesiapsiagaan/Tanggap Bencana Skala Lokal Desa'],
            ['03.01.05', 'Penyediaan Pos Kesiapsiagaan Bencana Skala Lokal Desa'],
            ['03.01.06', 'Bantuan Hukum Untuk Aparatur Desa dan Masyarakat Miskin'],
            ['03.01.07', 'Pelatihan/Penyuluhan/Sosialisasi kepada Masy. di Bid. Hukum & Pelindungan Masy.'],
            ['03.01.90', 'Pembinaan Keamanan dan Ketertiban'],
            ['03.01.91', 'Pembinaan Kerukunan warga Masyarakat Desa'],
            ['03.01.92', 'Pelestarian dan Pengembangan Gotong Royong Masyarakat Desa'],
            ['03.01.93', 'Memberikan Insentif dan Fasilitasi Linmas Desa'],
            ['03.01.94', 'Memelihara Perdamaian, menangani Konflik dan melakukakn mediasi di Desa'],
            ['03.01.95', 'Pembentukan dan Fasilitasi Paralegal Desa'],
            ['03.01.96', 'Pelatihan Paralegal Desa'],
            ['03.01.97', 'Pelatihan Penyelesaian mediasi Sengketa Tanah, atau Kekerasan dalam rumah Tangga'],
            ['03.01.98', 'Fasilitasi Kelompok-Kelompok Rentan, Kelompok Masyakat Miskin, Perempuan, masyarakat Adat dan Difabel'],
            ['03.01.99', 'Lain-lain Kegiatan Sub Bidang Ketenteraman, Ketertiban Umum dan Perlindungan Masyarakat'],
            ['03.02', 'Sub Bidang Kebudayaan dan Keagamaan'],
            ['03.02.01', 'Pembinaan Group Kesenian dan Kebudayaan Tingkat Desa'],
            ['03.02.02', 'Pengiriman Kontingen Group Kesenian & Kebudayaan (Wakil Desa tkt. Kec/Kab/Kot)'],
            ['03.02.03', 'Penyelenggaraan Festival Kesenian, Adat/Kebudayaan, dan Keagamaan (HUT RI, Raya Keagamaan dll)'],
            ['03.02.04', 'Pemeliharaan Sarana Prasarana Kebudayaan, Rumah Adat dan Keagamaan Milik Desa'],
            ['03.02.05', 'Pembangunan/Rehabilitasi Sarana Prasarana Kebudayaan/Rumah Adat/Kegamaan Milik Desa **)'],
            ['03.02.90', 'Pembinaan Kerukunan Umat Beragama'],
            ['03.02.91', 'Pembentukan dan fasilitasi Lembaga Kemasyarakatan dan Lembaga Adat Desa'],
            ['03.02.92', 'Pengembangan Seni Budaya Non Tradisional'],
            ['03.02.93', 'Pelatihan Lembaga Kemasyarakatan Desa dan Lembaga Adat Desa'],
            ['03.02.99', 'Lain-lain Kegiatan Sub Bidang Kebudayaan dan Keagamaan'],
            ['03.03', 'Sub Bidang Kepemudaan dan Olahraga'],
            ['03.03.01', 'Pengiriman Kontingen Kepemudaan & Olahraga Sebagai Wakil Desa tkt Kec/Kab/Kota'],
            ['03.03.02', 'Penyelenggaraan Pelatihan Kepemudaan Tingkat Desa'],
            ['03.03.03', 'Penyelenggaraan Festival/Lomba Kepemudaan dan Olahraga Tingkat Desa'],
            ['03.03.04', 'Pemeliharaan Sarana dan Prasarana Kepemudaan dan Olahraga Milik Desa'],
            ['03.03.05', 'Pembangunan/Rehabilitasi/Peningkatan Sarana dan Prasarana Kepemudaan & Olahraga Milik Desa'],
            ['03.03.06', 'Pembinaan Karang Taruna/Klub Kepemudaan/Olahraga Tingkat Desa'],
            ['03.03.90', 'Peningkatan Kepasitas Kelompok Pemuda'],
            ['03.03.99', 'Lain-lain Kegiatan Sub Bidang Kepemudaan dan Olahraga'],
            ['03.04', 'Sub Bidang Kelembagaan Masyarakat'],
            ['03.04.01', 'Pembinaan Lembaga Adat'],
            ['03.04.02', 'Pembinaan LKMD/LPM/LPMD'],
            ['03.04.03', 'Pembinaan PKK'],
            ['03.04.04', 'Pelatihan Pembinaan Lembaga Kemasyarakatan'],
            ['03.04.90', 'Pendidikan Anak Usia Dini'],
            ['03.04.91', 'Pembinaan LPM'],
            ['03.04.92', 'Pembentukan Desa Siaga'],
            ['03.04.93', 'Pembentukan dan Fasilitasi Kader Pembangunan dan Pemberdayaan Masyarakat Desa Teknis dan Pemberdayaan Desa'],
            ['03.04.94', 'Peningkatan Peran serta Masyarakat Dalam Pembangunan Desa'],
            ['03.04.95', 'Peningkatan Kapasitas Kader Pemberdayaan Masyarakat Desa Teknis dan KPMD Pemberdayaan'],
            ['03.04.99', 'Lain-lain Sub Bidang Kelembagaan Masyarakat'],
            ['04', 'BIDANG PEMBERDAYAAN MASYARAKAT'],
            ['04.01', 'Sub Bidang Kelautan dan Perikanan'],
            ['04.01.01', 'Pemeliharaan Karamba/Kolam Perikanan Darat Milik Desa'],
            ['04.01.02', 'Pemeliharaan Pelabuhan Perikanan Sungai/Kecil Milik Desa'],
            ['04.01.03', 'Pembangunan/Rehabilitasi/Peningkatan Karamba/Kolam Perikanan Darat Milik Desa'],
            ['04.01.04', 'Pembangunan/Rehabilitasi/Peningkatan Pelabuhan Perikanan Sungai/Kecil Milik Desa'],
            ['04.01.05', 'Bantuan Perikanan (Bibit/Pakan/dll)'],
            ['04.01.06', 'Bimtek/Pelatihan/Pengenalan TTG untuk Perikanan Darat/Nelayan **)'],
            ['04.01.90', 'Pembangunan dan Pemeliharaan serta Pengelolaan Saluran Untuk Budidaya Perikanan'],
            ['04.01.91', 'Pembangunan dan Pengelolaan Tempat Pelelangan Ikan(TPI)'],
            ['04.01.92', 'Pembangunan dan Pengelolaan Lumbung Pangan dan Penetapan Cadangan Pangan Ikan'],
            ['04.01.93', 'Pengelolaan Balai Benih Ikan'],
            ['04.01.94', 'Pengembangan TTG Penelolaan Hasil Perikanan'],
            ['04.01.95', 'Penetapan Komoditas Unggulan Perikan'],
            ['04.01.96', 'Peningkatan Kapasilitas Kelompok Nelayan'],
            ['04.01.97', 'Pelatihan Pengelolaan Hasil Laut dan Pantai Untuk Petani Budidaya dan Nelayan Tangkap'],
            ['04.01.99', 'Lain-lain Kegiatan Sub Bidang Kelautan dan Perikanan'],
            ['04.02', 'Sub Bidang Pertanian dan Peternakan'],
            ['04.02.01', 'Peningkatan Produksi Tanaman Pangan (alat produksi/pengelolaan/penggilingan)'],
            ['04.02.02', 'Peningkatan Produksi Peternakan (alat produksi/pengelolaan/kandang)'],
            ['04.02.03', 'Penguatan Ketahanan Pangan Tingkat Desa (Lumbung Desa dll)'],
            ['04.02.04', 'Pemeliharaan Saluran Irigasi Tersier/Sederhana'],
            ['04.02.05', 'Pelatihan/Bimtek/Pengenalan Teknologi Tepat Guna untuk Pertanian/Peternakan'],
            ['04.02.06', 'Pembangunan/Rehabilitasi/Peningkatan Saluran Irigasi Tersier/Sederhana'],
            ['04.02.99', 'Lain-lain Kegiatan Sub Bidang Pertanian dan Peternakan'],
            ['04.03', 'Sub Bidang Peningkatan Kapasitas Aparatur Desa'],
            ['04.03.01', 'Peningkatan Kapasitas Kepala Desa'],
            ['04.03.02', 'Peningkatan Kapasitas Perangkat Desa'],
            ['04.03.03', 'Peningkatan Kapasitas BPD'],
            ['04.03.90', 'Peningkatan Kapasitas Staf Perangkat dan Staf BPD'],
            ['04.03.99', 'Lain-lain Kegiatan Sub Bidang Peningkatan Kapasitas Aparatur Desa'],
            ['04.04', 'Sub Bidang Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga'],
            ['04.04.01', 'Pelatihan dan Penyuluhan Pemberdayaan Perempuan'],
            ['04.04.02', 'Pelatihan dan Penyuluhan Perlindungan Anak'],
            ['04.04.03', 'Pelatihan dan Penguatan Penyandang Difabel (Penyandang Disabilitas)'],
            ['04.04.90', 'Peningkatan Kapasitas Kelompok Perempuan'],
            ['04.04.91', 'Peningkatan Kapasitas Kelompok Masyarakat Miskin'],
            ['04.04.92', 'Peningkatan Kapasitas Kelompok Pemerhati dan Perlindungan Anak'],
            ['04.04.93', 'Pemberdayaan Posyandu UP2K dan BKB'],
            ['04.04.94', 'Peningkatan Kapasitas Masyarakat / Kelompok Masyarakat'],
            ['04.04.95', 'Pencegahan dan Penanganan Stunting'],
            ['04.04.99', 'Lain-lain Kegiatan Sub Bidang Pemberdayaan Perempuan, Perlindungan Anak dan Keluarga'],
            ['04.05', 'Sub Bidang Koperasi, Usaha Micro Kecil dan Menengah (UMKM)'],
            ['04.05.01', 'Pelatihan Manajemen Koperasi/KUD/UMKM'],
            ['04.05.02', 'Pengembangan Sarana Prasarana Usaha Mikro, Kecil, Menengah dan Koperasi'],
            ['04.05.03', 'Pengadaan Teknologi Tepat Guna Untuk Pengembangan Ekonomi Pedesaan Non Pertanian'],
            ['04.05.99', 'Lain-lain Sub Bidang Koperasi, Usaha Micro Kecil dan Menengah (UMKM)'],
            ['04.06', 'Sub Bidang Dukungan Penanaman Modal'],
            ['04.06.01', 'Pembentukan BUM Desa (Persiapan dan Pembentukan Awal BUMDesa)'],
            ['04.06.02', 'Pelatihan Pengelolaan BUM Desa (Pelatihan yg dilaksanakan oleh Pemdes)'],
            ['04.06.90', 'Pendirian dan Pengelolaan BUMDesa'],
            ['04.06.91', 'Pengembangan Bisnis dan Pemetaan Kelayakan BUMDesa dan BUM Antar Desa'],
            ['04.06.92', 'Investasi Uasaha Ekonomi Melalui kerjasaam BUMDesa'],
            ['04.06.93', 'Analisa Kelayakan Usaha'],
            ['04.06.94', 'Pengembangan Bisnis dan Pemataan kelayakan usaha BUMDESMA'],
            ['04.06.99', 'Lain-lain Kegiatan Sub Bidang Dukungan Penanaman Modal'],
            ['04.07', 'Sub Bidang Perdagangan dan Perindustrian'],
            ['04.07.01', 'Pemeliharaan Pasar Desa/Kios Milik Desa'],
            ['04.07.02', 'Pembangunan/Rehab Pasar Desa/Kios Milik Desa'],
            ['04.07.03', 'Pengembangan Industri Kecil Tingkat Desa'],
            ['04.07.04', 'Pembentukan/Fasilitasi/Pelatihan/Pendampingan kelompok usaha ekonomi produktif'],
            ['04.07.90', 'Pengelolaan Pasar Desa dan Kios Desa'],
            ['04.07.91', 'Pelatihan Hak-Hak Perburuhan Kerja Sama Desa dengan Perusahaan'],
            ['04.07.92', 'Workshop Business Plan'],
            ['04.07.99', 'Lain-lain Sub Bidang Perdagangan dan Perindustrian'],
            ['05', 'BIDANG PENANGGULANGAN BENCANA, DARURAT DAN MENDESAK DESA'],
            ['05.01', 'Sub Bidang Penanggulangan Bencana'],
            ['05.01.00', 'Kegiatan Penanggulangan Bencana'],
            ['05.02', 'Sub Bidang Keadaan Darurat'],
            ['05.02.00', 'Penanganan Keadaan Darurat'],
            ['05.03', 'Sub Bidang Keadaan Mendesak'],
            ['05.03.00', 'Penanganan Keadaan Mendesak'],
        ];

        DB::transaction(function () use ($master, $tahunId) {
            $bidangIds = [];
            $subBidangIds = [];

            // 1. Bidang
            foreach ($master as [$kode, $nama]) {
                if (substr_count($kode, '.') !== 0) {
                    continue;
                }

                DB::table('bidang')->updateOrInsert(
                    [
                        'tahun_anggaran_id' => $tahunId,
                        'kode' => $kode,
                    ],
                    [
                        'nama' => $nama,
                        'urutan' => (int) $kode,
                        'status_publikasi' => 'dipublikasikan',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $row = DB::table('bidang')
                    ->where('tahun_anggaran_id', $tahunId)
                    ->where('kode', $kode)
                    ->first();

                $bidangIds[$kode] = $row->id;
            }

            // 2. Sub Bidang
            foreach ($master as [$kode, $nama]) {
                if (substr_count($kode, '.') !== 1) {
                    continue;
                }

                $bidangKode = substr($kode, 0, 2);
                $bidangId = $bidangIds[$bidangKode] ?? null;

                if (!$bidangId) {
                    throw new RuntimeException("Bidang induk tidak ditemukan untuk {$kode}.");
                }

                DB::table('sub_bidang')->updateOrInsert(
                    [
                        'tahun_anggaran_id' => $tahunId,
                        'kode' => $kode,
                    ],
                    [
                        'bidang_id' => $bidangId,
                        'nama' => $nama,
                        'urutan' => (int) str_replace('.', '', $kode),
                        'status_publikasi' => 'dipublikasikan',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );

                $row = DB::table('sub_bidang')
                    ->where('tahun_anggaran_id', $tahunId)
                    ->where('kode', $kode)
                    ->first();

                $subBidangIds[$kode] = $row->id;
            }

            // 3. Kegiatan
            foreach ($master as [$kode, $nama]) {
                if (substr_count($kode, '.') !== 2) {
                    continue;
                }

                $subKode = substr($kode, 0, 5);
                $subBidangId = $subBidangIds[$subKode] ?? null;

                if (!$subBidangId) {
                    throw new RuntimeException("Sub Bidang induk tidak ditemukan untuk {$kode}.");
                }

                $bidangKode = substr($kode, 0, 2);
                $bidangId = $bidangIds[$bidangKode] ?? null;

                DB::table('kegiatan')->updateOrInsert(
                    [
                        'tahun_anggaran_id' => $tahunId,
                        'kode' => $kode,
                    ],
                    [
                        'bidang_id' => $bidangId,
                        'sub_bidang_id' => $subBidangId,
                        'nama' => $nama,
                        'urutan' => (int) str_replace('.', '', $kode),
                        'status_publikasi' => 'dipublikasikan',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }

            // Hapus Kegiatan lama yang tidak ada di Excel hanya jika belum dipakai Belanja.
            $sourceKegiatan = collect($master)
                ->filter(fn ($r) => substr_count($r[0], '.') === 2)
                ->pluck(0)
                ->all();

            $oldKegiatan = DB::table('kegiatan')
                ->where('tahun_anggaran_id', $tahunId)
                ->whereNotIn('kode', $sourceKegiatan)
                ->get(['id', 'kode']);

            foreach ($oldKegiatan as $old) {
                $used = DB::table('belanja')
                    ->where('kegiatan_id', $old->id)
                    ->exists();

                if ($used) {
                    throw new RuntimeException(
                        "Kegiatan lama {$old->kode} masih dipakai pada data Belanja. Tidak ada data yang dihapus."
                    );
                }

                DB::table('kegiatan')->where('id', $old->id)->delete();
            }

            // Hapus Sub Bidang lama yang tidak ada di Excel jika belum memiliki Kegiatan.
            $sourceSub = collect($master)
                ->filter(fn ($r) => substr_count($r[0], '.') === 1)
                ->pluck(0)
                ->all();

            $oldSub = DB::table('sub_bidang')
                ->where('tahun_anggaran_id', $tahunId)
                ->whereNotIn('kode', $sourceSub)
                ->get(['id', 'kode']);

            foreach ($oldSub as $old) {
                $hasKegiatan = DB::table('kegiatan')
                    ->where('sub_bidang_id', $old->id)
                    ->exists();

                if ($hasKegiatan) {
                    throw new RuntimeException(
                        "Sub Bidang lama {$old->kode} masih memiliki Kegiatan. Tidak ada data yang dihapus."
                    );
                }

                DB::table('sub_bidang')->where('id', $old->id)->delete();
            }

            $this->command->info(
                'Master berhasil disinkronkan dari Excel: 5 Bidang, 27 Sub Bidang, 301 Kegiatan.'
            );
        });
    }
}
