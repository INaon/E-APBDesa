<?php

namespace App\Http\Controllers;

use App\Models\Belanja;
use App\Models\Desa;
use App\Models\DokumenPublikasi;
use App\Models\Pembiayaan;
use App\Models\Pendapatan;
use App\Models\TahunAnggaran;
use App\Models\VisitorLog;
use App\Services\ApbdesaSummary;

class PublicController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONTEXT
    |--------------------------------------------------------------------------
    */

    private function ctx(?int $tahun = null): array
    {
        $years = TahunAnggaran::orderBy('tahun')->get();

        $year = $tahun
            ? $years->firstWhere('tahun', $tahun)
            : $years->firstWhere('status', 'aktif');

        abort_unless($year, 404);

        return compact('years', 'year') + [
            'desa' => Desa::firstOrFail(),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | BERANDA
    |--------------------------------------------------------------------------
    */

    public function home(ApbdesaSummary $s)
    {
        $c = $this->ctx();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK PENGUNJUNG
        |--------------------------------------------------------------------------
        */

        $visitorStats = [
            'total' => VisitorLog::count(),

            'today' => VisitorLog::whereDate(
                'visited_date',
                today()
            )->count(),

            'month' => VisitorLog::whereYear(
                'visited_date',
                now()->year
            )
                ->whereMonth(
                    'visited_date',
                    now()->month
                )
                ->count(),
        ];

        return view(
            'public.home',
            $c + [
                'summary' => $s->for($c['year']),

                'visitorStats' => $visitorStats,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | APBDESA
    |--------------------------------------------------------------------------
    |
    | Halaman ini merupakan ringkasan APBDesa.
    |
    | Hanya data yang memiliki nilai anggaran > 0
    | yang ditampilkan.
    |
    */

    public function apbdesa(
        int $tahun,
        ApbdesaSummary $s
    ) {
        $c = $this->ctx($tahun);

        /*
        |--------------------------------------------------------------------------
        | PENDAPATAN
        |--------------------------------------------------------------------------
        */

        $pendapatan = $this->income($c['year'])
            ->filter(function ($item) {
                return (float) $item->anggaran > 0;
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | BELANJA
        |--------------------------------------------------------------------------
        */

        $belanja = $this->expense($c['year'])
            ->filter(function ($item) {
                return (float) $item->anggaran > 0;
            })
            ->values();


        /*
        |--------------------------------------------------------------------------
        | PEMBIAYAAN
        |--------------------------------------------------------------------------
        */

        $pembiayaan = $this->financing($c['year'])
            ->filter(function ($item) {
                return (float) $item->anggaran > 0;
            })
            ->values();


        return view(
            'public.apbdesa',
            $c + [
                'summary' => $s->for($c['year']),

                'pendapatan' => $pendapatan,

                'belanja' => $belanja,

                'pembiayaan' => $pembiayaan,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PENDAPATAN
    |--------------------------------------------------------------------------
    */

    public function pendapatan(
        int $tahun,
        ApbdesaSummary $s
    ) {
        $c = $this->ctx($tahun);

        return view(
            'public.pendapatan',
            $c + [
                'summary' => $s->for($c['year']),

                'pendapatan' => $this->income($c['year']),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | BELANJA
    |--------------------------------------------------------------------------
    */

    public function belanja(
        int $tahun,
        ApbdesaSummary $s
    ) {
        $c = $this->ctx($tahun);

        $items = $this->expense($c['year']);

        return view(
            'public.belanja',
            $c + [
                'summary' => $s->for($c['year']),

                'groups' => $items->groupBy(
                    fn ($item) =>
                        $item->bidang?->nama
                        ?? 'Belanja Lainnya'
                ),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PEMBIAYAAN
    |--------------------------------------------------------------------------
    */

    public function pembiayaan(
        int $tahun,
        ApbdesaSummary $s
    ) {
        $c = $this->ctx($tahun);

        return view(
            'public.pembiayaan',
            $c + [
                'summary' => $s->for($c['year']),

                'items' => $this->financing($c['year']),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REALISASI
    |--------------------------------------------------------------------------
    */

    public function realisasi(
        int $tahun,
        ApbdesaSummary $s
    ) {
        $c = $this->ctx($tahun);


        $income = Pendapatan::publik()
            ->withSum(
                [
                    'realisasi' => function ($q) {
                        $q->where(
                            'status_publikasi',
                            'dipublikasikan'
                        );
                    },
                ],
                'nilai'
            )
            ->where(
                'tahun_anggaran_id',
                $c['year']->id
            )
            ->orderBy('urutan')
            ->get();


        $expense = Belanja::publik()
            ->with('bidang')
            ->withSum(
                [
                    'realisasi' => function ($q) {
                        $q->where(
                            'status_publikasi',
                            'dipublikasikan'
                        );
                    },
                ],
                'nilai'
            )
            ->where(
                'tahun_anggaran_id',
                $c['year']->id
            )
            ->orderBy('urutan')
            ->get();


        return view(
            'public.realisasi',
            $c + [
                'summary' => $s->for($c['year']),

                'pendapatan' => $income,

                'belanja' => $expense,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function documents(int $tahun)
    {
        $c = $this->ctx($tahun);

        return view(
            'public.documents',
            $c + [
                'documents' => DokumenPublikasi::publik()
                    ->where(
                        'tahun_anggaran_id',
                        $c['year']->id
                    )
                    ->latest('tanggal_publikasi')
                    ->get(),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROFIL DESA
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        return view(
            'public.profile',
            $this->ctx()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DATA PENDAPATAN
    |--------------------------------------------------------------------------
    */

    private function income(TahunAnggaran $year)
    {
        return Pendapatan::publik()
            ->where(
                'tahun_anggaran_id',
                $year->id
            )
            ->orderBy('urutan')
            ->orderBy('kode')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | DATA BELANJA
    |--------------------------------------------------------------------------
    |
    | Kegiatan juga memuat Sub Bidang karena halaman publik
    | menggunakan struktur:
    |
    | Bidang
    |   └── Sub Bidang
    |       └── Kegiatan
    |
    */

    private function expense(TahunAnggaran $year)
    {
        return Belanja::publik()
            ->with([
                'bidang',
                'kegiatan.subBidang',
            ])
            ->where(
                'tahun_anggaran_id',
                $year->id
            )
            ->orderBy('urutan')
            ->orderBy('kode')
            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | DATA PEMBIAYAAN
    |--------------------------------------------------------------------------
    */

    private function financing(TahunAnggaran $year)
    {
        return Pembiayaan::publik()
            ->where(
                'tahun_anggaran_id',
                $year->id
            )
            ->orderBy('urutan')
            ->orderBy('kode')
            ->get();
    }
}