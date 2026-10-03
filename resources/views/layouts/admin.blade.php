@php
    $desa = $desa ?? \App\Models\Desa::first();
@endphp

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
        content="Panel Administrasi e-APBDesa Desa {{ $desa?->nama ?? 'Desa' }}"
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
        ====================================================== */

        .admin-app {
            min-height: 100vh;
            display: flex;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

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


        /* =====================================================
           LOGO
        ====================================================== */

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

            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 14px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb 0%,
                    #3b82f6 100%
                );

            border:
                1px solid rgba(255,255,255,.18);

            box-shadow:
                0 8px 20px rgba(37,99,235,.30);

            overflow: hidden;
        }


        .admin-brand-icon img {

            display: block;

            width: 100%;
            height: 100%;

            object-fit: contain;

            padding: 5px;
        }


        .admin-brand-icon i {

            font-size: 23px;

            color: white;
        }


        .admin-brand-text {

            min-width: 0;

            display: flex;
            flex-direction: column;

            line-height: 1.15;
        }


        .admin-brand-title {

            font-size: 18px;

            font-weight: 700;

            color: white;

            white-space: nowrap;
        }


        .admin-brand-subtitle {

            margin-top: 4px;

            font-size: 10px;

            color:
                rgba(255,255,255,.55);

            text-transform: uppercase;

            letter-spacing: 1px;

            white-space: nowrap;
        }


        /* =====================================================
           MENU
        ====================================================== */

        .admin-nav {

            flex: 1;

            padding: 24px 16px;

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


        /* =====================================================
           MAIN
        ====================================================== */

        .admin-main {

            width: calc(100% - 280px);

            margin-left: 280px;

            min-height: 100vh;
        }


        /* =====================================================
           TOPBAR
        ====================================================== */

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


        /* =====================================================
           TOPBAR RIGHT
        ====================================================== */

        .admin-topbar-right {

            display: flex;

            align-items: center;

            gap: 10px;
        }


        /* =====================================================
           PUBLIC LINK
        ====================================================== */

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
           ADMIN ACCOUNT
        ====================================================== */

        .admin-account {

            position: relative;
        }


        .admin-account-button {

            height: 42px;

            display: flex;

            align-items: center;

            gap: 9px;

            padding: 4px 10px 4px 5px;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            background: white;

            color: #334155;

            font-family: inherit;

            cursor: pointer;

            transition: .25s;
        }


        .admin-account-button:hover {

            border-color: #cbd5e1;

            background: #f8fafc;
        }


        .admin-account-avatar {

            width: 32px;
            height: 32px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #3b82f6
                );

            color: white;

            font-size: 14px;

            font-weight: 700;
        }


        .admin-account-info {

            display: flex;

            flex-direction: column;

            align-items: flex-start;

            line-height: 1.15;
        }


        .admin-account-name {

            max-width: 130px;

            overflow: hidden;

            text-overflow: ellipsis;

            white-space: nowrap;

            color: #0f172a;

            font-size: 11px;

            font-weight: 700;
        }


        .admin-account-role {

            margin-top: 3px;

            color: #94a3b8;

            font-size: 9px;
        }


        .admin-account-chevron {

            margin-left: 2px;

            color: #94a3b8;

            font-size: 16px;

            transition: .25s;
        }


        .admin-account.open .admin-account-chevron {

            transform: rotate(180deg);
        }


        /* =====================================================
           ACCOUNT DROPDOWN
        ====================================================== */

        .admin-account-menu {

            position: absolute;

            top: calc(100% + 10px);

            right: 0;

            width: 245px;

            padding: 8px;

            background: white;

            border: 1px solid #e2e8f0;

            border-radius: 16px;

            box-shadow:
                0 20px 45px rgba(15,23,42,.14);

            opacity: 0;

            visibility: hidden;

            transform:
                translateY(-6px);

            transition:
                opacity .2s,
                transform .2s,
                visibility .2s;

            z-index: 500;
        }


        .admin-account.open .admin-account-menu {

            opacity: 1;

            visibility: visible;

            transform: translateY(0);
        }


        .admin-account-header {

            padding: 12px;

            border-radius: 11px;

            background: #f8fafc;
        }


        .admin-account-header-name {

            color: #0f172a;

            font-size: 12px;

            font-weight: 700;
        }


        .admin-account-header-email {

            margin-top: 3px;

            color: #94a3b8;

            font-size: 10px;

            word-break: break-word;
        }


        .admin-account-menu-divider {

            height: 1px;

            margin: 7px 0;

            background: #e2e8f0;
        }


        .admin-account-menu-link {

            width: 100%;

            display: flex;

            align-items: center;

            gap: 10px;

            padding: 10px 11px;

            border: 0;

            border-radius: 10px;

            background: transparent;

            color: #475569;

            text-decoration: none;

            font-family: inherit;

            font-size: 11px;

            font-weight: 500;

            cursor: pointer;

            transition: .2s;

            text-align: left;
        }


        .admin-account-menu-link i {

            width: 28px;
            height: 28px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: #f1f5f9;

            color: #64748b;

            font-size: 16px;
        }


        .admin-account-menu-link:hover {

            background: #f8fafc;

            color: #0f172a;
        }


        .admin-account-menu-link.logout:hover {

            background: #fef2f2;

            color: #dc2626;
        }


        .admin-account-menu-link.logout:hover i {

            background: #fee2e2;

            color: #dc2626;
        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .admin-content {

            padding: 34px;
        }


        /* =====================================================
           FLASH
        ====================================================== */

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
           MOBILE OVERLAY
        ====================================================== */

        .admin-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(2,6,23,.55);

            z-index: 900;
        }


        /* =====================================================
           MOBILE
        ====================================================== */

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


            .admin-account-info {

                display: none;
            }


            .admin-account-button {

                padding-right: 6px;
            }

        }


        /* =====================================================
           MOBILE SMALL
        ====================================================== */

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


            .admin-brand {

                padding: 0 18px;
            }


            .admin-brand-icon {

                width: 44px;
                height: 44px;
            }


            .admin-brand-title {

                font-size: 16px;
            }


            .admin-brand-subtitle {

                font-size: 9px;
            }


            .admin-topbar-right {

                gap: 6px;
            }


            .admin-account-menu {

                position: fixed;

                top: 65px;

                right: 12px;

                left: 12px;

                width: auto;
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

                @if($desa?->logo)

                    <img
                        src="{{ asset('storage/' . $desa->logo) }}"
                        alt="Logo {{ $desa->nama ?? 'Desa' }}"
                    >

                @else

                    <i class='bx bx-bar-chart-alt-2'></i>

                @endif

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


        {{-- =================================================
             NAVIGATION
        ================================================== --}}

        <nav class="admin-nav">


            <div class="admin-nav-label">
                Utama
            </div>


            {{-- Dashboard --}}

            <a
                href="{{ route('admin.dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
            >

                <i class='bx bx-grid-alt'></i>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- Pendapatan --}}

            <a
                href="{{ route('admin.pendapatan.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.pendapatan.*') ? 'active' : '' }}"
            >

                <i class='bx bx-trending-up'></i>

                <span>
                    Pendapatan
                </span>

            </a>


            {{-- Belanja --}}

            <a
                href="{{ route('admin.belanja.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.belanja.*') ? 'active' : '' }}"
            >

                <i class='bx bx-receipt'></i>

                <span>
                    Belanja
                </span>

            </a>


            {{-- Pembiayaan --}}

            <a
                href="{{ route('admin.pembiayaan.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.pembiayaan.*') ? 'active' : '' }}"
            >

                <i class='bx bx-transfer'></i>

                <span>
                    Pembiayaan
                </span>

            </a>


            {{-- Realisasi --}}

            <a
                href="{{ route('admin.realisasi.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.realisasi.*') ? 'active' : '' }}"
            >

                <i class='bx bx-line-chart'></i>

                <span>
                    Realisasi
                </span>

            </a>


            {{-- Dokumen --}}

            <div class="admin-nav-label mt-5">
                Dokumen Publikasi
            </div>


            <a
                href="{{ route('admin.dokumen.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dokumen.*') ? 'active' : '' }}"
            >

                <i class='bx bx-file'></i>

                <span>
                    Dokumen
                </span>

            </a>


            {{-- Pengaturan --}}

            <div class="admin-nav-label mt-5">
                Pengaturan
            </div>


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

    </aside>


    {{-- =====================================================
         MOBILE OVERLAY
    ====================================================== --}}

    <div
        class="admin-overlay"
        id="admin-overlay"
    ></div>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <main class="admin-main">


        {{-- =================================================
             TOPBAR
        ================================================== --}}

        <header class="admin-topbar">


            {{-- LEFT --}}

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


            {{-- RIGHT --}}

            <div class="admin-topbar-right">


                {{-- LIHAT PUBLIK --}}

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


                {{-- ACCOUNT --}}

                @auth

                    <div
                        class="admin-account"
                        id="admin-account"
                    >


                        {{-- ACCOUNT BUTTON --}}

                        <button
                            type="button"
                            class="admin-account-button"
                            id="admin-account-button"
                        >

                            <div class="admin-account-avatar">

                                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                            </div>


                            <div class="admin-account-info">

                                <div class="admin-account-name">

                                    {{ auth()->user()->name }}

                                </div>

                                <div class="admin-account-role">

                                    Administrator

                                </div>

                            </div>


                            <i class='bx bx-chevron-down admin-account-chevron'></i>

                        </button>


                        {{-- ACCOUNT MENU --}}

                        <div class="admin-account-menu">


                            <div class="admin-account-header">

                                <div class="admin-account-header-name">

                                    {{ auth()->user()->name }}

                                </div>

                                <div class="admin-account-header-email">

                                    {{ auth()->user()->email }}

                                </div>

                            </div>


                            <div class="admin-account-menu-divider"></div>


                            {{-- PROFIL AKUN --}}

                            @if(Route::has('profile.edit'))

                                <a
                                    href="{{ route('profile.edit') }}"
                                    class="admin-account-menu-link"
                                >

                                    <i class='bx bx-user'></i>

                                    <span>
                                        Profil Administrator
                                    </span>

                                </a>

                            @endif


                            {{-- LOGOUT --}}

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="admin-account-menu-link logout"
                                >

                                    <i class='bx bx-log-out'></i>

                                    <span>
                                        Keluar dari Sistem
                                    </span>

                                </button>

                            </form>


                        </div>

                    </div>

                @endauth


            </div>

        </header>


        {{-- =================================================
             CONTENT
        ================================================== --}}

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

    /* =====================================================
       SIDEBAR MOBILE
    ====================================================== */

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


    /* =====================================================
       ACCOUNT DROPDOWN
    ====================================================== */

    const adminAccount =
        document.getElementById('admin-account');

    const adminAccountButton =
        document.getElementById('admin-account-button');


    if (adminAccountButton && adminAccount) {

        adminAccountButton.addEventListener(
            'click',
            function(event) {

                event.stopPropagation();

                adminAccount.classList.toggle('open');

            }
        );

    }


    document.addEventListener(
        'click',
        function(event) {

            if (
                adminAccount &&
                !adminAccount.contains(event.target)
            ) {

                adminAccount.classList.remove('open');

            }

        }
    );

</script>


</body>

</html>