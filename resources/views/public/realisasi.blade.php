@extends('layouts.public')

@section('title', 'Realisasi APBDesa')

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
    | TOTAL REALISASI PENDAPATAN
    |--------------------------------------------------------------------------
    */

    $totalAnggaranPendapatan =
        $pendapatan->sum(
            fn ($item) => (float) $item->anggaran
        );

    $totalRealisasiPendapatan =
        $pendapatan->sum(
            fn ($item) => (float) (
                $item->realisasi_sum_nilai ?? 0
            )
        );

    $persenPendapatan =
        $totalAnggaranPendapatan > 0
            ? (
                $totalRealisasiPendapatan
                / $totalAnggaranPendapatan
            ) * 100
            : 0;

    $sisaPendapatan =
        $totalAnggaranPendapatan
        - $totalRealisasiPendapatan;


    /*
    |--------------------------------------------------------------------------
    | TOTAL REALISASI BELANJA
    |--------------------------------------------------------------------------
    */

    $totalAnggaranBelanja =
        $belanja->sum(
            fn ($item) => (float) $item->anggaran
        );

    $totalRealisasiBelanja =
        $belanja->sum(
            fn ($item) => (float) (
                $item->realisasi_sum_nilai ?? 0
            )
        );

    $persenBelanja =
        $totalAnggaranBelanja > 0
            ? (
                $totalRealisasiBelanja
                / $totalAnggaranBelanja
            ) * 100
            : 0;

    $sisaBelanja =
        $totalAnggaranBelanja
        - $totalRealisasiBelanja;

@endphp


