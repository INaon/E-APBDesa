<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Dashboard') - e-APBDesa
    </title>

    <meta
        name="description"
        content="Panel Administrasi e-APBDesa Desa Sumber Jaya"
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

            background: #f1f5f9;
        }


        /* =====================================================
           APP
        ===================================================== */

        .admin-app {
            min-height: 100vh;

            display: flex;
        }


        /* =====================================================
           SIDEBAR
        ===================================================== */

        .admin-sidebar {

            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            width: 280px;

            display: flex;

            flex-direction: column;

            background:
                linear-gradient(
                    180deg,
                    #020617 0%,
                    #0f172a 100%
                );

            color: white;

            z-index: 1000;

            box-shadow:
                10px 0 35px rgba(15,23,42,.12);

            transition: .3s;
        }


        /* LOGO */

        .admin-brand {

            height: 82px;

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 0 24px;

            border-bottom:
                1px solid rgba(255,255,255,.08);
        }


        .admin-brand-icon {

            width: 44px;
            height: 44px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 8px 20px rgba(37,99,235,.3);

            font-size: 23px;
        }


        .admin-brand-text {

            display: flex;

            flex-direction: column;

            line-height: 1.15;
        }


        .admin-brand-title {

            font-size: 18px;

            font-weight: 700;
        }


        .admin-brand-subtitle {

            margin-top: 4px;

            font-size: 10px;

            color:
                rgba(255,255,255,.55);

            text-transform: uppercase;

            letter-spacing: 1px;
        }


        /* DESA INFO */

        .admin-village {

            padding: 24px;

            border-bottom:
                1px solid rgba(255,255,255,.08);
        }


        .admin-village-label {

            color:
                rgba(255,255,255,.42);

            font-size: 10px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: 1.2px;
        }


        .admin-village-name {

            margin-top: 7px;

            color: white;

            font-size: 14px;

            font-weight: 600;
        }


        .admin-village-desc {

            margin-top: 4px;

            color:
                rgba(255,255,255,.45);

            font-size: 11px;
        }


        /* MENU */

        .admin-nav {

            flex: 1;

            padding: 22px 16px;

            overflow-y: auto;
        }


        .admin-nav-label {

            padding: 0 14px;

            margin-bottom: 9px;

            color:
                rgba(255,255,255,.35);

            font-size: 10px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: 1.2px;
        }


        .admin-nav-link {

            position: relative;

            display: flex;

            align-items: center;

            gap: 12px;

            width: 100%;

            margin-bottom: 6px;

            padding: 12px 14px;

            color:
                rgba(255,255,255,.68);

            text-decoration: none;

            border-radius: 13px;

            font-size: 13px;

            font-weight: 500;

            transition: .25s;
        }


        .admin-nav-link i {

            width: 34px;
            height: 34px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background:
                rgba(255,255,255,.06);

            color:
                rgba(255,255,255,.65);

            font-size: 18px;

            transition: .25s;
        }


        .admin-nav-link:hover {

            color: white;

            background:
                rgba(255,255,255,.07);

            transform: translateX(2px);
        }


        .admin-nav-link:hover i {

            background:
                rgba(37,99,235,.2);

            color: #60a5fa;
        }


        .admin-nav-link.active {

            color: white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            box-shadow:
                0 8px 20px rgba(37,99,235,.22);
        }


        .admin-nav-link.active i {

            color: white;

            background:
                rgba(255,255,255,.14);
        }


        /* SIDEBAR BOTTOM */

        .admin-sidebar-bottom {

            padding: 16px;

            border-top:
                1px solid rgba(255,255,255,.08);
        }


        .admin-user-card {

            padding: 14px;

            border-radius: 14px;

            background:
                rgba(255,255,255,.05);

            border:
                1px solid rgba(255,255,255,.06);
        }


        .admin-user-name {

            color: white;

            font-size: 12px;

            font-weight: 600;
        }


        .admin-user-email {

            margin-top: 3px;

            color:
                rgba(255,255,255,.42);

            font-size: 10px;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        .admin-logout {

            width: 100%;

            margin-top: 10px;

            padding: 10px 12px;

            display: flex;

            align-items: center;

            gap: 10px;

            border: 0;

            border-radius: 11px;

            color:
                rgba(255,255,255,.65);

            background:
                rgba(255,255,255,.04);

            font-family: inherit;

            font-size: 12px;

            cursor: pointer;

            transition: .25s;
        }


        .admin-logout:hover {

            color: white;

            background:
                rgba(239,68,68,.16);
        }


        /* =====================================================
           MAIN
        ===================================================== */

        .admin-main {

            width: calc(100% - 280px);

            margin-left: 280px;

            min-height: 100vh;
        }


        /* =====================================================
           TOPBAR
        ===================================================== */

        .admin-topbar {

            position: sticky;

            top: 0;

            height: 82px;

            padding: 0 34px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            background:
                rgba(255,255,255,.88);

            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);

            border-bottom:
                1px solid #e2e8f0;

            z-index: 100;
        }


        .admin-topbar-left {

            display: flex;

            align-items: center;

            gap: 15px;
        }


        .admin-mobile-button {

            display: none;

            width: 42px;
            height: 42px;

            align-items: center;
            justify-content: center;

            border: 0;

            border-radius: 11px;

            background: #f1f5f9;

            color: #0f172a;

            font-size: 22px;

            cursor: pointer;
        }


        .admin-page-label {

            color: #94a3b8;

            font-size: 10px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: 1.2px;
        }


        .admin-page-title {

            margin-top: 3px;

            color: #0f172a;

            font-size: 19px;

            font-weight: 700;
        }


        .admin-public-link {

            display: inline-flex;

            align-items: center;

            gap: 7px;

            padding: 10px 15px;

            color: #334155;

            background: white;

            border: 1px solid #e2e8f0;

            border-radius: 11px;

            text-decoration: none;

            font-size: 12px;

            font-weight: 600;

            transition: .25s;
        }


        .admin-public-link:hover {

            color: #2563eb;

            border-color: #bfdbfe;

            background: #eff6ff;
        }


        /* =====================================================
           CONTENT
        ===================================================== */

        .admin-content {

            padding: 34px;
        }


        /* FLASH */

        .admin-alert {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 24px;

            padding: 13px 16px;

            border-radius: 13px;

            background: #eff6ff;

            border: 1px solid #bfdbfe;

            color: #1d4ed8;

            font-size: 12px;
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        .admin-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(2,6,23,.55);

            z-index: 900;
        }


        @media (max-width: 900px) {

            .admin-sidebar {

                transform: translateX(-100%);
            }


            .admin-sidebar.open {

                transform: translateX(0);
            }


            .admin-overlay.open {

                display: block;
            }


            .admin-main {

                width: 100%;

                margin-left: 0;
            }


            .admin-mobile-button {

                display: flex;
            }


            .admin-topbar {

                height: 72px;

                padding: 0 18px;
            }


            .admin-content {

                padding: 24px 18px;
            }

        }


        @media (max-width: 500px) {

            .admin-page-label {

                display: none;
            }


            .admin-page-title {

                font-size: 17px;
            }


            .admin-public-link span {

                display: none;
            }


            .admin-public-link {

                width: 40px;
                height: 40px;

                padding: 0;

                justify-content: center;
            }

        }

    </style>

