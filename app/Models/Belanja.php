<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Belanja extends Model
{
    protected $table = 'belanja';

    protected $fillable = [
        'tahun_anggaran_id',
        'bidang_id',
        'kegiatan_id',
        'sub_kegiatan_id',
        'belanja_rekening_id',
        'kode',
        'uraian',
        'anggaran',
        'urutan',
        'status_publikasi',
    ];

    protected $casts = [
        'anggaran' => 'decimal:2',
    ];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class);
    }

    public function belanjaRekening()
    {
        return $this->belongsTo(BelanjaRekening::class);
    }

    public function realisasi()
    {
        return $this->hasMany(RealisasiBelanja::class);
    }

    public function scopePublik($query)
    {
        return $query->where('status_publikasi', 'dipublikasikan');
    }
}
