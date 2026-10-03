<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembiayaan extends Model
{
    protected $table = 'pembiayaan';

    protected $fillable = [
        'tahun_anggaran_id',
        'pembiayaan_rekening_id',
        'jenis',
        'kode',
        'uraian',
        'anggaran',
        'urutan',
        'status_publikasi',
    ];

    protected $casts = [
        'anggaran' => 'decimal:2',
    ];

    public function tahunAnggaran(): BelongsTo
    {
        return $this->belongsTo(
            TahunAnggaran::class,
            'tahun_anggaran_id'
        );
    }

    public function pembiayaanRekening(): BelongsTo
    {
        return $this->belongsTo(
            PembiayaanRekening::class,
            'pembiayaan_rekening_id'
        );
    }

    public function scopePublik($query)
    {
        return $query->where(
            'status_publikasi',
            'dipublikasikan'
        );
    }
}