<style>

    /* =========================================================
       WRAPPER
    ========================================================= */

    .realisasi-page {

        width:
            min(
                calc(100% - 48px),
                1280px
            );

        margin:
            0 auto;

        padding:
            34px 0 70px;
    }


    /* =========================================================
       HERO
    ========================================================= */

    .realisasi-hero {

        position:
            relative;

        overflow:
            hidden;

        padding:
            34px 38px;

        border-radius:
            24px;

        color:
            #fff;

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


    .realisasi-hero::before {

        content:
            "";

        position:
            absolute;

        width:
            300px;

        height:
            300px;

        right:
            -130px;

        bottom:
            -180px;

        border:
            1px solid rgba(255,255,255,.08);

        border-radius:
            50%;
    }


    .realisasi-hero-grid {

        position:
            relative;

        z-index:
            2;

        display:
            grid;

        grid-template-columns:
            minmax(0, 1fr)
            auto;

        align-items:
            center;

        gap:
            30px;
    }


    .realisasi-kicker {

        margin:
            0 0 7px;

        color:
            #93c5fd;

        font-size:
            12px;

        font-weight:
            800;

        letter-spacing:
            .09em;

        text-transform:
            uppercase;
    }


    .realisasi-title {

        margin:
            0;

        font-size:
            clamp(30px, 4vw, 42px);

        line-height:
            1.08;

        font-weight:
            800;

        letter-spacing:
            -.04em;
    }


    .realisasi-description {

        max-width:
            720px;

        margin:
            12px 0 0;

        color:
            rgba(255,255,255,.68);

        font-size:
            14px;

        line-height:
            1.7;
    }


    /* =========================================================
       TAHUN
    ========================================================= */

    .realisasi-year {

        min-width:
            190px;

        padding:
            18px 20px;

        border:
            1px solid rgba(255,255,255,.13);

        border-radius:
            17px;

        background:
            rgba(255,255,255,.08);

        backdrop-filter:
            blur(12px);
    }


    .realisasi-year-label {

        color:
            rgba(255,255,255,.55);

        font-size:
            10px;

        font-weight:
            700;

        letter-spacing:
            .08em;

        text-transform:
            uppercase;
    }


    .realisasi-year-value {

        margin-top:
            5px;

        color:
            #fff;

        font-size:
            27px;

        font-weight:
            800;
    }


    /* =========================================================
       RINGKASAN
    ========================================================= */

    .realisasi-overview {

        display:
            grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            16px;

        margin-top:
            22px;
    }


    .realisasi-overview-card {

        position:
            relative;

        overflow:
            hidden;

        padding:
            20px;

        border:
            1px solid #e2e8f0;

        border-radius:
            18px;

        background:
            #fff;

        box-shadow:
            0 7px 25px rgba(15,23,42,.04);

        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }


    .realisasi-overview-card::after {

        content:
            "";

        position:
            absolute;

        width:
            100px;

        height:
            100px;

        right:
            -45px;

        bottom:
            -55px;

        border-radius:
            50%;

        background:
            rgba(37,99,235,.045);

        transition:
            transform .35s ease;
    }


    .realisasi-overview-card:hover {

        transform:
            translateY(-5px);

        border-color:
            #cbd5e1;

        box-shadow:
            0 15px 32px rgba(15,23,42,.10);
    }


    .realisasi-overview-card:hover::after {

        transform:
            scale(1.4);
    }


    .realisasi-overview-label {

        position:
            relative;

        z-index:
            2;

        color:
            #64748b;

        font-size:
            11px;

        font-weight:
            800;

        letter-spacing:
            .07em;

        text-transform:
            uppercase;
    }


    .realisasi-overview-value {

        position:
            relative;

        z-index:
            2;

        margin-top:
            7px;

        color:
            #0f172a;

        font-size:
            22px;

        font-weight:
            800;

        letter-spacing:
            -.025em;
    }


    .realisasi-overview-meta {

        position:
            relative;

        z-index:
            2;

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            15px;

        margin-top:
            12px;

        color:
            #64748b;

        font-size:
            11px;
    }


    .realisasi-progress {

        position:
            relative;

        z-index:
            2;

        height:
            7px;

        margin-top:
            9px;

        overflow:
            hidden;

        border-radius:
            999px;

        background:
            #e2e8f0;
    }


    .realisasi-progress-bar {

        height:
            100%;

        border-radius:
            inherit;

        background:
            #2563eb;

        transition:
            width .5s ease;
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .realisasi-section {

        margin-top:
            25px;

        overflow:
            hidden;

        border:
            1px solid #e2e8f0;

        border-radius:
            20px;

        background:
            #fff;

        box-shadow:
            0 7px 25px rgba(15,23,42,.04);
    }


    .realisasi-section-header {

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            20px;

        padding:
            20px 23px;

        border-bottom:
            1px solid #e2e8f0;

        background:
            linear-gradient(
                180deg,
                #f8fafc,
                #f1f5f9
            );
    }


    .realisasi-section-kicker {

        margin:
            0 0 4px;

        color:
            #2563eb;

        font-size:
            10px;

        font-weight:
            800;

        letter-spacing:
            .1em;

        text-transform:
            uppercase;
    }


    .realisasi-section-title {

        margin:
            0;

        color:
            #0f172a;

        font-size:
            20px;

        font-weight:
            800;
    }


    .realisasi-section-total {

        text-align:
            right;
    }


    .realisasi-section-total-label {

        color:
            #94a3b8;

        font-size:
            10px;

        font-weight:
            700;

        letter-spacing:
            .07em;

        text-transform:
            uppercase;
    }


    .realisasi-section-total-value {

        margin-top:
            3px;

        color:
            #0f172a;

        font-size:
            18px;

        font-weight:
            800;

        white-space:
            nowrap;
    }


    /* =========================================================
       SUB SECTION PENDAPATAN
    ========================================================= */

    .realisasi-subsection {

        border-bottom:
            1px solid #eef2f7;
    }


    .realisasi-subsection:last-child {

        border-bottom:
            0;
    }


    .realisasi-subsection-header {

        padding:
            17px 23px 10px;
    }


    .realisasi-subsection-title {

        margin:
            0;

        color:
            #334155;

        font-size:
            14px;

        font-weight:
            800;

        line-height:
            1.5;
    }


    /* =========================================================
       ITEM PENDAPATAN
    ========================================================= */

    .realisasi-income-item {

        display:
            grid;

        grid-template-columns:
            minmax(0, 1fr)
            145px
            145px
            80px
            145px;

        align-items:
            center;

        gap:
            15px;

        margin:
            0 23px;

        padding:
            11px 4px;

        border-bottom:
            1px solid #f1f5f9;
    }


    .realisasi-income-item:last-child {

        border-bottom:
            0;
    }


    .realisasi-income-name {

        min-width:
            0;

        color:
            #334155;

        font-size:
            12px;

        line-height:
            1.5;
    }


    .realisasi-income-code {

        display:
            inline-block;

        margin-right:
            5px;

        color:
            #2563eb;

        font-weight:
            800;

        white-space:
            nowrap;
    }


    .realisasi-money {

        color:
            #334155;

        font-size:
            12px;

        font-weight:
            700;

        text-align:
            right;

        white-space:
            nowrap;
    }


    .realisasi-rate {

        color:
            #2563eb;

        font-size:
            12px;

        font-weight:
            800;

        text-align:
            right;

        white-space:
            nowrap;
    }


    .realisasi-rate-wrap {

        display:
            flex;

        align-items:
            center;

        justify-content:
            flex-end;

        gap:
            7px;
    }


    .realisasi-rate-track {

        width:
            48px;

        height:
            5px;

        overflow:
            hidden;

        border-radius:
            999px;

        background:
            #e2e8f0;
    }


    .realisasi-rate-bar {

        height:
            100%;

        border-radius:
            inherit;

        background:
            #2563eb;
    }


    /* =========================================================
       BELANJA BIDANG
    ========================================================= */

    .realisasi-bidang {

        border-bottom:
            1px solid #eef2f7;
    }


    .realisasi-bidang:last-child {

        border-bottom:
            0;
    }


    .realisasi-bidang-header {

        display:
            flex;

        align-items:
            center;

        gap:
            13px;

        padding:
            18px 23px;

        background:
            #fff;
    }


    .realisasi-bidang-code {

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        flex:
            0 0 auto;

        width:
            40px;

        height:
            40px;

        border-radius:
            11px;

        color:
            #2563eb;

        background:
            #dbeafe;

        font-size:
            12px;

        font-weight:
            800;
    }


    .realisasi-bidang-name {

        color:
            #0f172a;

        font-size:
            15px;

        font-weight:
            800;

        line-height:
            1.45;
    }


    /* =========================================================
       SUB BIDANG BELANJA
    ========================================================= */

    .realisasi-belanja-subbidang {

        margin:
            0 23px;

        padding:
            11px 4px 5px;

        border-top:
            1px solid #f1f5f9;
    }


    .realisasi-belanja-subbidang-title {

        color:
            #334155;

        font-size:
            13px;

        font-weight:
            700;

        line-height:
            1.5;
    }


    /* =========================================================
       REKENING BELANJA
    ========================================================= */

    .realisasi-rekening {

        display:
            grid;

        grid-template-columns:
            minmax(0, 1fr)
            145px
            145px
            80px
            145px;

        align-items:
            center;

        gap:
            15px;

        margin:
            0;

        padding:
            10px 4px 10px 18px;

        border-bottom:
            1px solid #f1f5f9;
    }


    .realisasi-rekening:last-child {

        border-bottom:
            0;
    }


    .realisasi-rekening-name {

        min-width:
            0;

        color:
            #475569;

        font-size:
            12px;

        font-weight:
            500;

        line-height:
            1.5;
    }


    .realisasi-rekening-code {

        color:
            #2563eb;

        font-weight:
            800;

        white-space:
            nowrap;
    }


    /* =========================================================
       TABLE HEADER
    ========================================================= */

    .realisasi-columns {

        display:
            grid;

        grid-template-columns:
            minmax(0, 1fr)
            145px
            145px
            80px
            145px;

        align-items:
            center;

        gap:
            15px;

        margin:
            0 23px;

        padding:
            10px 4px;

        color:
            #94a3b8;

        border-bottom:
            1px solid #e2e8f0;

        font-size:
            9px;

        font-weight:
            800;

        letter-spacing:
            .07em;

        text-transform:
            uppercase;
    }


    .realisasi-columns > div:not(:first-child) {

        text-align:
            right;
    }


    /* =========================================================
       RINGKASAN BAWAH
    ========================================================= */

    .realisasi-summary-block {

        padding:
            17px 23px;
    }


    .realisasi-summary-row {

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            20px;

        padding:
            12px 15px;

        border:
            1px solid #e2e8f0;

        border-radius:
            12px;

        background:
            #f8fafc;

        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }


    .realisasi-summary-row:hover {

        transform:
            translateY(-2px);

        border-color:
            #cbd5e1;

        background:
            #fff;

        box-shadow:
            0 8px 20px rgba(15,23,42,.06);
    }


    .realisasi-summary-label {

        color:
            #475569;

        font-size:
            12px;

        font-weight:
            800;

        text-transform:
            uppercase;

        letter-spacing:
            .04em;
    }


    .realisasi-summary-value {

        color:
            #0f172a;

        font-size:
            15px;

        font-weight:
            800;

        white-space:
            nowrap;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .realisasi-empty {

        padding:
            45px 20px;

        text-align:
            center;
    }


    .realisasi-empty-icon {

        width:
            52px;

        height:
            52px;

        margin:
            0 auto 12px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            14px;

        background:
            #f1f5f9;

        color:
            #94a3b8;

        font-size:
            23px;
    }


    .realisasi-empty-title {

        color:
            #475569;

        font-size:
            14px;

        font-weight:
            700;
    }


    .realisasi-empty-text {

        margin-top:
            4px;

        color:
            #94a3b8;

        font-size:
            11px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .realisasi-page {

            width:
                calc(100% - 30px);
        }


        .realisasi-hero {

            padding:
                28px;
        }


        .realisasi-hero-grid {

            grid-template-columns:
                1fr;
        }


        .realisasi-year {

            width:
                100%;
        }


        .realisasi-overview {

            grid-template-columns:
                1fr;
        }


        .realisasi-income-item,
        .realisasi-rekening,
        .realisasi-columns {

            grid-template-columns:
                minmax(0, 1fr)
                120px
                120px
                70px
                120px;
        }

    }


    @media (max-width: 700px) {

        .realisasi-income-item,
        .realisasi-rekening,
        .realisasi-columns {

            grid-template-columns:
                minmax(0, 1fr)
                120px
                120px
                70px
                120px;

            min-width:
                720px;
        }


        .realisasi-income-item,
        .realisasi-rekening {

            margin-right:
                17px;

            margin-left:
                17px;
        }


        .realisasi-columns {

            margin-right:
                17px;

            margin-left:
                17px;
        }


        .realisasi-section {

            overflow-x:
                auto;
        }

    }


    @media (max-width: 650px) {

        .realisasi-page {

            width:
                calc(100% - 20px);

            padding:
                22px 0 50px;
        }


        .realisasi-hero {

            padding:
                24px 20px;

            border-radius:
                20px;
        }


        .realisasi-title {

            font-size:
                28px;
        }


        .realisasi-description {

            font-size:
                12px;
        }


        .realisasi-section-header {

            align-items:
                flex-start;

            flex-direction:
                column;

            padding:
                18px 17px;
        }


        .realisasi-section-total {

            text-align:
                left;
        }


        .realisasi-bidang-header {

            padding:
                16px 17px;
        }


        .realisasi-belanja-subbidang {

            margin:
                0 17px;
        }


        .realisasi-summary-block {

            padding:
                15px 17px;
        }


        .realisasi-summary-row {

            align-items:
                flex-start;

            flex-direction:
                column;

            gap:
                5px;
        }

    }


    /* =========================================================
       REDUCE MOTION
    ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .realisasi-overview-card,
        .realisasi-summary-row {

            transition:
                none !important;
        }

    }

</style>


<div class="realisasi-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="realisasi-hero">

        <div class="realisasi-hero-grid">

            <div>

                <p class="realisasi-kicker">
                    Transparansi Keuangan Desa
                </p>


                <h1 class="realisasi-title">
                    Realisasi APBDesa
                </h1>


                <p class="realisasi-description">

                    Informasi realisasi Anggaran Pendapatan
                    dan Belanja Desa {{ $namaDesa }}
                    Tahun Anggaran {{ $year->tahun }}.

                </p>

            </div>


            <div class="realisasi-year">

                <div class="realisasi-year-label">
                    Tahun Anggaran
                </div>


                <div class="realisasi-year-value">
                    {{ $year->tahun }}
                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}

    <div class="realisasi-overview">


        {{-- PENDAPATAN --}}

        <div class="realisasi-overview-card">

            <div class="realisasi-overview-label">
                Realisasi Pendapatan
            </div>


            <div class="realisasi-overview-value">

                {{ $formatRupiah($totalRealisasiPendapatan) }}

            </div>


            <div class="realisasi-overview-meta">

                <span>
                    Anggaran
                    {{ $formatRupiah($totalAnggaranPendapatan) }}
                </span>


                <strong>

                    {{ number_format(
                        $persenPendapatan,
                        2,
                        ',',
                        '.'
                    ) }}%

                </strong>

            </div>


            <div class="realisasi-progress">

                <div
                    class="realisasi-progress-bar"
                    style="
                        width:
                        {{ min($persenPendapatan, 100) }}%
                    "
                ></div>

            </div>

        </div>



        {{-- BELANJA --}}

        <div class="realisasi-overview-card">

            <div class="realisasi-overview-label">
                Realisasi Belanja
            </div>


            <div class="realisasi-overview-value">

                {{ $formatRupiah($totalRealisasiBelanja) }}

            </div>


            <div class="realisasi-overview-meta">

                <span>

                    Anggaran
                    {{ $formatRupiah($totalAnggaranBelanja) }}

                </span>


                <strong>

                    {{ number_format(
                        $persenBelanja,
                        2,
                        ',',
                        '.'
                    ) }}%

                </strong>

            </div>


            <div class="realisasi-progress">

                <div
                    class="realisasi-progress-bar"
                    style="
                        width:
                        {{ min($persenBelanja, 100) }}%
                    "
                ></div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         REALISASI PENDAPATAN
    ====================================================== --}}

    <section class="realisasi-section">


        <div class="realisasi-section-header">

            <div>

                <p class="realisasi-section-kicker">
                    Realisasi APBDesa
                </p>


                <h2 class="realisasi-section-title">
                    Pendapatan
                </h2>

            </div>


            <div class="realisasi-section-total">

                <div class="realisasi-section-total-label">
                    Realisasi Pendapatan
                </div>


                <div class="realisasi-section-total-value">

                    {{ $formatRupiah(
                        $totalRealisasiPendapatan
                    ) }}

                </div>

            </div>

        </div>



        @if($pendapatan->isNotEmpty())

            @php

                $kelompokPendapatan = [

                    '4.1' =>
                        'Pendapatan Asli Desa',

                    '4.2' =>
                        'Pendapatan Transfer',

                    '4.3' =>
                        'Pendapatan Lain-lain',

                ];

            @endphp


            @foreach(
                $kelompokPendapatan
                as $prefix => $namaKelompok
            )

                @php

                    $itemsPendapatan =
                        $pendapatan
                            ->filter(
                                function ($item)
                                use ($prefix) {

                                    return str_starts_with(
                                        trim(
                                            $item->kode ?? ''
                                        ),
                                        $prefix . '.'
                                    );

                                }
                            )
                            ->values();

                @endphp


                @if($itemsPendapatan->isNotEmpty())

                    <div class="realisasi-subsection">


                        <div
                            class="
                                realisasi-subsection-header
                            "
                        >

                            <h3
                                class="
                                    realisasi-subsection-title
                                "
                            >

                                {{ $prefix }}
                                —
                                {{ $namaKelompok }}

                            </h3>

                        </div>


                        {{-- HEADER --}}

                        <div class="realisasi-columns">

                            <div>
                                Uraian
                            </div>

                            <div>
                                Anggaran
                            </div>

                            <div>
                                Realisasi
                            </div>

                            <div>
                                %
                            </div>

                            <div>
                                Sisa
                            </div>

                        </div>


                        @foreach(
                            $itemsPendapatan
                            as $item
                        )

                            @php

                                $actual =
                                    (float) (
                                        $item
                                            ->realisasi_sum_nilai
                                        ?? 0
                                    );


                                $anggaran =
                                    (float)
                                    $item->anggaran;


                                $rate =
                                    $anggaran > 0
                                        ? (
                                            $actual
                                            / $anggaran
                                        ) * 100
                                        : 0;


                                $sisa =
                                    $anggaran
                                    - $actual;

                            @endphp


                            <div
                                class="
                                    realisasi-income-item
                                "
                            >


                                <div
                                    class="
                                        realisasi-income-name
                                    "
                                >

                                    <span
                                        class="
                                            realisasi-income-code
                                        "
                                    >

                                        {{ $item->kode }}

                                    </span>

                                    —
                                    {{ $item->uraian }}

                                </div>


                                <div
                                    class="
                                        realisasi-money
                                    "
                                >

                                    {{ $formatRupiah(
                                        $anggaran
                                    ) }}

                                </div>


                                <div
                                    class="
                                        realisasi-money
                                    "
                                >

                                    {{ $formatRupiah(
                                        $actual
                                    ) }}

                                </div>


                                <div
                                    class="
                                        realisasi-rate
                                    "
                                >

                                    <div
                                        class="
                                            realisasi-rate-wrap
                                        "
                                    >

                                        <div
                                            class="
                                                realisasi-rate-track
                                            "
                                        >

                                            <div
                                                class="
                                                    realisasi-rate-bar
                                                "
                                                style="
                                                    width:
                                                    {{ min(
                                                        $rate,
                                                        100
                                                    ) }}%
                                                "
                                            ></div>

                                        </div>


                                        {{ number_format(
                                            $rate,
                                            2,
                                            ',',
                                            '.'
                                        ) }}%

                                    </div>

                                </div>


                                <div
                                    class="
                                        realisasi-money
                                    "
                                >

                                    {{ $formatRupiah(
                                        $sisa
                                    ) }}

                                </div>


                            </div>

                        @endforeach


                    </div>

                @endif

            @endforeach


            {{-- TOTAL --}}

            <div
                class="
                    realisasi-summary-block
                "
            >

                <div
                    class="
                        realisasi-summary-row
                    "
                >

                    <div
                        class="
                            realisasi-summary-label
                        "
                    >

                        Jumlah Realisasi Pendapatan

                    </div>


                    <div
                        class="
                            realisasi-summary-value
                        "
                    >

                        {{ $formatRupiah(
                            $totalRealisasiPendapatan
                        ) }}

                    </div>

                </div>

            </div>


        @else

            <div class="realisasi-empty">

                <div class="realisasi-empty-icon">

                    <i class='bx bx-folder-open'></i>

                </div>


                <div class="realisasi-empty-title">

                    Belum Ada Realisasi Pendapatan

                </div>


                <div class="realisasi-empty-text">

                    Belum terdapat realisasi pendapatan
                    yang dipublikasikan untuk tahun ini.

                </div>

            </div>

        @endif

    </section>



    {{-- =====================================================
         REALISASI BELANJA
    ====================================================== --}}

    <section class="realisasi-section">


        <div class="realisasi-section-header">

            <div>

                <p class="realisasi-section-kicker">
                    Realisasi APBDesa
                </p>


                <h2 class="realisasi-section-title">
                    Belanja
                </h2>

            </div>


            <div class="realisasi-section-total">

                <div class="realisasi-section-total-label">
                    Realisasi Belanja
                </div>


                <div class="realisasi-section-total-value">

                    {{ $formatRupiah(
                        $totalRealisasiBelanja
                    ) }}

                </div>

            </div>

        </div>



        @if($belanja->isNotEmpty())

            @php

                /*
                |--------------------------------------------------------------------------
                | KELOMPOK BIDANG
                |--------------------------------------------------------------------------
                */

                $bidangGroups =
                    $belanja->groupBy(
                        function ($item) {

                            return $item->bidang?->id
                                ?? 'tanpa-bidang';

                        }
                    );

            @endphp


            @foreach(
                $bidangGroups
                as $bidangId => $bidangItems
            )

                @php

                    $bidang =
                        $bidangItems
                            ->first()?->bidang;


                    /*
                    |--------------------------------------------------------------------------
                    | KELOMPOK SUB BIDANG
                    |--------------------------------------------------------------------------
                    */

                    $subBidangGroups =
                        $bidangItems->groupBy(
                            function ($item) {

                                return
                                    $item
                                        ->kegiatan
                                        ?->sub_bidang_id
                                    ?? 'tanpa-sub-bidang';

                            }
                        );

                @endphp


                <div class="realisasi-bidang">


                    {{-- =================================================
                         BIDANG
                    ================================================== --}}

                    <div
                        class="
                            realisasi-bidang-header
                        "
                    >

                        <div
                            class="
                                realisasi-bidang-code
                            "
                        >

                            {{ $bidang?->kode ?? '—' }}

                        </div>


                        <div
                            class="
                                realisasi-bidang-name
                            "
                        >

                            {{ $bidang?->nama
                                ?? 'Belanja Lainnya'
                            }}

                        </div>

                    </div>



                    {{-- =================================================
                         SUB BIDANG
                    ================================================== --}}

                    @foreach(
                        $subBidangGroups
                        as $subBidangId => $subBidangItems
                    )

                        @php

                            $subBidang =
                                $subBidangItems
                                    ->first()
                                    ?->kegiatan
                                    ?->subBidang;

                        @endphp


                        <div
                            class="
                                realisasi-belanja-subbidang
                            "
                        >


                            <div
                                class="
                                    realisasi-belanja-subbidang-title
                                "
                            >

                                @if($subBidang)

                                    {{ $subBidang->kode }}
                                    —
                                    Sub Bidang
                                    {{ $subBidang->nama }}

                                @else

                                    Sub Bidang
                                    Belanja Lainnya

                                @endif

                            </div>



                            {{-- =================================================
                                 HEADER REKENING
                            ================================================== --}}

                            <div
                                class="
                                    realisasi-columns
                                "
                            >

                                <div>
                                    Rekening Belanja
                                </div>

                                <div>
                                    Anggaran
                                </div>

                                <div>
                                    Realisasi
                                </div>

                                <div>
                                    %
                                </div>

                                <div>
                                    Sisa
                                </div>

                            </div>



                            {{-- =================================================
                                 REKENING BELANJA
                            ================================================== --}}

                            @foreach(
                                $subBidangItems
                                as $item
                            )

                                @php

                                    $anggaran =
                                        (float)
                                        $item->anggaran;


                                    $realisasi =
                                        (float) (
                                            $item
                                                ->realisasi_sum_nilai
                                            ?? 0
                                        );


                                    $rate =
                                        $anggaran > 0
                                            ? (
                                                $realisasi
                                                / $anggaran
                                            ) * 100
                                            : 0;


                                    $sisa =
                                        $anggaran
                                        - $realisasi;


                                    $rekening =
                                        $item->belanjaRekening;

                                @endphp


                                <div
                                    class="
                                        realisasi-rekening
                                    "
                                >


                                    {{-- REKENING --}}

                                    <div
                                        class="
                                            realisasi-rekening-name
                                        "
                                    >

                                        @if($rekening)

                                            <span
                                                class="
                                                    realisasi-rekening-code
                                                "
                                            >

                                                {{ rtrim(
                                                    $rekening->kode,
                                                    '.'
                                                ) }}

                                            </span>

                                            —
                                            {{ $rekening->uraian }}

                                        @else

                                            {{ $item->uraian }}

                                        @endif

                                    </div>



                                    {{-- ANGGARAN --}}

                                    <div
                                        class="
                                            realisasi-money
                                        "
                                    >

                                        {{ $formatRupiah(
                                            $anggaran
                                        ) }}

                                    </div>



                                    {{-- REALISASI --}}

                                    <div
                                        class="
                                            realisasi-money
                                        "
                                    >

                                        {{ $formatRupiah(
                                            $realisasi
                                        ) }}

                                    </div>



                                    {{-- PERSENTASE --}}

                                    <div
                                        class="
                                            realisasi-rate
                                        "
                                    >

                                        <div
                                            class="
                                                realisasi-rate-wrap
                                            "
                                        >

                                            <div
                                                class="
                                                    realisasi-rate-track
                                                "
                                            >

                                                <div
                                                    class="
                                                        realisasi-rate-bar
                                                    "
                                                    style="
                                                        width:
                                                        {{ min(
                                                            $rate,
                                                            100
                                                        ) }}%
                                                    "
                                                ></div>

                                            </div>


                                            {{ number_format(
                                                $rate,
                                                2,
                                                ',',
                                                '.'
                                            ) }}%

                                        </div>

                                    </div>



                                    {{-- SISA --}}

                                    <div
                                        class="
                                            realisasi-money
                                        "
                                    >

                                        {{ $formatRupiah(
                                            $sisa
                                        ) }}

                                    </div>


                                </div>

                            @endforeach


                        </div>

                    @endforeach


                </div>

            @endforeach


            {{-- =================================================
                 TOTAL REALISASI BELANJA
            ================================================== --}}

            <div
                class="
                    realisasi-summary-block
                "
            >

                <div
                    class="
                        realisasi-summary-row
                    "
                >

                    <div
                        class="
                            realisasi-summary-label
                        "
                    >

                        Jumlah Realisasi Belanja

                    </div>


                    <div
                        class="
                            realisasi-summary-value
                        "
                    >

                        {{ $formatRupiah(
                            $totalRealisasiBelanja
                        ) }}

                    </div>

                </div>

            </div>


        @else

            <div class="realisasi-empty">

                <div class="realisasi-empty-icon">

                    <i class='bx bx-folder-open'></i>

                </div>


                <div class="realisasi-empty-title">

                    Belum Ada Realisasi Belanja

                </div>


                <div class="realisasi-empty-text">

                    Belum terdapat realisasi belanja
                    yang dipublikasikan untuk tahun ini.

                </div>

            </div>

        @endif

    </section>


</div>

@endsection