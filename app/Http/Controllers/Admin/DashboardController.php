<?php
namespace App\Http\Controllers\Admin; use App\Http\Controllers\Controller; use App\Models\TahunAnggaran;
class DashboardController extends Controller { public function __invoke(){return view('admin.dashboard',['tahun'=>TahunAnggaran::aktif()->first()]);} }
