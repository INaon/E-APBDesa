<?php
namespace App\Http\Controllers;
use App\Models\Desa; use App\Models\TahunAnggaran;
class PublicDashboardController extends Controller { public function __invoke(){ $desa=Desa::first(); $tahun=TahunAnggaran::aktif()->first() ?? TahunAnggaran::orderByDesc('tahun')->first(); return view('public.dashboard',compact('desa','tahun')); } public function profile(){return view('public.profile',['desa'=>Desa::first()]);} }
