<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, viewport-fit=cover"
    >

    {{-- =====================================================
         DATA PROFIL DESA
    ====================================================== --}}

    @php

        $namaDesa = trim(
            $desa->nama ?? 'Profil Desa'
        );

        $namaDesaBersih = preg_replace(
            '/^\s*desa\s+/i',
            '',
            $namaDesa
        );

    @endphp


    <title>
        @yield('title', 'e-APBDesa') -
        {{ $namaDesa }}
    </title>


    <meta
        name="description"
        content="Publikasi APBDesa {{ $namaDesa }}"
    >


    {{-- =====================================================
         FONT
    ====================================================== --}}

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- =====================================================
         BOXICONS
    ====================================================== --}}

    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"
    >


    {{-- =====================================================
         VITE
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        /* =====================================================
           GLOBAL RESET
        ===================================================== */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }


        html {

            width: 100%;
            max-width: 100%;

            margin: 0;
            padding: 0;

            scroll-behavior: smooth;

            overflow-x: hidden;
        }


        body {

            width: 100%;
            max-width: 100%;

            min-height: 100vh;

            margin: 0;
            padding: 0;

            font-family: "Poppins", sans-serif;

            color: #172033;

            background:
                radial-gradient(
                    circle at top left,
                    rgba(37, 99, 235, .12),
                    transparent 35%
                ),
                radial-gradient(
                    circle at bottom right,
                    rgba(14, 165, 233, .10),
                    transparent 35%
                ),
                #f8fafc;

            overflow-x: hidden;
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .eapb-header {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;
            max-width: 100%;

            padding: 16px 6%;

            display: flex;

            justify-content: space-between;
            align-items: center;

            background:
                rgba(15, 23, 42, .72);

            backdrop-filter:
                blur(16px);

            -webkit-backdrop-filter:
                blur(16px);

            border-bottom:
                1px solid rgba(255,255,255,.15);

            box-shadow:
                0 8px 30px rgba(15, 23, 42, .15);

            z-index: 1000;

            overflow: visible;
        }


        .eapb-header::before {

            content: "";

            position: absolute;

            top: 0;
            left: -100%;

            width: 100%;
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(255,255,255,.12),
                    transparent
                );

            transition:
                .7s;

            pointer-events: none;
        }


        .eapb-header:hover::before {

            left: 100%;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .eapb-logo {

            position: relative;

            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

            text-decoration: none;

            z-index: 2;

            min-width: 0;
        }


        .eapb-logo-icon {

            width: 44px;
            height: 44px;

            display: flex;

            align-items: center;
            justify-content: center;

            flex: 0 0 44px;

            border-radius: 12px;

            background:
                rgba(255,255,255,.15);

            border:
                1px solid rgba(255,255,255,.2);

            font-size: 24px;
        }


        .eapb-logo-text {

            display: flex;

            flex-direction: column;

            line-height: 1.15;

            min-width: 0;
        }


        .eapb-logo-title {

            font-size: 20px;

            font-weight: 700;

            letter-spacing: .2px;

            white-space: nowrap;
        }


        .eapb-logo-subtitle {

            margin-top: 3px;

            font-size: 10px;

            font-weight: 400;

            color:
                rgba(255,255,255,.68);

            text-transform: uppercase;

            letter-spacing: 1px;

            max-width: 220px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .eapb-navbar {

            display: flex;

            align-items: center;

            gap: 5px;

            position: relative;

            z-index: 1001;

            min-width: 0;
        }


        .eapb-navbar a {

            position: relative;

            display: inline-flex;

            align-items: center;

            gap: 6px;

            padding: 10px 14px;

            color:
                rgba(255,255,255,.88);

            text-decoration: none;

            font-size: 14px;

            font-weight: 500;

            border-radius: 10px;

            transition:
                background .25s ease,
                color .25s ease,
                box-shadow .25s ease,
                transform .25s ease;
        }


        .eapb-navbar a:hover {

            color: white;

            background:
                rgba(255,255,255,.12);
        }


        /* =====================================================
           MENU AKTIF - DEFAULT
        ===================================================== */

        .eapb-navbar a.active {

            color: white;
        }


        .eapb-navbar a.active::after {

            content: "";

            position: absolute;

            bottom: 4px;

            left: 14px;
            right: 14px;

            height: 2px;

            border-radius: 99px;

            background:
                rgba(255,255,255,.85);
        }


        /* =====================================================
           BERANDA - BIRU
        ===================================================== */

        .eapb-navbar a.menu-home.active {

            background:
                rgba(37, 99, 235, .55);

            box-shadow:
                0 4px 14px rgba(37, 99, 235, .18);
        }


        .eapb-navbar a.menu-home.active::after {

            background:
                #60a5fa;
        }


        /* =====================================================
           APBDESA - BLUE
        ===================================================== */

        .eapb-navbar a.menu-apbdesa.active {

            background:
                rgba(30, 64, 175, .58);

            box-shadow:
                0 4px 14px rgba(30, 64, 175, .20);
        }


        .eapb-navbar a.menu-apbdesa.active::after {

            background:
                #93c5fd;
        }


        /* =====================================================
           PENDAPATAN - HIJAU
        ===================================================== */

        .eapb-navbar a.menu-pendapatan.active {

            background:
                rgba(22, 101, 52, .58);

            box-shadow:
                0 4px 14px rgba(22, 101, 52, .20);
        }


        .eapb-navbar a.menu-pendapatan.active::after {

            background:
                #86efac;
        }


        /* =====================================================
           BELANJA - DARK / HITAM
        ===================================================== */

        .eapb-navbar a.menu-belanja.active {

            background:
                rgba(15, 23, 42, .90);

            color:
                #ffffff;

            box-shadow:
                0 5px 16px rgba(0, 0, 0, .28);

            border:
                1px solid rgba(255,255,255,.10);
        }


        .eapb-navbar a.menu-belanja.active::after {

            background:
                #cbd5e1;
        }


        /* =====================================================
           PEMBIAYAAN - UNGU
        ===================================================== */

        .eapb-navbar a.menu-pembiayaan.active {

            background:
                rgba(109, 40, 217, .58);

            box-shadow:
                0 4px 14px rgba(109, 40, 217, .20);
        }


        .eapb-navbar a.menu-pembiayaan.active::after {

            background:
                #c4b5fd;
        }


        /* =====================================================
           REALISASI - CYAN
        ===================================================== */

        .eapb-navbar a.menu-realisasi.active {

            background:
                rgba(14, 116, 144, .58);

            box-shadow:
                0 4px 14px rgba(14, 116, 144, .20);
        }


        .eapb-navbar a.menu-realisasi.active::after {

            background:
                #67e8f9;
        }


        /* =====================================================
           DOKUMEN - ORANGE
        ===================================================== */

        .eapb-navbar a.menu-dokumen.active {

            background:
                rgba(154, 52, 18, .58);

            box-shadow:
                0 4px 14px rgba(154, 52, 18, .20);
        }


        .eapb-navbar a.menu-dokumen.active::after {

            background:
                #fdba74;
        }


        /* =====================================================
           PROFIL DESA - TEAL
        ===================================================== */

        .eapb-navbar a.menu-profil.active {

            background:
                rgba(15, 118, 110, .58);

            box-shadow:
                0 4px 14px rgba(15, 118, 110, .20);
        }


        .eapb-navbar a.menu-profil.active::after {

            background:
                #5eead4;
        }


        /* =====================================================
           LOGIN / ADMIN
        ===================================================== */

        .eapb-login {

            margin-left:
                8px !important;

            border:
                1px solid rgba(255,255,255,.25) !important;

            background:
                rgba(255,255,255,.12) !important;
        }


        .eapb-login:hover {

            background:
                rgba(255,255,255,.22) !important;
        }


        /* =====================================================
           MOBILE MENU BUTTON
        ===================================================== */

        #eapb-menu-icon {

            display: none;

            width: 42px;
            height: 42px;

            align-items: center;
            justify-content: center;

            color: white;

            font-size: 32px;

            cursor: pointer;

            z-index: 1003;

            flex-shrink: 0;

            user-select: none;

            -webkit-tap-highlight-color: transparent;

            border-radius: 10px;

            transition:
                background .25s ease,
                transform .25s ease;
        }


        #eapb-menu-icon:hover {

            background:
                rgba(255,255,255,.12);
        }


        #eapb-menu-icon:active {

            transform:
                scale(.92);
        }


        /* =====================================================
           CONTENT UTAMA
        ===================================================== */

        .eapb-content {

            width: 100%;
            max-width: 100%;

            min-width: 0;

            min-height: 100vh;

            /*
             * Navbar fixed memiliki tinggi sekitar 75-90px.
             * Tambahan ruang diberikan agar hero tidak mepet.
             */

            padding-top: 120px;

            overflow-x: hidden;
        }


        .eapb-content > * {

            max-width: 100%;

            min-width: 0;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .eapb-footer {

            width: 100%;
            max-width: 100%;

            margin-top: 50px;

            padding:
                35px 6%;

            background:
                #0f172a;

            color:
                rgba(255,255,255,.75);

            overflow-x: hidden;
        }


        .eapb-footer-inner {

            width: 100%;
            max-width: 1200px;

            margin: auto;

            display: flex;

            justify-content: space-between;

            gap: 30px;

            flex-wrap: wrap;
        }


        .eapb-footer-title {

            color: white;

            font-size: 18px;

            font-weight: 700;
        }


        .eapb-footer p {

            margin-top: 6px;

            font-size: 13px;

            line-height: 1.7;
        }


        .eapb-footer-bottom {

            width: 100%;
            max-width: 1200px;

            margin:
                25px auto 0;

            padding-top:
                20px;

            border-top:
                1px solid rgba(255,255,255,.1);

            font-size: 12px;

            color:
                rgba(255,255,255,.5);
        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 992px) {

            .eapb-header {

                padding:
                    14px 4%;
            }


            .eapb-navbar a {

                padding:
                    9px 10px;

                font-size:
                    13px;
            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 768px) {

            html,
            body {

                width: 100% !important;

                max-width: 100% !important;

                overflow-x: hidden !important;
            }


            .eapb-header {

                width: 100% !important;

                max-width: 100% !important;

                padding:
                    12px 5%;

                min-height:
                    68px;

                overflow:
                    visible;
            }


            .eapb-logo {

                max-width:
                    calc(100% - 52px);
            }


            #eapb-menu-icon {

                display:
                    flex;
            }


            /* =================================================
               MOBILE NAVBAR
            ================================================= */

            .eapb-navbar {

                position:
                    absolute;

                top:
                    100%;

                left:
                    0;

                width:
                    100%;

                max-width:
                    100%;

                padding:
                    15px 5% 20px;

                display:
                    none;

                flex-direction:
                    column;

                align-items:
                    stretch;

                gap:
                    4px;

                background:
                    rgba(15, 23, 42, .97);

                backdrop-filter:
                    blur(18px);

                -webkit-backdrop-filter:
                    blur(18px);

                border-bottom:
                    1px solid rgba(255,255,255,.15);

                box-shadow:
                    0 15px 30px rgba(0,0,0,.20);

                z-index:
                    1002;

                max-height:
                    calc(100vh - 68px);

                overflow-y:
                    auto;

                overflow-x:
                    hidden;
            }


            .eapb-navbar.active {

                display:
                    flex !important;
            }


            .eapb-navbar a {

                width:
                    100%;

                min-height:
                    46px;

                padding:
                    13px 15px;

                font-size:
                    14px;

                justify-content:
                    flex-start;

                color:
                    rgba(255,255,255,.92);
            }


            .eapb-navbar a:hover {

                background:
                    rgba(255,255,255,.12);
            }


            .eapb-navbar a.active::after {

                display:
                    none;
            }


            /* =================================================
               WARNA MENU AKTIF MOBILE
            ================================================= */

            .eapb-navbar a.menu-home.active {

                background:
                    rgba(37, 99, 235, .65);
            }


            .eapb-navbar a.menu-apbdesa.active {

                background:
                    rgba(30, 64, 175, .65);
            }


            .eapb-navbar a.menu-pendapatan.active {

                background:
                    rgba(22, 101, 52, .65);
            }


            .eapb-navbar a.menu-belanja.active {

                background:
                    rgba(15, 23, 42, .96);
            }


            .eapb-navbar a.menu-pembiayaan.active {

                background:
                    rgba(109, 40, 217, .65);
            }


            .eapb-navbar a.menu-realisasi.active {

                background:
                    rgba(14, 116, 144, .65);
            }


            .eapb-navbar a.menu-dokumen.active {

                background:
                    rgba(154, 52, 18, .65);
            }


            .eapb-navbar a.menu-profil.active {

                background:
                    rgba(15, 118, 110, .65);
            }


            .eapb-login {

                margin-left:
                    0 !important;

                margin-top:
                    5px;
            }


            .eapb-logo-subtitle {

                display:
                    none;
            }


            /* =================================================
               CONTENT MOBILE
            ================================================= */

            .eapb-content {

                width:
                    100% !important;

                max-width:
                    100% !important;

                min-width:
                    0 !important;

                padding-top:
                    92px;

                overflow-x:
                    hidden !important;
            }


            .eapb-content > * {

                width:
                    100%;

                max-width:
                    100%;

                min-width:
                    0;
            }


            /* =================================================
               FOOTER MOBILE
            ================================================= */

            .eapb-footer {

                width:
                    100% !important;

                max-width:
                    100% !important;

                padding:
                    28px 5%;

                overflow-x:
                    hidden;
            }


            .eapb-footer-inner {

                width:
                    100%;

                max-width:
                    100%;

                flex-direction:
                    column;

                gap:
                    20px;
            }


            .eapb-footer-bottom {

                width:
                    100%;

                max-width:
                    100%;

                overflow-wrap:
                    anywhere;

                word-break:
                    break-word;
            }

        }


        /* =====================================================
           SMALL MOBILE
        ===================================================== */

        @media (max-width: 420px) {

            .eapb-logo-title {

                font-size:
                    17px;
            }


            .eapb-logo-icon {

                width:
                    40px;

                height:
                    40px;

                flex-basis:
                    40px;
            }


            #eapb-menu-icon {

                width:
                    40px;

                height:
                    40px;

                font-size:
                    30px;
            }


            .eapb-content {

                padding-top:
                    88px;
            }

        }


        /* =====================================================
           REDUCED MOTION
        ===================================================== */

        @media (prefers-reduced-motion: reduce) {

            html {

                scroll-behavior:
                    auto;
            }


            * {

                transition:
                    none !important;
            }

        }

    </style>

