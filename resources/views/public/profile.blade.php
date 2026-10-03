@extends('layouts.public')

@section('title', 'Profil Desa')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATA DESA
    |--------------------------------------------------------------------------
    */

    $namaDesa = trim(
        $desa->nama ?? 'Desa'
    );

    $kecamatan = trim(
        $desa->kecamatan ?? ''
    );

    $kabupaten = trim(
        $desa->kabupaten ?? ''
    );

    $provinsi = trim(
        $desa->provinsi ?? ''
    );

    $alamat = trim(
        $desa->alamat ?? ''
    );

    $website = trim(
        $desa->website ?? ''
    );

    $email = trim(
        $desa->email ?? ''
    );

@endphp


<style>

    /* =========================================================
       WRAPPER
    ========================================================= */

    .profil-page {

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

    .profil-hero {

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


    .profil-hero::before {

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


    .profil-hero-grid {

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


    .profil-kicker {

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


    .profil-title {

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


    .profil-description {

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
       LOGO HERO
    ========================================================= */

    .profil-logo-box {

        width:
            160px;

        height:
            160px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        flex:
            0 0 160px;

        padding:
            18px;

        box-sizing:
            border-box;

        border:
            1px solid rgba(255,255,255,.15);

        border-radius:
            22px;

        background:
            rgba(255,255,255,.09);

        backdrop-filter:
            blur(12px);

        box-shadow:
            0 12px 30px rgba(0,0,0,.10);

        overflow:
            hidden;
    }


    /*
    |--------------------------------------------------------------------------
    | LOGO
    |--------------------------------------------------------------------------
    | Jangan menggunakan width:100% dan height:100%.
    | Ukuran otomatis + contain membuat lambang tetap utuh.
    */

    .profil-logo {

        display:
            block;

        width:
            auto;

        height:
            auto;

        max-width:
            118px;

        max-height:
            118px;

        object-fit:
            contain;

        object-position:
            center;

        border-radius:
            0;

        flex:
            0 0 auto;
    }


    .profil-logo-placeholder {

        width:
            100%;

        height:
            100%;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            15px;

        color:
            #93c5fd;

        background:
            rgba(255,255,255,.08);

        font-size:
            48px;
    }


    /* =========================================================
       IDENTITAS
    ========================================================= */

    .profil-section {

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


    .profil-section-header {

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


    .profil-section-kicker {

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


    .profil-section-title {

        margin:
            0;

        color:
            #0f172a;

        font-size:
            20px;

        font-weight:
            800;
    }


    /* =========================================================
       IDENTITAS GRID
    ========================================================= */

    .profil-info-grid {

        display:
            grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            0;

        padding:
            8px 23px;
    }


    .profil-info-item {

        padding:
            18px 4px;

        border-bottom:
            1px solid #f1f5f9;
    }


    .profil-info-item:nth-last-child(-n + 2) {

        border-bottom:
            0;
    }


    .profil-info-label {

        display:
            flex;

        align-items:
            center;

        gap:
            7px;

        color:
            #94a3b8;

        font-size:
            10px;

        font-weight:
            800;

        letter-spacing:
            .07em;

        text-transform:
            uppercase;
    }


    .profil-info-label i {

        color:
            #2563eb;

        font-size:
            15px;
    }


    .profil-info-value {

        margin-top:
            7px;

        color:
            #334155;

        font-size:
            13px;

        font-weight:
            600;

        line-height:
            1.6;

        word-break:
            break-word;
    }


    /* =========================================================
       ALAMAT
    ========================================================= */

    .profil-address {

        margin:
            0 23px;

        padding:
            18px 4px 22px;

        border-top:
            1px solid #f1f5f9;
    }


    .profil-address-label {

        display:
            flex;

        align-items:
            center;

        gap:
            7px;

        color:
            #94a3b8;

        font-size:
            10px;

        font-weight:
            800;

        letter-spacing:
            .07em;

        text-transform:
            uppercase;
    }


    .profil-address-label i {

        color:
            #2563eb;

        font-size:
            15px;
    }


    .profil-address-value {

        margin-top:
            8px;

        color:
            #334155;

        font-size:
            13px;

        font-weight:
            600;

        line-height:
            1.7;
    }


    /* =========================================================
       KONTAK
    ========================================================= */

    .profil-contact-grid {

        display:
            grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap:
            16px;

        padding:
            22px 23px;
    }


    .profil-contact-card {

        position:
            relative;

        overflow:
            hidden;

        display:
            flex;

        align-items:
            center;

        gap:
            14px;

        padding:
            18px;

        border:
            1px solid #e2e8f0;

        border-radius:
            16px;

        background:
            #f8fafc;

        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease,
            background .28s ease;
    }


    .profil-contact-card::after {

        content:
            "";

        position:
            absolute;

        width:
            90px;

        height:
            90px;

        right:
            -45px;

        bottom:
            -45px;

        border-radius:
            50%;

        background:
            rgba(37,99,235,.04);

        transition:
            transform .35s ease;
    }


    .profil-contact-card:hover {

        transform:
            translateY(-4px);

        border-color:
            #bfdbfe;

        background:
            #fff;

        box-shadow:
            0 12px 25px rgba(15,23,42,.07);
    }


    .profil-contact-card:hover::after {

        transform:
            scale(1.4);
    }


    .profil-contact-icon {

        position:
            relative;

        z-index:
            2;

        width:
            44px;

        height:
            44px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        flex:
            0 0 auto;

        border-radius:
            12px;

        color:
            #2563eb;

        background:
            #dbeafe;

        font-size:
            21px;
    }


    .profil-contact-content {

        position:
            relative;

        z-index:
            2;

        min-width:
            0;
    }


    .profil-contact-label {

        color:
            #94a3b8;

        font-size:
            9px;

        font-weight:
            800;

        letter-spacing:
            .08em;

        text-transform:
            uppercase;
    }


    .profil-contact-value {

        margin-top:
            4px;

        color:
            #334155;

        font-size:
            12px;

        font-weight:
            700;

        line-height:
            1.5;

        word-break:
            break-word;
    }


    .profil-contact-value a {

        color:
            #2563eb;

        text-decoration:
            none;
    }


    .profil-contact-value a:hover {

        text-decoration:
            underline;
    }


    /* =========================================================
       LOKASI WILAYAH
    ========================================================= */

    .profil-location {

        display:
            grid;

        grid-template-columns:
            repeat(3, minmax(0, 1fr));

        gap:
            14px;

        padding:
            22px 23px;
    }


    .profil-location-item {

        padding:
            16px;

        border:
            1px solid #e2e8f0;

        border-radius:
            15px;

        background:
            #fff;

        transition:
            transform .25s ease,
            box-shadow .25s ease,
            border-color .25s ease;
    }


    .profil-location-item:hover {

        transform:
            translateY(-3px);

        border-color:
            #bfdbfe;

        box-shadow:
            0 9px 20px rgba(15,23,42,.06);
    }


    .profil-location-label {

        color:
            #94a3b8;

        font-size:
            9px;

        font-weight:
            800;

        letter-spacing:
            .08em;

        text-transform:
            uppercase;
    }


    .profil-location-value {

        margin-top:
            6px;

        color:
            #334155;

        font-size:
            12px;

        font-weight:
            700;

        line-height:
            1.5;
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .profil-empty {

        color:
            #94a3b8;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .profil-page {

            width:
                calc(100% - 30px);
        }


        .profil-hero {

            padding:
                28px;
        }


        .profil-hero-grid {

            grid-template-columns:
                1fr;
        }


        .profil-logo-box {

            width:
                120px;

            height:
                120px;

            flex:
                0 0 120px;

            padding:
                14px;
        }


        .profil-logo {

            max-width:
                90px;

            max-height:
                90px;
        }


        .profil-location {

            grid-template-columns:
                1fr;
        }

    }


    @media (max-width: 650px) {

        .profil-page {

            width:
                calc(100% - 20px);

            padding:
                22px 0 50px;
        }


        .profil-hero {

            padding:
                24px 20px;

            border-radius:
                20px;
        }


        .profil-title {

            font-size:
                28px;
        }


        .profil-description {

            font-size:
                12px;
        }


        .profil-logo-box {

            width:
                100px;

            height:
                100px;

            flex:
                0 0 100px;

            padding:
                12px;

            border-radius:
                17px;
        }


        .profil-logo {

            max-width:
                76px;

            max-height:
                76px;
        }


        .profil-logo-placeholder {

            font-size:
                32px;
        }


        .profil-section-header {

            padding:
                18px 17px;
        }


        .profil-info-grid {

            grid-template-columns:
                1fr;

            padding:
                5px 17px;
        }


        .profil-info-item {

            padding:
                15px 2px;
        }


        .profil-info-item:nth-last-child(-n + 2) {

            border-bottom:
                1px solid #f1f5f9;
        }


        .profil-info-item:last-child {

            border-bottom:
                0;
        }


        .profil-address {

            margin:
                0 17px;

            padding:
                17px 2px 20px;
        }


        .profil-contact-grid {

            grid-template-columns:
                1fr;

            padding:
                17px;
        }


        .profil-location {

            padding:
                17px;
        }

    }


    /* =========================================================
       REDUCE MOTION
    ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        .profil-contact-card,
        .profil-contact-card::after,
        .profil-location-item {

            transition:
                none !important;
        }

    }

</style>


<div class="profil-page">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="profil-hero">

        <div class="profil-hero-grid">


            <div>

                <p class="profil-kicker">
                    Informasi Pemerintah Desa
                </p>


                <h1 class="profil-title">
                    Profil {{ $namaDesa }}
                </h1>


                <p class="profil-description">

                    Informasi identitas dan kontak
                    Pemerintah {{ $namaDesa }} yang
                    tersedia dalam publikasi e-APBDesa.

                </p>

            </div>


            {{-- =================================================
                 LOGO DESA
            ================================================== --}}

            <div class="profil-logo-box">

                @if(!empty($desa->logo))

                    <img
                        src="{{ Storage::url($desa->logo) }}"
                        alt="Logo {{ $namaDesa }}"
                        class="profil-logo"
                    >

                @else

                    <div class="profil-logo-placeholder">

                        <i class='bx bx-buildings'></i>

                    </div>

                @endif

            </div>


        </div>

    </section>



    {{-- =====================================================
         IDENTITAS DESA
    ====================================================== --}}

    <section class="profil-section">


        <div class="profil-section-header">

            <p class="profil-section-kicker">
                Identitas Desa
            </p>


            <h2 class="profil-section-title">
                Informasi Desa
            </h2>

        </div>



        <div class="profil-info-grid">


            {{-- NAMA DESA --}}

            <div class="profil-info-item">

                <div class="profil-info-label">

                    <i class='bx bx-buildings'></i>

                    Nama Desa

                </div>


                <div class="profil-info-value">

                    {{ $namaDesa ?: 'Belum diatur' }}

                </div>

            </div>



            {{-- KECAMATAN --}}

            <div class="profil-info-item">

                <div class="profil-info-label">

                    <i class='bx bx-map'></i>

                    Kecamatan

                </div>


                <div class="profil-info-value">

                    {{ $kecamatan ?: 'Belum diatur' }}

                </div>

            </div>



            {{-- KABUPATEN --}}

            <div class="profil-info-item">

                <div class="profil-info-label">

                    <i class='bx bx-map-pin'></i>

                    Kabupaten

                </div>


                <div class="profil-info-value">

                    {{ $kabupaten ?: 'Belum diatur' }}

                </div>

            </div>



            {{-- PROVINSI --}}

            <div class="profil-info-item">

                <div class="profil-info-label">

                    <i class='bx bx-globe'></i>

                    Provinsi

                </div>


                <div class="profil-info-value">

                    {{ $provinsi ?: 'Belum diatur' }}

                </div>

            </div>


        </div>



        {{-- ALAMAT --}}

        <div class="profil-address">

            <div class="profil-address-label">

                <i class='bx bx-current-location'></i>

                Alamat

            </div>


            <div class="profil-address-value">

                @if($alamat)

                    {{ $alamat }}

                @else

                    <span class="profil-empty">
                        Alamat belum diatur.
                    </span>

                @endif

            </div>

        </div>


    </section>



    {{-- =====================================================
         KONTAK
    ====================================================== --}}

    <section class="profil-section">


        <div class="profil-section-header">

            <p class="profil-section-kicker">
                Informasi Kontak
            </p>


            <h2 class="profil-section-title">
                Hubungi Pemerintah Desa
            </h2>

        </div>



        <div class="profil-contact-grid">


            {{-- WEBSITE --}}

            <div class="profil-contact-card">

                <div class="profil-contact-icon">

                    <i class='bx bx-globe'></i>

                </div>


                <div class="profil-contact-content">

                    <div class="profil-contact-label">
                        Website
                    </div>


                    <div class="profil-contact-value">

                        @if($website)

                            <a
                                href="{{ $website }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >

                                {{ $website }}

                            </a>

                        @else

                            <span class="profil-empty">
                                Belum diatur
                            </span>

                        @endif

                    </div>

                </div>

            </div>



            {{-- EMAIL --}}

            <div class="profil-contact-card">

                <div class="profil-contact-icon">

                    <i class='bx bx-envelope'></i>

                </div>


                <div class="profil-contact-content">

                    <div class="profil-contact-label">
                        Email
                    </div>


                    <div class="profil-contact-value">

                        @if($email)

                            <a
                                href="mailto:{{ $email }}"
                            >

                                {{ $email }}

                            </a>

                        @else

                            <span class="profil-empty">
                                Belum diatur
                            </span>

                        @endif

                    </div>

                </div>

            </div>


        </div>


    </section>



    {{-- =====================================================
         WILAYAH ADMINISTRATIF
    ====================================================== --}}

    <section class="profil-section">


        <div class="profil-section-header">

            <p class="profil-section-kicker">
                Wilayah Administratif
            </p>


            <h2 class="profil-section-title">
                Kedudukan Desa
            </h2>

        </div>



        <div class="profil-location">


            <div class="profil-location-item">

                <div class="profil-location-label">
                    Desa
                </div>


                <div class="profil-location-value">

                    {{ $namaDesa ?: 'Belum diatur' }}

                </div>

            </div>



            <div class="profil-location-item">

                <div class="profil-location-label">
                    Kecamatan
                </div>


                <div class="profil-location-value">

                    {{ $kecamatan ?: 'Belum diatur' }}

                </div>

            </div>



            <div class="profil-location-item">

                <div class="profil-location-label">
                    Kabupaten
                </div>


                <div class="profil-location-value">

                    {{ $kabupaten ?: 'Belum diatur' }}

                </div>

            </div>


        </div>


    </section>


</div>

@endsection