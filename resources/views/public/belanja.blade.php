@extends('layouts.public')

@section('title', 'Belanja Desa')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    $formatRupiah = function ($value) {

        return 'Rp ' . number_format(
            (float) $value,
            0,
            ',',
            '.'
        );

    };


    /*
    |--------------------------------------------------------------------------
    | NAMA DESA
    |--------------------------------------------------------------------------
    */

    $namaDesa = trim(
        $desa->nama ?? 'Desa'
    );


    /*
    |--------------------------------------------------------------------------
    | TOTAL BELANJA
    |--------------------------------------------------------------------------
    */

    $totalBelanja = (float) (
        $summary['expense'] ?? 0
    );

@endphp


<style>

/* =========================================================
   HALAMAN BELANJA
   ========================================================= */

.belanja-page {

    width: min(
        calc(100% - 48px),
        1280px
    );

    margin: 32px auto 0;

    padding: 0 0 70px;

    position: relative;

    z-index: 1;
}


/* =========================================================
   HERO BELANJA
   ========================================================= */

.belanja-hero {

    position: relative;

    overflow: hidden;

    padding: 34px 38px;

    border-radius: 24px;

    color: #fff;

    background:
        radial-gradient(
            circle at 90% 10%,
            rgba(96,165,250,.25),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #0f172a,
            #172554 58%,
            #1d4ed8
        );

    box-shadow:
        0 18px 45px rgba(15,23,42,.13);
}


.belanja-hero::before {

    content: "";

    position: absolute;

    width: 280px;
    height: 280px;

    right: -120px;
    bottom: -170px;

    border:
        1px solid rgba(255,255,255,.08);

    border-radius: 50%;

    pointer-events: none;
}


.belanja-hero-grid {

    position: relative;

    z-index: 2;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        auto;

    align-items: center;

    gap: 30px;
}


.belanja-kicker {

    margin: 0 0 7px;

    color: #93c5fd;

    font-size: 12px;

    font-weight: 800;

    letter-spacing: .08em;

    text-transform: uppercase;
}


.belanja-title {

    margin: 0;

    color: #fff;

    font-size:
        clamp(30px, 4vw, 42px);

    line-height: 1.08;

    font-weight: 800;

    letter-spacing: -.04em;
}


.belanja-description {

    max-width: 680px;

    margin: 12px 0 0;

    color:
        rgba(255,255,255,.68);

    font-size: 14px;

    line-height: 1.7;
}


/* =========================================================
   TOTAL HERO
   ========================================================= */

.belanja-total {

    min-width: 240px;

    padding: 19px 21px;

    border:
        1px solid rgba(255,255,255,.13);

    border-radius: 17px;

    background:
        rgba(255,255,255,.08);

    backdrop-filter: blur(12px);

    -webkit-backdrop-filter: blur(12px);
}


.belanja-total-label {

    color:
        rgba(255,255,255,.55);

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .08em;
}


.belanja-total-value {

    margin-top: 6px;

    color: #fff;

    font-size:
        clamp(23px, 2.5vw, 31px);

    font-weight: 800;

    letter-spacing: -.04em;
}


.belanja-total-year {

    margin-top: 5px;

    color:
        rgba(255,255,255,.5);

    font-size: 11px;
}


/* =========================================================
   INFORMASI BELANJA
   ========================================================= */

.belanja-info {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 20px;

    margin: 28px 0 17px;
}


.belanja-section-kicker {

    margin: 0 0 5px;

    color: #2563eb;

    font-size: 11px;

    font-weight: 800;

    letter-spacing: .1em;

    text-transform: uppercase;
}


.belanja-section-title {

    margin: 0;

    color: #0f172a;

    font-size: 22px;

    font-weight: 800;

    letter-spacing: -.025em;
}


.belanja-section-description {

    margin: 5px 0 0;

    color: #64748b;

    font-size: 12px;
}


/* =========================================================
   BIDANG CARD
   ========================================================= */

.bidang-card {

    overflow: hidden;

    margin-bottom: 16px;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    background: #fff;

    box-shadow:
        0 6px 22px rgba(15,23,42,.04);

    /*
     * Jangan gunakan transform pada card.
     * Ini mencegah efek berkedip/lompat.
     */
    transition:
        box-shadow .2s ease,
        border-color .2s ease;
}


