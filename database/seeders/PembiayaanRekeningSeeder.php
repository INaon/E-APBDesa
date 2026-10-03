<?php

namespace Database\Seeders;

use App\Models\PembiayaanRekening;
use Illuminate\Database\Seeder;

class PembiayaanRekeningSeeder extends Seeder
{
    public function run(): void
    {
        $items = [

            // =========================================================
            // LEVEL 1
            // =========================================================

            [
                'kode' => '6.',
                'uraian' => 'PEMBIAYAAN',
                'level' => 1,
                'jenis' => 'penerimaan',
                'parent_kode' => null,
            ],


            // =========================================================
            // LEVEL 2
            // =========================================================

            [
                'kode' => '6.1.',
                'uraian' => 'Penerimaan Pembiayaan',
                'level' => 2,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.',
            ],

            [
                'kode' => '6.2.',
                'uraian' => 'Pengeluaran Pembiayaan',
                'level' => 2,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.',
            ],


            // =========================================================
            // LEVEL 3 - PENERIMAAN
            // =========================================================

            [
                'kode' => '6.1.1.',
                'uraian' => 'SILPA Tahun Sebelumnya',
                'level' => 3,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.',
            ],

            [
                'kode' => '6.1.2.',
                'uraian' => 'Pencairan Dana Cadangan',
                'level' => 3,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.',
            ],

            [
                'kode' => '6.1.3.',
                'uraian' => 'Hasil Penjualan Kekayaan Desa Yang Dipisahkan',
                'level' => 3,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.',
            ],

            [
                'kode' => '6.1.4.',
                'uraian' => 'Penerimaan Kembali Penyertaan Modal',
                'level' => 3,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.',
            ],

            [
                'kode' => '6.1.9.',
                'uraian' => 'Penerimaan Pembiayaan Lainnya',
                'level' => 3,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.',
            ],


            // =========================================================
            // LEVEL 3 - PENGELUARAN
            // =========================================================

            [
                'kode' => '6.2.1.',
                'uraian' => 'Pembentukan Dana Cadangan',
                'level' => 3,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.',
            ],

            [
                'kode' => '6.2.2.',
                'uraian' => 'Penyertaan Modal Desa',
                'level' => 3,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.',
            ],

            [
                'kode' => '6.2.3.',
                'uraian' => 'Setor Kembali Pendapatan Transfer',
                'level' => 3,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.',
            ],

            [
                'kode' => '6.2.9.',
                'uraian' => 'Pengeluaran Pembiayaan Lainnya',
                'level' => 3,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.',
            ],


            // =========================================================
            // LEVEL 4 - PENERIMAAN
            // =========================================================

            [
                'kode' => '6.1.1.01.',
                'uraian' => 'SILPA Tahun Sebelumnya',
                'level' => 4,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.1.',
            ],

            [
                'kode' => '6.1.2.01.',
                'uraian' => 'Pencairan Dana Cadangan',
                'level' => 4,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.2.',
            ],

            [
                'kode' => '6.1.3.01.',
                'uraian' => 'Hasil Penjualan Kekayaan Desa Yang Dipisahkan',
                'level' => 4,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.3.',
            ],

            [
                'kode' => '6.1.4.01.',
                'uraian' => 'Penerimaan Kembali Penyertaan Modal',
                'level' => 4,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.4.',
            ],

            [
                'kode' => '6.1.9.99.',
                'uraian' => 'Penerimaan Pembiayaan Lainnya',
                'level' => 4,
                'jenis' => 'penerimaan',
                'parent_kode' => '6.1.9.',
            ],


            // =========================================================
            // LEVEL 4 - PENGELUARAN
            // =========================================================

            [
                'kode' => '6.2.1.01.',
                'uraian' => 'Pembentukan Dana Cadangan',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.1.',
            ],

            [
                'kode' => '6.2.2.01.',
                'uraian' => 'Penyertaan Modal Desa',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.2.',
            ],

            [
                'kode' => '6.2.3.01.',
                'uraian' => 'Dana Desa',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.3.',
            ],

            [
                'kode' => '6.2.3.02.',
                'uraian' => 'Bagian dari Hasil Pajak dan Retribusi Daerah Kabupaten/Kota',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.3.',
            ],

            [
                'kode' => '6.2.3.03.',
                'uraian' => 'Alokasi Dana Desa',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.3.',
            ],

            [
                'kode' => '6.2.3.04.',
                'uraian' => 'Bantuan Keuangan APBD Provinsi',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.3.',
            ],

            [
                'kode' => '6.2.3.05.',
                'uraian' => 'Bantuan Keuangan APBD Kabupaten/Kota',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.3.',
            ],

            [
                'kode' => '6.2.9.99.',
                'uraian' => 'Pengeluaran Pembiayaan Lainnya',
                'level' => 4,
                'jenis' => 'pengeluaran',
                'parent_kode' => '6.2.9.',
            ],
        ];


        /*
        |--------------------------------------------------------------------------
        | 1. Masukkan semua rekening terlebih dahulu
        |--------------------------------------------------------------------------
        */

        foreach ($items as $item) {
            PembiayaanRekening::updateOrCreate(
                [
                    'kode' => $item['kode'],
                ],
                [
                    'uraian' => $item['uraian'],
                    'level' => $item['level'],
                    'jenis' => $item['jenis'],
                    'is_active' => true,
                ]
            );
        }


        /*
        |--------------------------------------------------------------------------
        | 2. Isi parent_id setelah semua rekening tersedia
        |--------------------------------------------------------------------------
        */

        foreach ($items as $item) {

            $parentId = null;

            if ($item['parent_kode']) {
                $parentId = PembiayaanRekening::query()
                    ->where(
                        'kode',
                        $item['parent_kode']
                    )
                    ->value('id');
            }

            PembiayaanRekening::query()
                ->where(
                    'kode',
                    $item['kode']
                )
                ->update([
                    'parent_id' => $parentId,
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 3. Tampilkan hasil
        |--------------------------------------------------------------------------
        */

        $total = PembiayaanRekening::count();

        $detail = PembiayaanRekening::query()
            ->where('level', 4)
            ->count();

        $this->command?->info(
            "Master rekening pembiayaan berhasil diisi."
        );

        $this->command?->info(
            "Total master: {$total} rekening."
        );

        $this->command?->info(
            "Rekening detail: {$detail} rekening."
        );
    }
}