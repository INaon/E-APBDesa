@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<style>

    /* =====================================================
       ANIMASI KARTU UTAMA DASHBOARD
    ====================================================== */

    .dashboard-stat-card {
        position: relative;
        overflow: hidden;

        transition:
            transform .28s ease,
            box-shadow .28s ease,
            border-color .28s ease;
    }


    /* Saat mouse diarahkan ke kartu */

    @media (hover: hover) and (pointer: fine) {

        .dashboard-stat-card:hover {

            transform: translateY(-7px);

            box-shadow:
                0 18px 35px rgba(15, 23, 42, .14);
        }


        .dashboard-stat-card:hover .stat-icon {

            transform:
                translateY(-3px)
                scale(1.08);

            box-shadow:
                0 8px 18px rgba(15, 23, 42, .12);
        }


        .dashboard-stat-card:hover .stat-badge {

            transform: translateX(3px);
        }


        .dashboard-stat-card:hover .stat-value {

            transform: translateX(3px);
        }


        .dashboard-stat-card:hover .stat-progress {

            transform: scaleY(1.18);
        }


        .dashboard-stat-card:hover .stat-decoration {

            transform: scale(1.35);

            opacity: .9;
        }

    }


    /* =====================================================
       ICON
    ====================================================== */

    .dashboard-stat-card .stat-icon {

        transition:
            transform .3s ease,
            box-shadow .3s ease;
    }


    /* =====================================================
       BADGE
    ====================================================== */

    .dashboard-stat-card .stat-badge {

        transition:
            transform .3s ease;
    }


    /* =====================================================
       ANGKA
    ====================================================== */

    .dashboard-stat-card .stat-value {

        transition:
            transform .3s ease;
    }


    /* =====================================================
       PROGRESS
    ====================================================== */

    .dashboard-stat-card .stat-progress {

        transition:
            transform .35s ease;
    }


    /* =====================================================
       DEKORASI LINGKARAN
    ====================================================== */

    .dashboard-stat-card .stat-decoration {

        transition:
            transform .35s ease,
            opacity .35s ease;
    }


    /* =====================================================
       TOUCH DEVICE
    ====================================================== */

    @media (hover: none) {

        .dashboard-stat-card:active {

            transform: scale(.985);
        }

    }


    /* =====================================================
       REDUCED MOTION
    ====================================================== */

    @media (prefers-reduced-motion: reduce) {

        .dashboard-stat-card,
        .dashboard-stat-card .stat-icon,
        .dashboard-stat-card .stat-badge,
        .dashboard-stat-card .stat-value,
        .dashboard-stat-card .stat-progress,
        .dashboard-stat-card .stat-decoration {

            transition: none !important;
        }

    }

</style>