.bidang-card:hover {

    border-color: #cbd5e1;

    box-shadow:
        0 14px 30px rgba(15,23,42,.07);

    transform: none;
}


/* =========================================================
   HEADER BIDANG
   ========================================================= */

.bidang-header {

    display: flex;

    align-items: center;

    gap: 15px;

    padding: 20px 22px;

    background:
        linear-gradient(
            180deg,
            #f8fafc,
            #f1f5f9
        );

    border-bottom:
        1px solid #e2e8f0;
}


.bidang-heading {

    display: flex;

    align-items: center;

    gap: 14px;

    min-width: 0;
}


.bidang-number {

    flex: 0 0 auto;

    width: 45px;
    height: 45px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 12px;

    color: #2563eb;

    background: #dbeafe;

    font-size: 14px;

    font-weight: 800;
}


.bidang-name {

    margin: 0;

    color: #0f172a;

    font-size: 17px;

    font-weight: 800;

    line-height: 1.45;
}


/* =========================================================
   SUB BIDANG
   ========================================================= */

.subbidang-block {

    border-bottom:
        1px solid #f1f5f9;
}


.subbidang-block:last-child {

    border-bottom: 0;
}


.subbidang-header {

    padding:
        18px 22px 12px;

    background: #fff;
}


.subbidang-name {

    color: #334155;

    font-size: 14px;

    font-weight: 700;

    line-height: 1.6;
}


/* =========================================================
   DAFTAR KEGIATAN
   ========================================================= */

.kegiatan-list {

    display: grid;

    gap: 4px;

    padding:
        0 22px 14px;
}


/* =========================================================
   KEGIATAN
   ========================================================= */

.kegiatan-block {

    overflow: hidden;

    border:
        1px solid #e2e8f0;

    border-radius: 12px;

    background: #f8fafc;

    /*
     * Tidak menggunakan transform.
     * Menghindari efek loncat/berkedip.
     */
    transition:
        border-color .2s ease,
        box-shadow .2s ease;
}


.kegiatan-block:hover {

    border-color: #cbd5e1;

    box-shadow:
        0 5px 14px rgba(15,23,42,.05);

    transform: none;
}


.kegiatan-header {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 28px;

    padding: 13px 18px;
}


.kegiatan-name {

    color: #0f172a;

    font-size: 14px;

    font-weight: 500;

    line-height: 1.45;
}


.kegiatan-total {

    flex: 0 0 auto;

    color: #0f172a;

    font-size: 14px;

    font-weight: 500;

    white-space: nowrap;
}


/* =========================================================
   TOTAL KESELURUHAN
   ========================================================= */

.total-belanja-card {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 25px;

    margin-top: 20px;

    padding: 23px 26px;

    border-radius: 18px;

    color: #fff;

    background:
        linear-gradient(
            135deg,
            #0f172a,
            #172554
        );

    box-shadow:
        0 15px 35px rgba(15,23,42,.12);
}


.total-belanja-label {

    color:
        rgba(255,255,255,.55);

    font-size: 11px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: .08em;
}


.total-belanja-title {

    margin-top: 4px;

    color: #fff;

    font-size: 17px;

    font-weight: 800;
}


.total-belanja-value {

    color: #fff;

    font-size:
        clamp(24px, 3vw, 32px);

    font-weight: 800;

    letter-spacing: -.04em;

    white-space: nowrap;
}


/* =========================================================
   EMPTY STATE
   ========================================================= */

.belanja-empty {

    padding: 60px 20px;

    text-align: center;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    background: #fff;
}


.belanja-empty-icon {

    width: 58px;
    height: 58px;

    margin: 0 auto 14px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 15px;

    background: #eff6ff;

    color: #2563eb;

    font-size: 25px;
}


.belanja-empty-title {

    margin: 0;

    color: #0f172a;

    font-size: 18px;

    font-weight: 800;
}


.belanja-empty-text {

    max-width: 480px;

    margin: 7px auto 0;

    color: #64748b;

    font-size: 12px;

    line-height: 1.7;
}


/* =========================================================
   PENJELASAN
   ========================================================= */

.belanja-penjelasan {

    display: flex;

    align-items: flex-start;

    gap: 12px;

    margin-top: 24px;

    padding:
        0 8px;
}


.belanja-penjelasan-icon {

    flex: 0 0 auto;

    width: 28px;
    height: 28px;

    display: flex;

    align-items: center;
    justify-content: center;

    margin-top: 2px;

    border-radius: 8px;

    background: #eff6ff;

    color: #2563eb;

    font-size: 16px;
}


