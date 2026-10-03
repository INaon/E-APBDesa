@extends('layouts.public')

@section('title', 'Dokumen Publikasi')

@section('content')

@php

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
    | JUMLAH DOKUMEN
    |--------------------------------------------------------------------------
    */

    $jumlahDokumen = $documents->count();


    /*
    |--------------------------------------------------------------------------
    | FORMAT TANGGAL
    |--------------------------------------------------------------------------
    */

    $formatTanggal = function ($tanggal) {

        if (!$tanggal) {
            return '-';
        }

        return \Carbon\Carbon::parse($tanggal)
            ->locale('id')
            ->translatedFormat('d F Y');

    };

@endphp


<style>

    /* =========================================================
       WRAPPER
    ========================================================= */

    .dokumen-page {

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

    .dokumen-hero {

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


    .dokumen-hero::before {

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


    .dokumen-hero-grid {

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


    .dokumen-kicker {

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


    .dokumen-title {

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


    .dokumen-description {

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

    .dokumen-year {

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


    .dokumen-year-label {

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


    .dokumen-year-value {

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

    .dokumen-overview {

        display:
            grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            16px;

        margin-top:
            22px;
    }


    .dokumen-overview-card {

        position:
            relative;

        overflow:
            hidden;

        display:
            flex;

        align-items:
            center;

        gap:
            15px;

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


    .dokumen-overview-card::after {

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


    .dokumen-overview-card:hover {

        transform:
            translateY(-5px);

        border-color:
            #cbd5e1;

        box-shadow:
            0 15px 32px rgba(15,23,42,.10);
    }


    .dokumen-overview-card:hover::after {

        transform:
            scale(1.4);
    }


    .dokumen-overview-icon {

        position:
            relative;

        z-index:
            2;

        flex:
            0 0 auto;

        width:
            48px;

        height:
            48px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            14px;

        color:
            #2563eb;

        background:
            #dbeafe;

        font-size:
            23px;
    }


    .dokumen-overview-content {

        position:
            relative;

        z-index:
            2;
    }


    .dokumen-overview-label {

        color:
            #64748b;

        font-size:
            10px;

        font-weight:
            800;

        letter-spacing:
            .07em;

        text-transform:
            uppercase;
    }


    .dokumen-overview-value {

        margin-top:
            4px;

        color:
            #0f172a;

        font-size:
            21px;

        font-weight:
            800;
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .dokumen-section {

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


    .dokumen-section-header {

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


    .dokumen-section-kicker {

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


    .dokumen-section-title {

        margin:
            0;

        color:
            #0f172a;

        font-size:
            20px;

        font-weight:
            800;
    }


    .dokumen-section-total {

        text-align:
            right;
    }


    .dokumen-section-total-label {

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


    .dokumen-section-total-value {

        margin-top:
            3px;

        color:
            #0f172a;

        font-size:
            18px;

        font-weight:
            800;
    }


    /* =========================================================
       GRID DOKUMEN
    ========================================================= */

    .dokumen-grid {

        display:
            grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            16px;

        padding:
            22px;
    }


    /* =========================================================
       CARD DOKUMEN
    ========================================================= */

    .dokumen-card {

        position:
            relative;

        overflow:
            hidden;

        display:
            flex;

        flex-direction:
            column;

        min-height:
            235px;

        padding:
            20px;

        border:
            1px solid #e2e8f0;

        border-radius:
            17px;

        background:
            #fff;

        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }


    .dokumen-card::after {

        content:
            "";

        position:
            absolute;

        width:
            120px;

        height:
            120px;

        right:
            -65px;

        bottom:
            -65px;

        border-radius:
            50%;

        background:
            rgba(37,99,235,.035);

        transition:
            transform .35s ease;
    }


    .dokumen-card:hover {

        transform:
            translateY(-5px);

        border-color:
            #bfdbfe;

        box-shadow:
            0 16px 30px rgba(15,23,42,.09);
    }


    .dokumen-card:hover::after {

        transform:
            scale(1.35);
    }


    /* =========================================================
       CARD TOP
    ========================================================= */

    .dokumen-card-top {

        position:
            relative;

        z-index:
            2;

        display:
            flex;

        align-items:
            flex-start;

        justify-content:
            space-between;

        gap:
            15px;
    }


    .dokumen-pdf-icon {

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        flex:
            0 0 auto;

        width:
            46px;

        height:
            46px;

        border-radius:
            13px;

        color:
            #dc2626;

        background:
            #fee2e2;

        font-size:
            22px;

        transition:
            transform .28s ease;
    }


    .dokumen-card:hover
    .dokumen-pdf-icon {

        transform:
            translateY(-3px)
            scale(1.05);
    }


    .dokumen-category {

        display:
            inline-flex;

        align-items:
            center;

        min-height:
            25px;

        padding:
            5px 9px;

        border-radius:
            999px;

        color:
            #2563eb;

        background:
            #eff6ff;

        font-size:
            9px;

        font-weight:
            800;

        letter-spacing:
            .06em;

        text-transform:
            uppercase;
    }


    /* =========================================================
       CARD CONTENT
    ========================================================= */

    .dokumen-card-content {

        position:
            relative;

        z-index:
            2;

        flex:
            1;

        margin-top:
            18px;
    }


    .dokumen-card-title {

        margin:
            0;

        color:
            #0f172a;

        font-size:
            15px;

        font-weight:
            800;

        line-height:
            1.5;
    }


    .dokumen-card-description {

        margin:
            8px 0 0;

        color:
            #64748b;

        font-size:
            12px;

        line-height:
            1.65;

        display:
            -webkit-box;

        -webkit-line-clamp:
            3;

        -webkit-box-orient:
            vertical;

        overflow:
            hidden;
    }


    .dokumen-card-description-empty {

        color:
            #94a3b8;

        font-style:
            italic;
    }


    /* =========================================================
       CARD FOOTER
    ========================================================= */

    .dokumen-card-footer {

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
            20px;

        padding-top:
            14px;

        border-top:
            1px solid #f1f5f9;
    }


    .dokumen-date {

        display:
            flex;

        align-items:
            center;

        gap:
            6px;

        color:
            #94a3b8;

        font-size:
            10px;

        font-weight:
            600;
    }


    .dokumen-date i {

        font-size:
            14px;

        color:
            #64748b;
    }


    .dokumen-button {

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        gap:
            7px;

        padding:
            9px 13px;

        border:
            1px solid #bfdbfe;

        border-radius:
            10px;

        color:
            #2563eb;

        background:
            #eff6ff;

        font-size:
            11px;

        font-weight:
            800;

        text-decoration:
            none;

        transition:
            background .2s ease,
            color .2s ease,
            transform .2s ease,
            border-color .2s ease;
    }


    .dokumen-button:hover {

        color:
            #fff;

        background:
            #2563eb;

        border-color:
            #2563eb;

        transform:
            translateY(-1px);
    }


    .dokumen-button i {

        font-size:
            15px;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .dokumen-empty {

        padding:
            60px 20px;

        text-align:
            center;
    }


    .dokumen-empty-icon {

        width:
            58px;

        height:
            58px;

        margin:
            0 auto 14px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            16px;

        color:
            #94a3b8;

        background:
            #f1f5f9;

        font-size:
            26px;
    }


    .dokumen-empty-title {

        color:
            #475569;

        font-size:
            15px;

        font-weight:
            800;
    }


    .dokumen-empty-text {

        max-width:
            430px;

        margin:
            6px auto 0;

        color:
            #94a3b8;

        font-size:
            12px;

        line-height:
            1.6;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .dokumen-page {

            width:
                calc(100% - 30px);
        }


        .dokumen-hero {

            padding:
                28px;
        }


        .dokumen-hero-grid {

            grid-template-columns:
                1fr;
        }


        .dokumen-year {

            width:
                100%;
        }


        .dokumen-grid {

            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .dokumen-page {

            width:
                calc(100% - 20px);

            padding:
                22px 0 50px;
        }


        .dokumen-hero {

            padding:
                24px 20px;

            border-radius:
                20px;
        }


        .dokumen-title {

            font-size:
                28px;
        }


        .dokumen-description {

            font-size:
                12px;
        }


        .dokumen-section-header {

            align-items:
                flex-start;

            flex-direction:
                column;

            padding:
                18px 17px;
        }


        .dokumen-section-total {

            text-align:
                left;
        }


        .dokumen-grid {

            padding:
                17px;
        }


        .dokumen-card {

            min-height:
                220px;

            padding:
                17px;
        }


        .dokumen-card-footer {

            align-items:
                flex-start;

            flex-direction:
                column;
        }


        .dokumen-button {

            width:
                100%;
        }

    }


    /* =========================================================
       REDUCE MOTION
    ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .dokumen-overview-card,
        .dokumen-overview-card::after,
        .dokumen-card,
        .dokumen-card::after,
        .dokumen-pdf-icon,
        .dokumen-button {

            transition:
                none !important;
        }

    }

</style>


<div class="dokumen-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="dokumen-hero">

        <div class="dokumen-hero-grid">

            <div>

                <p class="dokumen-kicker">
                    Transparansi Keuangan Desa
                </p>


                <h1 class="dokumen-title">
                    Dokumen Publikasi
                </h1>


                <p class="dokumen-description">

                    Dokumen publik Anggaran Pendapatan dan
                    Belanja Desa {{ $namaDesa }}
                    Tahun Anggaran {{ $year->tahun }}.

                    Dokumen yang tersedia dapat dibuka
                    dalam format PDF.

                </p>

            </div>


            <div class="dokumen-year">

                <div class="dokumen-year-label">
                    Tahun Anggaran
                </div>


                <div class="dokumen-year-value">
                    {{ $year->tahun }}
                </div>

            </div>

        </div>

    </section>



    {{-- =====================================================
         RINGKASAN
    ====================================================== --}}

    <div class="dokumen-overview">


        <div class="dokumen-overview-card">

            <div class="dokumen-overview-icon">

                <i class='bx bx-file-blank'></i>

            </div>


            <div class="dokumen-overview-content">

                <div class="dokumen-overview-label">

                    Dokumen Tersedia

                </div>


                <div class="dokumen-overview-value">

                    {{ $jumlahDokumen }}

                    <span
                        style="
                            font-size:12px;
                            font-weight:600;
                            color:#64748b;
                        "
                    >
                        Dokumen
                    </span>

                </div>

            </div>

        </div>



        <div class="dokumen-overview-card">

            <div class="dokumen-overview-icon">

                <i class='bx bx-calendar'></i>

            </div>


            <div class="dokumen-overview-content">

                <div class="dokumen-overview-label">

                    Tahun Publikasi

                </div>


                <div class="dokumen-overview-value">

                    {{ $year->tahun }}

                </div>

            </div>

        </div>

    </div>



    {{-- =====================================================
         DAFTAR DOKUMEN
    ====================================================== --}}

    <section class="dokumen-section">


        <div class="dokumen-section-header">

            <div>

                <p class="dokumen-section-kicker">

                    Dokumen APBDesa

                </p>


                <h2 class="dokumen-section-title">

                    Daftar Dokumen

                </h2>

            </div>


            <div class="dokumen-section-total">

                <div class="dokumen-section-total-label">

                    Dokumen Publik

                </div>


                <div class="dokumen-section-total-value">

                    {{ $jumlahDokumen }} Dokumen

                </div>

            </div>

        </div>



        @if($documents->isNotEmpty())

            <div class="dokumen-grid">


                @foreach($documents as $doc)

                    <article class="dokumen-card">


                        {{-- =================================================
                             TOP
                        ================================================== --}}

                        <div class="dokumen-card-top">


                            <div class="dokumen-pdf-icon">

                                <i class='bx bxs-file-pdf'></i>

                            </div>


                            <div class="dokumen-category">

                                {{ $doc->kategori }}

                            </div>

                        </div>



                        {{-- =================================================
                             CONTENT
                        ================================================== --}}

                        <div class="dokumen-card-content">


                            <h3 class="dokumen-card-title">

                                {{ $doc->judul }}

                            </h3>


                            @if($doc->deskripsi)

                                <p class="dokumen-card-description">

                                    {{ $doc->deskripsi }}

                                </p>

                            @else

                                <p
                                    class="
                                        dokumen-card-description
                                        dokumen-card-description-empty
                                    "
                                >

                                    Tidak ada deskripsi dokumen.

                                </p>

                            @endif

                        </div>



                        {{-- =================================================
                             FOOTER
                        ================================================== --}}

                        <div class="dokumen-card-footer">


                            <div class="dokumen-date">

                                <i class='bx bx-calendar'></i>

                                <span>

                                    {{ $formatTanggal(
                                        $doc->tanggal_publikasi
                                    ) }}

                                </span>

                            </div>


                            <a
                                href="{{ Storage::url($doc->file_path) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="dokumen-button"
                            >

                                <i class='bx bx-show'></i>

                                Lihat PDF

                            </a>

                        </div>


                    </article>

                @endforeach


            </div>

        @else

            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="dokumen-empty">


                <div class="dokumen-empty-icon">

                    <i class='bx bx-folder-open'></i>

                </div>


                <div class="dokumen-empty-title">

                    Belum Ada Dokumen

                </div>


                <div class="dokumen-empty-text">

                    Belum terdapat dokumen publikasi yang
                    tersedia untuk Tahun Anggaran
                    {{ $year->tahun }}.

                </div>


            </div>

        @endif


    </section>


</div>

@endsection