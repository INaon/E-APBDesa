<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $table = 'bidang';
    protected $guarded = [];

    public function tahunAnggaran() { return $this->belongsTo(TahunAnggaran::class); }
    public function subBidang() { return $this->hasMany(SubBidang::class); }
    public function kegiatan() { return $this->hasMany(Kegiatan::class); }
    public function belanja() { return $this->hasMany(Belanja::class); }
}
