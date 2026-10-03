<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubBidang extends Model
{
    protected $table = 'sub_bidang';

    protected $guarded = [];

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function kegiatan()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function belanja()
    {
        return $this->hasMany(Belanja::class);
    }
}
