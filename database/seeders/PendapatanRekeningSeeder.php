<?php

namespace Database\Seeders;

use App\Models\PendapatanRekening;
use Illuminate\Database\Seeder;

class PendapatanRekeningSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            '4' => 'Pendapatan', '4.1' => 'Pendapatan Asli Desa', '4.1.1' => 'Hasil Usaha Desa',
            '4.1.1.01' => 'Bagi Hasil BUMDes', '4.1.1.99' => 'Lain-lain Hasil Usaha Desa',
            '4.1.2' => 'Hasil Aset Desa', '4.1.2.01' => 'Pengelolaan Tanah Kas Desa', '4.1.2.02' => 'Tambatan Perahu', '4.1.2.03' => 'Pasar Desa', '4.1.2.04' => 'Tempat Pemandian Umum', '4.1.2.05' => 'Jaringan Irigasi Desa', '4.1.2.06' => 'Pelelangan Ikan Milik Desa', '4.1.2.07' => 'Hasil Kios Milik Desa', '4.1.2.08' => 'Pemanfaatan Sarana/Prasarana Olahraga', '4.1.2.99' => 'Lain-lain Hasil Aset Desa',
            '4.1.3' => 'Swadaya, Partisipasi dan Gotong Royong', '4.1.3.01' => 'Hasil Swadaya, Partisipasi dan Gotong Royong', '4.1.3.99' => 'Lain-lain Swadaya, Partisipasi dan Gotong Royong',
            '4.1.4' => 'Lain-Lain Pendapatan Asli Desa', '4.1.4.01' => 'Hasil Pungutan Desa', '4.1.4.90' => 'Hibah Lomba / Fastival/Kegiatan Lainnya', '4.1.4.91' => 'Bagi Hasil Usaha BUMDesa dan BUMDesa Bersama', '4.1.4.92' => 'Hibah dari Bantuan Pusat untuk Modal BUMDesa', '4.1.4.93' => 'Hibah dari Bantuan Propinsi untuk Modal BUMDesa', '4.1.4.94' => 'Hadiah dari Lomba Desa dan Lomba-Lomba Lainnya', '4.1.4.99' => 'Lain-Lain Pendapatan Asli Desa',
            '4.2' => 'Pendapatan Transfer', '4.2.1' => 'Dana Desa', '4.2.1.01' => 'Dana Desa', '4.2.2' => 'Bagi Hasil Pajak dan Retribusi', '4.2.2.01' => 'Bagi Hasil Pajak dan Retribusi Daerah Kabupaten/Kota', '4.2.3' => 'Alokasi Dana Desa', '4.2.3.01' => 'Alokasi Dana Desa', '4.2.4' => 'Bantuan Keuangan Provinsi', '4.2.4.01' => 'Bantuan Keuangan dari APBD Provinsi', '4.2.4.99' => 'Lain-lain Bantuan Keuangan APBD Provinsi', '4.2.5' => 'Bantuan Keuangan Kabupaten/Kota', '4.2.5.01' => 'Bantuan Keuangan dari APBD Kabupaten/Kota', '4.2.5.99' => 'Lain-lain Bantuan Keuangan dari APBD Kabupaten/Kota',
            '4.3' => 'Pendapatan Lain-lain', '4.3.1' => 'Penerimaan dari Hasil Kerjasama Antar Desa', '4.3.1.01' => 'Penerimaan dari Hasil Kerjasama Antar Desa', '4.3.2' => 'Penerimaan dari Hasil Kerjasama dengan Pihak Ketiga', '4.3.2.01' => 'Penerimaan dari Hasil Kerjasama dengan Pihak Ketiga', '4.3.3' => 'Penerimaan Bantuan dari Perusahaan yang Berlokasi di Desa', '4.3.3.01' => 'Penerimaan Bantuan dari Perusahaan yang Berlokasi di Desa', '4.3.4' => 'Hibah dan Sumbangan dari Pihak Ketiga', '4.3.4.01' => 'Hibah dan sumbangan dari Pihak Ketiga', '4.3.5' => 'Koreksi Kesalahan Belanja Tahun-tahun Sebelumnya', '4.3.5.01' => 'Pengembalian Belanja Tahun-tahun Sebelumnya', '4.3.6' => 'Bunga Bank', '4.3.6.01' => 'Bunga Bank', '4.3.9' => 'Lain-lain pendapatan Desa yang sah', '4.3.9.99' => 'Lain-lain pendapatan Desa yang sah',
        ];
        $ids = [];
        foreach ($accounts as $kode => $uraian) {
            $parentCode = str_contains($kode, '.') ? substr($kode, 0, strrpos($kode, '.')) : null;
            $record = PendapatanRekening::updateOrCreate(['kode' => $kode], ['uraian' => $uraian, 'parent_id' => $parentCode ? $ids[$parentCode] : null, 'level' => substr_count($kode, '.') + 1, 'is_active' => true]);
            $ids[$kode] = $record->id;
        }
    }
}
