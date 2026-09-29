<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PendapatanRekening extends Model
{
    protected $table = 'pendapatan_rekenings';
    protected $fillable = ['kode', 'uraian', 'parent_id', 'level', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];

    public function parent(): BelongsTo { return $this->belongsTo(self::class, 'parent_id'); }
    public function children(): HasMany { return $this->hasMany(self::class, 'parent_id'); }
    public function pendapatan(): HasMany { return $this->hasMany(Pendapatan::class); }
    public function scopeDetail($query) { return $query->whereDoesntHave('children')->where('is_active', true); }
}