</head>


<body>


    {{-- =====================================================
         HEADER
    ===================================================== --}}

    <header class="eapb-header">


        {{-- =================================================
             LOGO
        ================================================== --}}

        <a
            href="{{ route('home') }}"
            class="eapb-logo"
        >

            <span class="eapb-logo-icon">

                <i class='bx bx-bar-chart-alt-2'></i>

            </span>


            <span class="eapb-logo-text">

                <span class="eapb-logo-title">

                    e-APBDesa

                </span>


                <span class="eapb-logo-subtitle">

                    {{ $namaDesa }}

                </span>

            </span>

        </a>


        {{-- =================================================
             MOBILE MENU BUTTON
        ================================================== --}}

        <i
            class='bx bx-menu'
            id="eapb-menu-icon"
            role="button"
            aria-label="Buka menu"
            aria-expanded="false"
            tabindex="0"
        ></i>


        {{-- =================================================
             NAVIGATION
        ================================================== --}}

        <nav
            class="eapb-navbar"
            id="eapb-navbar"
        >


            {{-- =================================================
                 BERANDA
            ================================================== --}}

            <a
                href="{{ route('home') }}"
                class="menu-home {{ request()->routeIs('home') ? 'active' : '' }}"
            >

                <i class='bx bx-home-alt'></i>

                <span>
                    Beranda
                </span>

            </a>


            {{-- =================================================
                 APBDESA
            ================================================== --}}

            <a
                href="{{ route('apbdesa', $year->tahun) }}"
                class="menu-apbdesa {{ request()->routeIs('apbdesa') ? 'active' : '' }}"
            >

                <i class='bx bx-wallet'></i>

                <span>
                    APBDesa
                </span>

            </a>


            {{-- =================================================
                 PENDAPATAN
            ================================================== --}}

            <a
                href="{{ route('pendapatan', $year->tahun) }}"
                class="menu-pendapatan {{ request()->routeIs('pendapatan') ? 'active' : '' }}"
            >

                <i class='bx bx-trending-up'></i>

                <span>
                    Pendapatan
                </span>

            </a>


            {{-- =================================================
                 BELANJA
            ================================================== --}}

            <a
                href="{{ route('belanja', $year->tahun) }}"
                class="menu-belanja {{ request()->routeIs('belanja') ? 'active' : '' }}"
            >

                <i class='bx bx-receipt'></i>

                <span>
                    Belanja
                </span>

            </a>


            {{-- =================================================
                 PEMBIAYAAN
            ================================================== --}}

            <a
                href="{{ route('pembiayaan', $year->tahun) }}"
                class="menu-pembiayaan {{ request()->routeIs('pembiayaan') ? 'active' : '' }}"
            >

                <i class='bx bx-transfer'></i>

                <span>
                    Pembiayaan
                </span>

            </a>


            {{-- =================================================
                 REALISASI
            ================================================== --}}

            <a
                href="{{ route('realisasi', $year->tahun) }}"
                class="menu-realisasi {{ request()->routeIs('realisasi') ? 'active' : '' }}"
            >

                <i class='bx bx-line-chart'></i>

                <span>
                    Realisasi
                </span>

            </a>


            {{-- =================================================
                 DOKUMEN
            ================================================== --}}

            <a
                href="{{ route('dokumen', $year->tahun) }}"
                class="menu-dokumen {{ request()->routeIs('dokumen') ? 'active' : '' }}"
            >

                <i class='bx bx-file'></i>

                <span>
                    Dokumen
                </span>

            </a>


            {{-- =================================================
                 PROFIL DESA
            ================================================== --}}

            <a
                href="{{ route('profil') }}"
                class="menu-profil {{ request()->routeIs('profil') ? 'active' : '' }}"
            >

                <i class='bx bx-buildings'></i>

                <span>
                    Profil Desa
                </span>

            </a>


            {{-- =================================================
                 ADMIN
            ================================================== --}}

            <a
                href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}"
                class="eapb-login"
            >

                <i class='bx bx-user'></i>

                <span>
                    Admin
                </span>

            </a>


        </nav>

    </header>


    {{-- =====================================================
         CONTENT
    ====================================================== --}}

    <main class="eapb-content">

        @yield('content')

    </main>


    {{-- =====================================================
         FOOTER
    ====================================================== --}}

    <footer class="eapb-footer">

        <div class="eapb-footer-inner">


            {{-- =================================================
                 INFORMASI APLIKASI
            ================================================== --}}

            <div>

                <div class="eapb-footer-title">

                    e-APBDesa

                </div>


                <p>

                    Sistem Publikasi Anggaran Pendapatan
                    dan Belanja Desa.

                </p>

            </div>


            {{-- =================================================
                 PROFIL DESA
            ================================================== --}}

            <div>

                <div class="eapb-footer-title">

                    {{ $namaDesa }}

                </div>


                <p>

                    @if(!empty($desa->kecamatan))

                        Kecamatan {{ $desa->kecamatan }}

                    @endif


                    @if(!empty($desa->kabupaten))

                        <br>

                        Kabupaten {{ $desa->kabupaten }}

                    @endif


                    @if(!empty($desa->provinsi))

                        <br>

                        {{ $desa->provinsi }}

                    @endif

                </p>

            </div>

        </div>


        {{-- =================================================
             FOOTER BOTTOM
        ================================================== --}}

        <div class="eapb-footer-bottom">

            © {{ date('Y') }}

            Pemerintah {{ $namaDesa }}.

            Semua informasi APBDesa dipublikasikan
            untuk masyarakat.

        </div>

    </footer>


    {{-- =====================================================
         MOBILE MENU SCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const menuIcon =
                    document.getElementById('eapb-menu-icon');

                const navbar =
                    document.getElementById('eapb-navbar');


                if (!menuIcon || !navbar) {

                    return;

                }


                /* =================================================
                   BUKA MENU
                ================================================== */

                function openMenu() {

                    navbar.classList.add(
                        'active'
                    );


                    menuIcon.classList.remove(
                        'bx-menu'
                    );


                    menuIcon.classList.add(
                        'bx-x'
                    );


                    menuIcon.setAttribute(
                        'aria-expanded',
                        'true'
                    );


                    menuIcon.setAttribute(
                        'aria-label',
                        'Tutup menu'
                    );

                }


                /* =================================================
                   TUTUP MENU
                ================================================== */

                function closeMenu() {

                    navbar.classList.remove(
                        'active'
                    );


                    menuIcon.classList.remove(
                        'bx-x'
                    );


                    menuIcon.classList.add(
                        'bx-menu'
                    );


                    menuIcon.setAttribute(
                        'aria-expanded',
                        'false'
                    );


                    menuIcon.setAttribute(
                        'aria-label',
                        'Buka menu'
                    );

                }


                /* =================================================
                   TOGGLE MENU
                ================================================== */

                function toggleMenu() {

                    if (
                        navbar.classList.contains('active')
                    ) {

                        closeMenu();

                    } else {

                        openMenu();

                    }

                }


                /* =================================================
                   TOMBOL MENU MOBILE
                ================================================== */

                menuIcon.addEventListener(
                    'click',
                    function (event) {

                        event.preventDefault();

                        event.stopPropagation();

                        toggleMenu();

                    }
                );


                /* =================================================
                   KEYBOARD ENTER / SPACE
                ================================================== */

                menuIcon.addEventListener(
                    'keydown',
                    function (event) {

                        if (
                            event.key === 'Enter' ||
                            event.key === ' '
                        ) {

                            event.preventDefault();

                            event.stopPropagation();

                            toggleMenu();

                        }

                    }
                );


                /* =================================================
                   KLIK DI LUAR MENU
                ================================================== */

                document.addEventListener(
                    'click',
                    function (event) {

                        if (
                            navbar.classList.contains('active') &&
                            !navbar.contains(event.target) &&
                            !menuIcon.contains(event.target)
                        ) {

                            closeMenu();

                        }

                    }
                );


                /* =================================================
                   RESET SAAT KEMBALI KE DESKTOP
                ================================================== */

                window.addEventListener(
                    'resize',
                    function () {

                        if (
                            window.innerWidth > 768
                        ) {

                            closeMenu();

                        }

                    }
                );

            }
        );

    </script>


</body>

</html>