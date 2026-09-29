<?php

namespace Database\Seeders;

use App\Models\{User, Desa, TahunAnggaran, Bidang, Pendapatan, Belanja, Pembiayaan, RealisasiPendapatan, RealisasiBelanja};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(PendapatanRekeningSeeder::class);
        User::create(['name' => 'Administrator Desa', 'email' => 'admin@eapbdesa.test', 'password' => 'password']);
        Desa::create(['nama' => 'Desa Sumber Jaya', 'kecamatan' => null, 'kabupaten' => 'Tanah Laut', 'provinsi' => 'Kalimantan Selatan', 'alamat' => 'Desa Sumber Jaya, Tanah Laut']);
        $year = TahunAnggaran::create(['tahun' => 2026, 'status' => 'aktif']);
        $bidang = Bidang::create(['tahun_anggaran_id' => $year->id, 'kode' => '2.1', 'nama' => 'Penyelenggaraan Pemerintahan Desa', 'urutan' => 1, 'status_publikasi' => 'dipublikasikan']);
        foreach ([['1.1', 'Pendapatan Asli Desa', 'Pendapatan Asli Desa', 200000000], ['1.2', 'Dana Desa', 'Transfer', 900000000], ['1.3', 'Alokasi Dana Desa', 'Transfer', 300000000]] as [$code, $name, $group, $amount]) {
            $p = Pendapatan::create(['tahun_anggaran_id' => $year->id, 'kode' => $code, 'kelompok' => $group, 'uraian' => $name, 'anggaran' => $amount, 'status_publikasi' => 'dipublikasikan']);
            RealisasiPendapatan::create(['tahun_anggaran_id' => $year->id, 'pendapatan_id' => $p->id, 'bulan' => 6, 'tanggal' => '2026-06-30', 'nilai' => $amount * .8071, 'status_publikasi' => 'dipublikasikan']);
        }
        $b = Belanja::create(['tahun_anggaran_id' => $year->id, 'bidang_id' => $bidang->id, 'kode' => '2.1.01', 'uraian' => 'Operasional Pemerintahan Desa (Data Demo)', 'anggaran' => 1350000000, 'status_publikasi' => 'dipublikasikan']);
        RealisasiBelanja::create(['tahun_anggaran_id' => $year->id, 'belanja_id' => $b->id, 'bulan' => 6, 'tanggal' => '2026-06-30', 'nilai' => 950000000, 'status_publikasi' => 'dipublikasikan']);
        Pembiayaan::create(['tahun_anggaran_id' => $year->id, 'jenis' => 'penerimaan', 'kode' => '3.1', 'uraian' => 'SILPA Tahun Sebelumnya (Data Demo)', 'anggaran' => 50000000, 'status_publikasi' => 'dipublikasikan']);
    }
}