.belanja-penjelasan-content {

    min-width: 0;
}


.belanja-penjelasan-title {

    margin: 0;

    color: #334155;

    font-size: 12px;

    font-weight: 700;
}


.belanja-penjelasan-text {

    margin: 4px 0 0;

    color: #64748b;

    font-size: 12px;

    line-height: 2;
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 900px) {

    .belanja-page {

        width:
            calc(100% - 30px);

        margin-top: 28px;
    }


    .belanja-hero {

        padding: 28px;
    }


    .belanja-hero-grid {

        grid-template-columns: 1fr;
    }


    .belanja-total {

        width: 100%;

        min-width: 0;
    }

}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 650px) {

    .belanja-page {

        width:
            calc(100% - 20px);

        margin-top: 22px;

        padding:
            0 0 50px;
    }


    .belanja-hero {

        padding:
            24px 20px;

        border-radius: 20px;
    }


    .belanja-title {

        font-size: 28px;
    }


    .belanja-description {

        font-size: 12px;
    }


    .belanja-info {

        margin-top: 24px;
    }


    .bidang-header {

        padding:
            17px 16px;
    }


    .bidang-heading {

        align-items: flex-start;
    }


    .bidang-number {

        width: 38px;
        height: 38px;

        font-size: 12px;
    }


    .bidang-name {

        font-size: 14px;
    }


    .subbidang-header {

        padding:
            14px 16px 11px;
    }


    .subbidang-name {

        font-size: 13px;
    }


    .kegiatan-list {

        padding:
            0 15px 12px;

        gap: 4px;
    }


    .kegiatan-header {

        display: block;

        padding:
            12px 15px;
    }


    .kegiatan-name {

        font-size: 14px;

        font-weight: 500;
    }


    .kegiatan-total {

        display: block;

        margin-top: 6px;

        font-size: 14px;

        font-weight: 500;

        text-align: left;
    }


    .total-belanja-card {

        align-items: flex-start;

        flex-direction: column;

        padding: 20px;
    }


    .total-belanja-value {

        font-size: 27px;
    }


    .belanja-penjelasan {

        padding: 0 4px;
    }

}


/* =========================================================
   SMALL MOBILE
   ========================================================= */

@media (max-width: 420px) {

    .belanja-page {

        width:
            calc(100% - 16px);

        margin-top: 18px;
    }


    .belanja-hero {

        padding:
            22px 17px;
    }


    .belanja-title {

        font-size: 25px;
    }


    .belanja-total-value {

        font-size: 23px;
    }

}


/* =========================================================
   REDUCED MOTION
   ========================================================= */

@media (prefers-reduced-motion: reduce) {

    .bidang-card,
    .kegiatan-block {

        transition: none !important;

        transform: none !important;
    }

}

</style>


{{-- =========================================================
     WRAPPER BELANJA
========================================================= --}}

