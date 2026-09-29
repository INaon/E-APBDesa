<?php
namespace Database\Seeders;
use App\Models\Desa; use App\Models\TahunAnggaran; use App\Models\User; use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder { public function run():void { Desa::create(['nama'=>'Desa Sumber Jaya','kecamatan'=>null,'kabupaten'=>'Tanah Laut','provinsi'=>'Kalimantan Selatan','alamat'=>'Kantor Pemerintah Desa Sumber Jaya']); TahunAnggaran::create(['tahun'=>2026,'status'=>'aktif']); User::create(['name'=>'Administrator Desa','email'=>'admin@eapbdesa.test','password'=>Hash::make('password')]); } }
