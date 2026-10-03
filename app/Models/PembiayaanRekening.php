<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PembiayaanRekening extends Model
{
    protected $table = 'pembiayaan_rekenings';

    protected $fillable = [
        'kode',
        'uraian',
        'parent_id',
        'level',
        'jenis',
        'is_active',
    ];

    protected $casts = [
        'level' => 'integer',
        'is_active' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(
            self::class,
            'parent_id'
        );
    }

    public function children(): HasMany
    {
        return $this->hasMany(
            self::class,
            'parent_id'
        )->orderBy('kode');
    }

    public function pembiayaan(): HasMany
    {
        return $this->hasMany(
            Pembiayaan::class,
            'pembiayaan_rekening_id'
        );
    }
}