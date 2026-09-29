<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TahunAnggaran extends Model { protected $table='tahun_anggaran'; protected $fillable=['tahun','status']; protected $casts=['tahun'=>'integer']; public function scopeAktif($query){return $query->where('status','aktif');} }
