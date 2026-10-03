<?php

namespace App\Console\Commands;

use App\Models\DokumenPublikasi;
use Illuminate\Console\Command;

class CekDokumen extends Command
{
    protected $signature = 'cek:dokumen';

    protected $description = 'Cek data dokumen publikasi';

    public function handle(): int
    {
        $dokumen = DokumenPublikasi::query()
            ->select(
                'id',
                'judul',
                'file_path',
                'status_publikasi'
            )
            ->orderBy('id')
            ->get();

        if ($dokumen->isEmpty()) {
            $this->info('Tidak ada dokumen di database.');

            return self::SUCCESS;
        }

        $this->table(
            [
                'ID',
                'Judul',
                'File Path',
                'Status',
            ],
            $dokumen->map(function ($item) {
                return [
                    $item->id,
                    $item->judul,
                    $item->file_path ?? 'NULL',
                    $item->status_publikasi,
                ];
            })->toArray()
        );

        return self::SUCCESS;
    }
}