<div class="belanja-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="belanja-hero">

        <div class="belanja-hero-grid">


            <div>

                <p class="belanja-kicker">
                    APBDesa {{ $year->tahun }}
                </p>


                <h1 class="belanja-title">
                    Belanja {{ $namaDesa }}
                </h1>


                <p class="belanja-description">

                    Rincian belanja desa berdasarkan bidang,
                    sub bidang, dan kegiatan yang telah
                    dipublikasikan.

                </p>

            </div>


            <div class="belanja-total">

                <div class="belanja-total-label">
                    Total Belanja Desa
                </div>


                <div class="belanja-total-value">
                    {{ $formatRupiah($totalBelanja) }}
                </div>


                <div class="belanja-total-year">
                    Tahun Anggaran {{ $year->tahun }}
                </div>

            </div>


        </div>

    </section>


    {{-- =====================================================
         JUDUL RINCIAN
    ====================================================== --}}

    <div class="belanja-info">

        <div>

            <p class="belanja-section-kicker">
                Rincian Anggaran
            </p>


            <h2 class="belanja-section-title">
                Belanja Berdasarkan Kegiatan
            </h2>


            <p class="belanja-section-description">

                Data hanya menampilkan belanja yang
                telah dipublikasikan.

            </p>

        </div>

    </div>


    {{-- =====================================================
         DAFTAR BIDANG
    ====================================================== --}}

    @forelse($groups as $name => $items)

        @php

            /*
            |--------------------------------------------------------------------------
            | KELOMPOKKAN BERDASARKAN SUB BIDANG
            |--------------------------------------------------------------------------
            */

            $subBidangGroups = $items->groupBy(
                function ($item) {

                    return $item->kegiatan?->sub_bidang_id
                        ?? 'tanpa-sub-bidang';

                }
            );

        @endphp


        <section class="bidang-card">


            {{-- =================================================
                 BIDANG
            ================================================== --}}

            <div class="bidang-header">

                <div class="bidang-heading">


                    <div class="bidang-number">

                        {{ $items->first()?->bidang?->kode ?? '—' }}

                    </div>


                    <h3 class="bidang-name">

                        {{ $name }}

                    </h3>


                </div>

            </div>


            {{-- =================================================
                 SUB BIDANG
            ================================================== --}}

            @foreach($subBidangGroups as $subBidangId => $subBidangItems)

                @php

                    $kegiatanGroups = $subBidangItems->groupBy(
                        function ($item) {

                            return $item->kegiatan_id
                                ?? 'tanpa-kegiatan';

                        }
                    );


                    $kegiatanPertama =
                        $subBidangItems->first()?->kegiatan;


                    $subBidang =
                        $kegiatanPertama?->subBidang;

                @endphp


                <div class="subbidang-block">


                    {{-- =================================================
                         NAMA SUB BIDANG
                    ================================================== --}}

                    <div class="subbidang-header">

                        <div class="subbidang-name">

                            @if($subBidang)

                                {{ $subBidang->kode }}
                                —
                                {{ $subBidang->nama }}

                            @else

                                Belanja Lainnya

                            @endif

                        </div>

                    </div>


                    {{-- =================================================
                         KEGIATAN
                    ================================================== --}}

                    <div class="kegiatan-list">

                        @foreach($kegiatanGroups as $kegiatanId => $kegiatanItems)

                            @php

                                $kegiatan =
                                    $kegiatanItems->first()?->kegiatan;


                                $kegiatanTotal =
                                    $kegiatanItems->sum('anggaran');

                            @endphp


                            <div class="kegiatan-block">

                                <div class="kegiatan-header">


                                    <div class="kegiatan-name">

                                        @if($kegiatan)

                                            {{ $kegiatan->kode }}
                                            —
                                            {{ $kegiatan->nama }}

                                        @else

                                            {{ $kegiatanItems->first()->uraian }}

                                        @endif

                                    </div>


                                    <div class="kegiatan-total">

                                        {{ $formatRupiah($kegiatanTotal) }}

                                    </div>


                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </section>

    @empty


        {{-- =================================================
             EMPTY STATE
        ================================================== --}}

        <div class="belanja-empty">

            <div class="belanja-empty-icon">

                <i class='bx bx-folder-open'></i>

            </div>


            <h2 class="belanja-empty-title">

                Belum Ada Belanja yang Dipublikasikan

            </h2>


            <p class="belanja-empty-text">

                Belum terdapat data belanja desa yang
                dipublikasikan untuk Tahun Anggaran
                {{ $year->tahun }}.

            </p>

        </div>

    @endforelse


    {{-- =====================================================
         TOTAL BELANJA DESA
    ====================================================== --}}

    @if($groups->isNotEmpty())

        <div class="total-belanja-card">

            <div>

                <div class="total-belanja-title">
                    Total Belanja Desa
                </div>

            </div>


            <div class="total-belanja-value">

                {{ $formatRupiah($totalBelanja) }}

            </div>

        </div>

    @endif


    {{-- =====================================================
         PENJELASAN BELANJA DESA
    ====================================================== --}}

    <div class="belanja-penjelasan">

        <div class="belanja-penjelasan-icon">

            <i class='bx bx-info-circle'></i>

        </div>


        <div class="belanja-penjelasan-content">

            <h3 class="belanja-penjelasan-title">

                Pengertian Belanja Desa

            </h3>


            <p class="belanja-penjelasan-text">

                Belanja Desa adalah semua pengeluaran dari
                Rekening Kas Desa yang merupakan kewajiban
                Desa dalam 1 (satu) Tahun Anggaran yang tidak
                akan diperoleh pembayarannya kembali oleh Desa.

            </p>

        </div>

    </div>


</div>

@endsection