<div class="space-y-6">

    {{-- =====================================================
         HEADER DASHBOARD
    ====================================================== --}}

    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

        <div>

            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                Ringkasan APBDesa
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                {{ $desa->nama ?? 'Desa' }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Pantau ringkasan anggaran dan publikasi APBDesa secara cepat.
            </p>

        </div>


        {{-- TAHUN AKTIF --}}

        <div class="flex items-center gap-3">

            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100">

                        <i class="bx bx-calendar text-xl text-slate-600"></i>

                    </div>


                    <div>

                        <p class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                            Tahun Anggaran
                        </p>

                        <p class="mt-0.5 text-sm font-bold text-slate-900">
                            {{ $year?->tahun ?? 'Belum tersedia' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>


    @if($summary)

        {{-- =================================================
             MAIN FINANCIAL CARDS
        ================================================== --}}

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">


            {{-- =================================================
                 PENDAPATAN
            ================================================== --}}

            <div
                class="dashboard-stat-card group relative overflow-hidden rounded-2xl bg-slate-900 p-5 text-white shadow-sm"
            >

                {{-- Dekorasi --}}

                <div
                    class="stat-decoration absolute -right-8 -top-8 h-28 w-28 rounded-full bg-white/5"
                ></div>


                <div class="relative">

                    <div class="flex items-center justify-between">


                        {{-- ICON --}}

                        <div
                            class="stat-icon flex h-10 w-10 items-center justify-center rounded-xl bg-white/10"
                        >

                            <i class="bx bx-trending-up text-xl"></i>

                        </div>


                        {{-- BADGE --}}

                        <span
                            class="stat-badge rounded-full bg-white/10 px-2.5 py-1 text-[10px] font-semibold"
                        >
                            Pendapatan
                        </span>

                    </div>


                    <p class="mt-6 text-xs text-slate-400">
                        Anggaran Pendapatan
                    </p>


                    <p class="stat-value mt-1 text-2xl font-bold tracking-tight">

                        Rp {{ number_format($summary['income'], 0, ',', '.') }}

                    </p>


                    <div class="mt-4 flex items-center justify-between">

                        <span class="text-xs text-slate-400">
                            Realisasi
                        </span>

                        <span class="text-xs font-semibold text-white">

                            Rp {{ number_format($summary['incomeReal'], 0, ',', '.') }}

                        </span>

                    </div>


                    <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-white/10">

                        <div
                            class="stat-progress h-full rounded-full bg-white"
                            style="width: {{ min(100, max(0, $summary['incomeRate'])) }}%"
                        ></div>

                    </div>


                    <div class="mt-2 text-right text-[10px] text-slate-400">

                        {{ number_format($summary['incomeRate'], 1, ',', '.') }}% terealisasi

                    </div>

                </div>

            </div>


            {{-- =================================================
                 BELANJA
            ================================================== --}}

            <div
                class="dashboard-stat-card group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100"
            >

                <div class="flex items-center justify-between">


                    {{-- ICON --}}

                    <div
                        class="stat-icon flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50"
                    >

                        <i class="bx bx-receipt text-xl text-rose-600"></i>

                    </div>


                    {{-- BADGE --}}

                    <span
                        class="stat-badge rounded-full bg-rose-50 px-2.5 py-1 text-[10px] font-semibold text-rose-600"
                    >
                        Belanja
                    </span>

                </div>


                <p class="mt-6 text-xs text-slate-400">
                    Anggaran Belanja
                </p>


                <p class="stat-value mt-1 text-2xl font-bold tracking-tight text-slate-900">

                    Rp {{ number_format($summary['expense'], 0, ',', '.') }}

                </p>


                <div class="mt-4 flex items-center justify-between">

                    <span class="text-xs text-slate-400">
                        Realisasi
                    </span>

                    <span class="text-xs font-semibold text-slate-700">

                        Rp {{ number_format($summary['expenseReal'], 0, ',', '.') }}

                    </span>

                </div>


                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-100">

                    <div
                        class="stat-progress h-full rounded-full bg-rose-500"
                        style="width: {{ min(100, max(0, $summary['expenseRate'])) }}%"
                    ></div>

                </div>


                <div class="mt-2 text-right text-[10px] text-slate-400">

                    {{ number_format($summary['expenseRate'], 1, ',', '.') }}% terealisasi

                </div>

            </div>


            {{-- =================================================
                 PEMBIAYAAN
            ================================================== --}}

            <div
                class="dashboard-stat-card group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100"
            >

                <div class="flex items-center justify-between">


                    {{-- ICON --}}

                    <div
                        class="stat-icon flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50"
                    >

                        <i class="bx bx-transfer text-xl text-amber-600"></i>

                    </div>


                    {{-- BADGE --}}

                    <span
                        class="stat-badge rounded-full bg-amber-50 px-2.5 py-1 text-[10px] font-semibold text-amber-700"
                    >
                        Pembiayaan
                    </span>

                </div>


                <p class="mt-6 text-xs text-slate-400">
                    Pembiayaan Neto
                </p>


                <p class="stat-value mt-1 text-2xl font-bold tracking-tight text-slate-900">

                    Rp {{ number_format($summary['netFinancing'], 0, ',', '.') }}

                </p>


                <div class="mt-5 rounded-xl bg-slate-50 p-3">

                    <div class="flex items-center justify-between">

                        <span class="text-xs text-slate-500">
                            Surplus / Defisit
                        </span>

                        <span
                            class="text-xs font-bold {{ $summary['surplus'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}"
                        >

                            Rp {{ number_format($summary['surplus'], 0, ',', '.') }}

                        </span>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 DOKUMEN PUBLIKASI
            ================================================== --}}

            <div
                class="dashboard-stat-card group relative overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-100"
            >

                <div class="flex items-center justify-between">


                    {{-- ICON --}}

                    <div
                        class="stat-icon flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50"
                    >

                        <i class="bx bx-file text-xl text-blue-600"></i>

                    </div>


                    {{-- BADGE --}}

                    <span
                        class="stat-badge rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-semibold text-blue-600"
                    >
                        Publikasi
                    </span>

                </div>


                <p class="mt-6 text-xs text-slate-400">
                    Dokumen Dipublikasikan
                </p>


                <p class="stat-value mt-1 text-3xl font-bold tracking-tight text-slate-900">

                    {{ $publishedDocuments }}

                </p>


                <div class="mt-5 flex items-center gap-2 text-xs text-slate-500">

                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-50">

                        <i class="bx bx-check text-emerald-600"></i>

                    </span>

                    Dokumen tersedia untuk publik

                </div>

            </div>

        </div>


        {{-- =================================================
             ANALYTICS GRID
        ================================================== --}}

        <div class="grid gap-5 xl:grid-cols-3">


            {{-- =================================================
                 REALISASI
            ================================================== --}}

            <div
                class="xl:col-span-2 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100"
            >

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                            Performa Anggaran
                        </p>

                        <h2 class="mt-1 text-lg font-bold text-slate-900">
                            Anggaran vs Realisasi
                        </h2>

                    </div>


                    <div class="flex items-center gap-4 text-xs">

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-slate-900"></span>

                            Anggaran

                        </div>


                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>

                            Realisasi

                        </div>

                    </div>

                </div>


                {{-- BAR PENDAPATAN --}}

                <div class="mt-8">

                    <div class="flex items-end justify-between">

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Pendapatan
                            </p>

                            <p class="mt-1 text-xs text-slate-400">

                                Rp {{ number_format($summary['incomeReal'], 0, ',', '.') }}

                                dari

                                Rp {{ number_format($summary['income'], 0, ',', '.') }}

                            </p>

                        </div>


                        <span class="text-sm font-bold text-slate-900">

                            {{ number_format($summary['incomeRate'], 1, ',', '.') }}%

                        </span>

                    </div>


                    <div class="mt-3 h-4 overflow-hidden rounded-full bg-slate-100">

                        <div
                            class="h-full rounded-full bg-slate-900 transition-all"
                            style="width: {{ min(100, max(0, $summary['incomeRate'])) }}%"
                        ></div>

                    </div>

                </div>


                {{-- BAR BELANJA --}}

                <div class="mt-7">

                    <div class="flex items-end justify-between">

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Belanja
                            </p>

                            <p class="mt-1 text-xs text-slate-400">

                                Rp {{ number_format($summary['expenseReal'], 0, ',', '.') }}

                                dari

                                Rp {{ number_format($summary['expense'], 0, ',', '.') }}

                            </p>

                        </div>


                        <span class="text-sm font-bold text-rose-600">

                            {{ number_format($summary['expenseRate'], 1, ',', '.') }}%

                        </span>

                    </div>


                    <div class="mt-3 h-4 overflow-hidden rounded-full bg-slate-100">

                        <div
                            class="h-full rounded-full bg-rose-500 transition-all"
                            style="width: {{ min(100, max(0, $summary['expenseRate'])) }}%"
                        ></div>

                    </div>

                </div>


                {{-- NET FINANCING --}}

                <div class="mt-7">

                    <div class="flex items-end justify-between">

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                Pembiayaan Neto
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Saldo pembiayaan tahun berjalan
                            </p>

                        </div>


                        <span class="text-sm font-bold text-amber-600">

                            Rp {{ number_format($summary['netFinancing'], 0, ',', '.') }}

                        </span>

                    </div>


                    <div class="mt-3 h-4 overflow-hidden rounded-full bg-slate-100">

                        @php

                            $maxFinancial = max(
                                abs($summary['income']),
                                abs($summary['expense']),
                                abs($summary['netFinancing']),
                                1
                            );

                            $financingWidth = min(
                                100,
                                (abs($summary['netFinancing']) / $maxFinancial) * 100
                            );

                        @endphp


                        <div
                            class="h-full rounded-full bg-amber-500 transition-all"
                            style="width: {{ $financingWidth }}%"
                        ></div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 RINGKASAN
            ================================================== --}}

            <div
                class="rounded-2xl bg-slate-900 p-6 text-white shadow-sm"
            >

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Ringkasan
                    </p>

                    <h2 class="mt-1 text-lg font-bold">
                        Kondisi APBDesa
                    </h2>

                </div>


                <div class="mt-7 space-y-5">


                    {{-- PENDAPATAN --}}

                    <div>

                        <div class="flex items-center justify-between">

                            <span class="text-xs text-slate-400">
                                Realisasi Pendapatan
                            </span>

                            <span class="text-sm font-bold">

                                {{ number_format($summary['incomeRate'], 1, ',', '.') }}%

                            </span>

                        </div>


                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/10">

                            <div
                                class="h-full rounded-full bg-emerald-400"
                                style="width: {{ min(100, max(0, $summary['incomeRate'])) }}%"
                            ></div>

                        </div>

                    </div>


                    {{-- BELANJA --}}

                    <div>

                        <div class="flex items-center justify-between">

                            <span class="text-xs text-slate-400">
                                Realisasi Belanja
                            </span>

                            <span class="text-sm font-bold">

                                {{ number_format($summary['expenseRate'], 1, ',', '.') }}%

                            </span>

                        </div>


                        <div class="mt-2 h-2 overflow-hidden rounded-full bg-white/10">

                            <div
                                class="h-full rounded-full bg-rose-400"
                                style="width: {{ min(100, max(0, $summary['expenseRate'])) }}%"
                            ></div>

                        </div>

                    </div>


                    {{-- SURPLUS --}}

                    <div class="border-t border-white/10 pt-5">

                        <p class="text-xs text-slate-400">
                            Surplus / Defisit
                        </p>


                        <p
                            class="mt-2 text-2xl font-bold {{ $summary['surplus'] >= 0 ? 'text-emerald-400' : 'text-rose-400' }}"
                        >

                            Rp {{ number_format($summary['surplus'], 0, ',', '.') }}

                        </p>


                        <p class="mt-1 text-xs text-slate-500">
                            Pendapatan dikurangi Belanja
                        </p>

                    </div>


                    {{-- NET FINANCING --}}

                    <div class="border-t border-white/10 pt-5">

                        <p class="text-xs text-slate-400">
                            Pembiayaan Neto
                        </p>


                        <p class="mt-2 text-xl font-bold text-amber-400">

                            Rp {{ number_format($summary['netFinancing'], 0, ',', '.') }}

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             QUICK ACTIONS
        ================================================== --}}

        <div>

            <div class="mb-4 flex items-center justify-between">

                <div>

                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Akses Cepat
                    </p>

                    <h2 class="mt-1 text-lg font-bold text-slate-900">
                        Kelola Publikasi
                    </h2>

                </div>

            </div>


            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">

                @foreach([

                    'pendapatan' => [
                        'label' => 'Pendapatan',
                        'icon' => 'bx-trending-up',
                        'class' => 'bg-blue-50 text-blue-600',
                    ],

                    'belanja' => [
                        'label' => 'Belanja',
                        'icon' => 'bx-receipt',
                        'class' => 'bg-rose-50 text-rose-600',
                    ],

                    'pembiayaan' => [
                        'label' => 'Pembiayaan',
                        'icon' => 'bx-transfer',
                        'class' => 'bg-amber-50 text-amber-600',
                    ],

                    'realisasi' => [
                        'label' => 'Realisasi',
                        'icon' => 'bx-line-chart',
                        'class' => 'bg-emerald-50 text-emerald-600',
                    ],

                    'dokumen' => [
                        'label' => 'Dokumen',
                        'icon' => 'bx-file',
                        'class' => 'bg-violet-50 text-violet-600',
                    ],

                ] as $route => $item)

                    <a
                        href="{{ route('admin.' . $route . '.index') }}"
                        class="group flex items-center justify-between rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-0.5 hover:shadow-md"
                    >

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl {{ $item['class'] }}"
                            >

                                <i class="bx {{ $item['icon'] }} text-xl"></i>

                            </div>


                            <span class="text-sm font-semibold text-slate-700">

                                {{ $item['label'] }}

                            </span>

                        </div>


                        <i
                            class="bx bx-right-arrow-alt text-xl text-slate-300 transition group-hover:translate-x-1 group-hover:text-slate-600"
                        ></i>

                    </a>

                @endforeach

            </div>

        </div>


    @else

        {{-- =================================================
             EMPTY STATE
        ================================================== --}}

        <div
            class="rounded-2xl bg-white p-10 text-center shadow-sm ring-1 ring-slate-100"
        >

            <div
                class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100"
            >

                <i class="bx bx-bar-chart-alt-2 text-3xl text-slate-400"></i>

            </div>


            <h2 class="mt-5 text-lg font-bold text-slate-900">
                Tahun anggaran belum tersedia
            </h2>


            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">

                Tambahkan dan aktifkan tahun anggaran terlebih dahulu
                agar ringkasan APBDesa dapat ditampilkan.

            </p>


            <a
                href="{{ route('admin.years') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
            >

                <i class="bx bx-calendar"></i>

                Kelola Tahun Anggaran

            </a>

        </div>

    @endif

</div>

@endsection