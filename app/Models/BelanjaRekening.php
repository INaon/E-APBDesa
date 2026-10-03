<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelanjaRekening extends Model
{
    protected $table = 'belanja_rekenings';

    protected $fillable = ['kode', 'uraian', 'parent_id', 'level', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function parent() { return $this->belongsTo(self::class, 'parent_id'); }
    public function children() { return $this->hasMany(self::class, 'parent_id'); }
    public function belanja() { return $this->hasMany(Belanja::class, 'belanja_rekening_id'); }

    public function scopeDetail($query)
    {
        return $query->where('is_active', true)
            ->whereRaw("kode REGEXP '^[0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+$'");
    }
}
