<?php
namespace App\Http\Controllers;
use App\Models\{Desa,TahunAnggaran,Pendapatan,Belanja,Pembiayaan,DokumenPublikasi}; use App\Services\ApbdesaSummary;
class PublicController extends Controller {
 private function ctx(?int $tahun=null):array{$years=TahunAnggaran::orderBy('tahun')->get();$year=$tahun?$years->firstWhere('tahun',$tahun):$years->firstWhere('status','aktif');abort_unless($year,404);return compact('years','year')+['desa'=>Desa::firstOrFail()];}
 public function home(ApbdesaSummary $s){$c=$this->ctx();return view('public.home',$c+['summary'=>$s->for($c['year'])]);}
 public function apbdesa(int $tahun,ApbdesaSummary $s){$c=$this->ctx($tahun);return view('public.apbdesa',$c+['summary'=>$s->for($c['year']),'pendapatan'=>$this->income($c['year']),'belanja'=>$this->expense($c['year']),'pembiayaan'=>$this->financing($c['year'])]);}
 public function pendapatan(int $tahun,ApbdesaSummary $s){$c=$this->ctx($tahun);return view('public.pendapatan',$c+['summary'=>$s->for($c['year']),'pendapatan'=>$this->income($c['year'])]);}
 public function belanja(int $tahun,ApbdesaSummary $s){$c=$this->ctx($tahun);$items=$this->expense($c['year']);return view('public.belanja',$c+['summary'=>$s->for($c['year']),'groups'=>$items->groupBy(fn($item)=>$item->bidang?->nama ?? 'Belanja Lainnya')]);}
 public function pembiayaan(int $tahun,ApbdesaSummary $s){$c=$this->ctx($tahun);return view('public.pembiayaan',$c+['summary'=>$s->for($c['year']),'items'=>$this->financing($c['year'])]);}
 public function realisasi(int $tahun,ApbdesaSummary $s){$c=$this->ctx($tahun);$income=Pendapatan::publik()->withSum(['realisasi'=>fn($q)=>$q->where('status_publikasi','dipublikasikan')],'nilai')->where('tahun_anggaran_id',$c['year']->id)->orderBy('urutan')->get();$expense=Belanja::publik()->with('bidang')->withSum(['realisasi'=>fn($q)=>$q->where('status_publikasi','dipublikasikan')],'nilai')->where('tahun_anggaran_id',$c['year']->id)->orderBy('urutan')->get();return view('public.realisasi',$c+['summary'=>$s->for($c['year']),'pendapatan'=>$income,'belanja'=>$expense]);}
 public function documents(int $tahun){$c=$this->ctx($tahun);return view('public.documents',$c+['documents'=>DokumenPublikasi::publik()->where('tahun_anggaran_id',$c['year']->id)->latest('tanggal_publikasi')->get()]);}
 public function profile(){return view('public.profile',$this->ctx());}
 private function income(TahunAnggaran $year){return Pendapatan::publik()->where('tahun_anggaran_id',$year->id)->orderBy('urutan')->orderBy('kode')->get();} private function expense(TahunAnggaran $year){return Belanja::publik()->with(['bidang','kegiatan'])->where('tahun_anggaran_id',$year->id)->orderBy('urutan')->orderBy('kode')->get();} private function financing(TahunAnggaran $year){return Pembiayaan::publik()->where('tahun_anggaran_id',$year->id)->orderBy('urutan')->orderBy('kode')->get();}
}
