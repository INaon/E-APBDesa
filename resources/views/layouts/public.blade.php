<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'e-APBDesa') - Desa Sumber Jaya
    </title>

    <meta
        name="description"
        content="Publikasi APB Desa Sumber Jaya"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;

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
        }


        /* =====================================================
           HEADER
        ===================================================== */

        .eapb-header {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            padding: 16px 6%;

            display: flex;

            justify-content: space-between;
            align-items: center;

            background: rgba(15, 23, 42, .72);

            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);

            border-bottom:
                1px solid rgba(255,255,255,.15);

            box-shadow:
                0 8px 30px rgba(15, 23, 42, .15);

            z-index: 1000;

            overflow: hidden;
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

            transition: .7s;
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
        }


        .eapb-logo-icon {

            width: 44px;
            height: 44px;

            display: flex;

            align-items: center;
            justify-content: center;

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
        }


        .eapb-logo-title {

            font-size: 20px;

            font-weight: 700;

            letter-spacing: .2px;
        }


        .eapb-logo-subtitle {

            margin-top: 3px;

            font-size: 10px;

            font-weight: 400;

            color:
                rgba(255,255,255,.68);

            text-transform: uppercase;

            letter-spacing: 1px;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        .eapb-navbar {

            display: flex;

            align-items: center;

            gap: 5px;

            position: relative;

            z-index: 2;
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

            transition: .3s;
        }


        .eapb-navbar a:hover {

            color: white;

            background:
                rgba(255,255,255,.12);
        }


        .eapb-navbar a.active {

            color: white;

            background:
                rgba(255,255,255,.15);
        }


        .eapb-navbar a.active::after {

            content: "";

            position: absolute;

            bottom: 4px;

            left: 14px;
            right: 14px;

            height: 2px;

            border-radius: 99px;

            background: #60a5fa;
        }


        /* =====================================================
           LOGIN / ADMIN
        ===================================================== */

        .eapb-login {

            margin-left: 8px !important;

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
           MOBILE MENU
        ===================================================== */

        #eapb-menu-icon {

            display: none;

            color: white;

            font-size: 34px;

            cursor: pointer;

            z-index: 1002;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .eapb-content {

            min-height: 100vh;

            padding-top: 92px;
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        .eapb-footer {

            margin-top: 50px;

            padding: 35px 6%;

            background: #0f172a;

            color:
                rgba(255,255,255,.75);
        }


        .eapb-footer-inner {

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

            max-width: 1200px;

            margin: 25px auto 0;

            padding-top: 20px;

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

                padding: 14px 4%;
            }


            .eapb-navbar a {

                padding: 9px 10px;

                font-size: 13px;
            }

        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 768px) {

            #eapb-menu-icon {

                display: block;
            }


            .eapb-navbar {

                position: absolute;

                top: 100%;
                left: 0;

                width: 100%;

                padding:
                    15px 5% 20px;

                display: none;

                flex-direction: column;

                align-items: stretch;

                gap: 4px;

                background:
                    rgba(15, 23, 42, .90);

                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);

                border-bottom:
                    1px solid rgba(255,255,255,.15);

                box-shadow:
                    0 15px 30px rgba(0,0,0,.15);
            }


            .eapb-navbar.active {

                display: flex;
            }


            .eapb-navbar a {

                width: 100%;

                padding: 13px 15px;

                font-size: 14px;
            }


            .eapb-navbar a.active::after {

                display: none;
            }


            .eapb-login {

                margin-left: 0 !important;

                margin-top: 5px;
            }


            .eapb-logo-subtitle {

                display: none;
            }


            .eapb-content {

                padding-top: 82px;
            }

        }


        /* =====================================================
           SMALL MOBILE
        ===================================================== */

        @media (max-width: 420px) {

            .eapb-logo-title {

                font-size: 17px;
            }


            .eapb-logo-icon {

                width: 40px;

                height: 40px;
            }

        }

    </style>

</head>


<body>


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <header class="eapb-header">


        {{-- LOGO --}}

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

                    Desa Sumber Jaya

                </span>

            </span>

        </a>


        {{-- MOBILE MENU BUTTON --}}

        <i
            class='bx bx-menu'
            id="eapb-menu-icon"
        ></i>


        {{-- =================================================
             NAVIGATION
        ================================================== --}}

        <nav
            class="eapb-navbar"
            id="eapb-navbar"
        >


            {{-- BERANDA --}}

            <a
                href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'active' : '' }}"
            >

                <i class='bx bx-home-alt'></i>

                <span>
                    Beranda
                </span>

            </a>


            {{-- APBDESA --}}

            <a
                href="{{ route('apbdesa', $year->tahun) }}"
                class="{{ request()->routeIs('apbdesa') ? 'active' : '' }}"
            >

                <i class='bx bx-wallet'></i>

                <span>
                    APBDesa
                </span>

            </a>


            {{-- REALISASI --}}

            <a
                href="{{ route('realisasi', $year->tahun) }}"
                class="{{ request()->routeIs('realisasi') ? 'active' : '' }}"
            >

                <i class='bx bx-line-chart'></i>

                <span>
                    Realisasi
                </span>

            </a>


            {{-- DOKUMEN --}}

            <a
                href="{{ route('dokumen', $year->tahun) }}"
                class="{{ request()->routeIs('dokumen') ? 'active' : '' }}"
            >

                <i class='bx bx-file'></i>

                <span>
                    Dokumen
                </span>

            </a>


            {{-- PROFIL DESA --}}

            <a
                href="{{ route('profil') }}"
                class="{{ request()->routeIs('profil') ? 'active' : '' }}"
            >

                <i class='bx bx-buildings'></i>

                <span>
                    Profil Desa
                </span>

            </a>


            {{-- LOGIN / ADMIN --}}

            @auth

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="eapb-login"
                >

                    <i class='bx bx-dashboard'></i>

                    <span>
                        Admin
                    </span>

                </a>

            @else

                <a
                    href="{{ route('login') }}"
                    class="eapb-login"
                >

                    <i class='bx bx-log-in'></i>

                    <span>
                        Login Admin
                    </span>

                </a>

            @endauth


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


            <div>

                <div class="eapb-footer-title">

                    e-APBDesa

                </div>


                <p>

                    Sistem Publikasi Anggaran Pendapatan
                    dan Belanja Desa.

                </p>

            </div>


            <div>

                <div class="eapb-footer-title">

                    Desa Sumber Jaya

                </div>


                <p>

                    Kecamatan Pelaihari<br>

                    Kabupaten Tanah Laut

                </p>

            </div>


        </div>


        <div class="eapb-footer-bottom">

            © {{ date('Y') }}

            Pemerintah Desa Sumber Jaya.

            Semua informasi APBDesa dipublikasikan
            untuk masyarakat.

        </div>


    </footer>


    {{-- =====================================================
         MOBILE MENU SCRIPT
    ====================================================== --}}

    <script>

        const menuIcon =
            document.querySelector('#eapb-menu-icon');

        const navbar =
            document.querySelector('#eapb-navbar');


        if (menuIcon && navbar) {

            menuIcon.addEventListener('click', function () {

                menuIcon.classList.toggle('bx-menu');

                menuIcon.classList.toggle('bx-x');

                navbar.classList.toggle('active');

            });

        }

    </script>


</body>

</html>