</head>


<body>


<div class="admin-app">


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside
        class="admin-sidebar"
        id="admin-sidebar"
    >


        {{-- BRAND --}}

        <div class="admin-brand">

            <div class="admin-brand-icon">

                <i class='bx bx-bar-chart-alt-2'></i>

            </div>


            <div class="admin-brand-text">

                <div class="admin-brand-title">

                    e-APBDesa

                </div>


                <div class="admin-brand-subtitle">

                    Sistem Publikasi APBDesa

                </div>

            </div>

        </div>


        {{-- DESA --}}

        <div class="admin-village">

            <div class="admin-village-label">

                Pemerintah Desa

            </div>


            <div class="admin-village-name">

                Desa Sumber Jaya

            </div>


            <div class="admin-village-desc">

                Panel Administrasi

            </div>

        </div>


        {{-- NAVIGATION --}}

        <nav class="admin-nav">


            <div class="admin-nav-label">

                Utama

            </div>


            <a
                href="{{ route('admin.dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >

                <i class='bx bx-grid-alt'></i>

                <span>
                    Dashboard
                </span>

            </a>


            <a
                href="{{ route('admin.profile') }}"
                class="admin-nav-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}"
            >

                <i class='bx bx-buildings'></i>

                <span>
                    Profil Desa
                </span>

            </a>


            <a
                href="{{ route('admin.years') }}"
                class="admin-nav-link {{ request()->routeIs('admin.years*') ? 'active' : '' }}"
            >

                <i class='bx bx-calendar'></i>

                <span>
                    Tahun Anggaran
                </span>

            </a>


        </nav>


        {{-- BOTTOM --}}

        <div class="admin-sidebar-bottom">


            @auth

                <div class="admin-user-card">

                    <div class="admin-user-name">

                        {{ auth()->user()->name }}

                    </div>


                    <div class="admin-user-email">

                        {{ auth()->user()->email }}

                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="admin-logout"
                    >

                        <i class='bx bx-log-out'></i>

                        <span>
                            Keluar dari Sistem
                        </span>

                    </button>

                </form>

            @endauth

        </div>

    </aside>


    {{-- OVERLAY MOBILE --}}

    <div
        class="admin-overlay"
        id="admin-overlay"
    ></div>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <main class="admin-main">


        {{-- TOPBAR --}}

        <header class="admin-topbar">


            <div class="admin-topbar-left">


                <button
                    type="button"
                    class="admin-mobile-button"
                    id="admin-menu-button"
                >

                    <i class='bx bx-menu'></i>

                </button>


                <div>

                    <div class="admin-page-label">

                        Administrasi

                    </div>


                    <div class="admin-page-title">

                        @yield('title', 'Dashboard')

                    </div>

                </div>

            </div>


            <a
                href="{{ route('home') }}"
                class="admin-public-link"
                target="_blank"
            >

                <i class='bx bx-globe'></i>

                <span>
                    Lihat Publik
                </span>

            </a>


        </header>


        {{-- CONTENT --}}

        <div class="admin-content">


            @if(session('success'))

                <div class="admin-alert">

                    <i class='bx bx-check-circle'></i>

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            @endif


            @yield('content')


        </div>

    </main>

</div>


<script>

    const adminMenuButton =
        document.getElementById('admin-menu-button');

    const adminSidebar =
        document.getElementById('admin-sidebar');

    const adminOverlay =
        document.getElementById('admin-overlay');


    function toggleAdminMenu() {

        if (!adminSidebar || !adminOverlay) {
            return;
        }

        adminSidebar.classList.toggle('open');

        adminOverlay.classList.toggle('open');

    }


    if (adminMenuButton) {

        adminMenuButton.addEventListener(
            'click',
            toggleAdminMenu
        );

    }


    if (adminOverlay) {

        adminOverlay.addEventListener(
            'click',
            toggleAdminMenu
        );

    }


    document
        .querySelectorAll('.admin-nav-link')
        .forEach(function(link) {

            link.addEventListener('click', function() {

                if (window.innerWidth <= 900) {

                    adminSidebar.classList.remove('open');

                    adminOverlay.classList.remove('open');

                }

            });

        });

</script>


</body>

</html>