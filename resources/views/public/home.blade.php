@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    $income = (float) ($summary['income'] ?? 0);
    $expense = (float) ($summary['expense'] ?? 0);

    $incomeReal = (float) ($summary['incomeReal'] ?? 0);
    $expenseReal = (float) ($summary['expenseReal'] ?? 0);

    $inflow = (float) ($summary['inflow'] ?? 0);
    $outflow = (float) ($summary['outflow'] ?? 0);

    $netFinancing = (float) ($summary['netFinancing'] ?? 0);
    $surplus = (float) ($summary['surplus'] ?? 0);

    $incomeRate = min(
        100,
        max(0, (float) ($summary['incomeRate'] ?? 0))
    );

    $expenseRate = min(
        100,
        max(0, (float) ($summary['expenseRate'] ?? 0))
    );

    $overallRate = min(
        100,
        max(0, (float) ($summary['overallRate'] ?? 0))
    );


    /*
    |--------------------------------------------------------------------------
    | NAMA DESA
    |--------------------------------------------------------------------------
    |
    | Menghindari hasil:
    | "Desa Desa Sumber Jaya"
    |
    */

    $namaDesa = trim($desa->nama ?? 'Sumber Jaya');

    $namaDesaBersih = preg_replace(
        '/^\s*desa\s+/i',
        '',
        $namaDesa
    );


    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */

    $formatRupiah = function ($value) {

        $value = (float) $value;

        if ($value < 0) {
            return '-Rp ' .
                number_format(
                    abs($value),
                    0,
                    ',',
                    '.'
                );
        }

        return 'Rp ' .
            number_format(
                $value,
                0,
                ',',
                '.'
            );
    };


    /*
    |--------------------------------------------------------------------------
    | FORMAT RINGKAS
    |--------------------------------------------------------------------------
    */

    $formatCompact = function ($value) {

        $value = abs((float) $value);

        if ($value >= 1000000000) {

            return 'Rp ' .
                number_format(
                    $value / 1000000000,
                    2,
                    ',',
                    '.'
                ) .
                ' M';
        }

        if ($value >= 1000000) {

            return 'Rp ' .
                number_format(
                    $value / 1000000,
                    2,
                    ',',
                    '.'
                ) .
                ' Jt';
        }

        if ($value >= 1000) {

            return 'Rp ' .
                number_format(
                    $value / 1000,
                    0,
                    ',',
                    '.'
                ) .
                ' Rb';
        }

        return 'Rp ' .
            number_format(
                $value,
                0,
                ',',
                '.'
            );
    };


    $surplusPositive = $surplus >= 0;

@endphp


<style>

/* =========================================================
   WRAPPER UTAMA
========================================================= */

.public-dashboard {
    width: min(
        calc(100% - 48px),
        1440px
    );

    margin-left: auto;
    margin-right: auto;

    padding-bottom: 80px;

    --navy: #0f172a;
    --navy-2: #172554;

    --blue: #2563eb;
    --blue-light: #eff6ff;

    --border: #e2e8f0;

    --text: #0f172a;
    --muted: #64748b;

    box-sizing: border-box;
}


/* =========================================================
   HERO
========================================================= */

.public-hero {

    position: relative;

    overflow: hidden;

    margin-top: 18px;
    margin-bottom: 36px;

    padding: 42px 44px;

    border-radius: 24px;

    background:
        radial-gradient(
            circle at 88% 12%,
            rgba(59,130,246,.30),
            transparent 28%
        ),
        radial-gradient(
            circle at 70% 100%,
            rgba(37,99,235,.18),
            transparent 30%
        ),
        linear-gradient(
            135deg,
            #0f172a 0%,
            #172554 55%,
            #1e3a8a 100%
        );

    color: #fff;

    box-shadow:
        0 22px 55px rgba(15,23,42,.16);
}


/* Lingkaran dekorasi */

.public-hero::before {

    content: "";

    position: absolute;

    width: 330px;
    height: 330px;

    right: -110px;
    top: -180px;

    border:
        1px solid rgba(255,255,255,.08);

    border-radius: 50%;
}


.public-hero::after {

    content: "";

    position: absolute;

    width: 470px;
    height: 470px;

    right: -190px;
    top: -240px;

    border:
        1px solid rgba(255,255,255,.05);

    border-radius: 50%;
}


/* Grid hero */

.hero-grid {

    position: relative;

    z-index: 2;

    display: grid;

    grid-template-columns:
        minmax(0, 1.35fr)
        minmax(300px, .65fr);

    gap: 42px;

    align-items: center;
}


/* Hero content */

.hero-content {
    max-width: 720px;
}


/* Badge */

.hero-badge {

    display: inline-flex;

    align-items: center;

    gap: 8px;

    padding: 8px 13px;

    margin-bottom: 17px;

    border:
        1px solid rgba(255,255,255,.13);

    border-radius: 999px;

    background:
        rgba(255,255,255,.07);

    backdrop-filter: blur(10px);

    font-size: 11px;

    font-weight: 700;
}


.hero-badge i {

    color: #93c5fd;

    font-size: 15px;
}


/* Judul */

.hero-title {

    margin: 0;

    max-width: 720px;

    font-size:
        clamp(34px, 4vw, 52px);

    line-height: 1.03;

    letter-spacing: -.045em;

    font-weight: 800;
}


.hero-title span {

    display: block;

    color: #93c5fd;
}


/* Deskripsi */

.hero-description {

    max-width: 650px;

    margin:
        18px 0 25px;

    color:
        rgba(255,255,255,.72);

    font-size: 14px;

    line-height: 1.75;
}


/* Tombol */

.hero-actions {

    display: flex;

    flex-wrap: wrap;

    gap: 10px;
}


.hero-btn {

    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    min-height: 43px;

    padding:
        0 17px;

    border-radius: 11px;

    text-decoration: none;

    font-size: 12px;

    font-weight: 700;

    transition:
        .25s ease;
}


.hero-btn-primary {

    color: #0f172a;

    background: #fff;

    box-shadow:
        0 8px 20px rgba(0,0,0,.12);
}


.hero-btn-primary:hover {

    transform:
        translateY(-2px);

    box-shadow:
        0 12px 26px rgba(0,0,0,.18);
}


.hero-btn-secondary {

    color: #fff;

    background:
        rgba(255,255,255,.07);

    border:
        1px solid rgba(255,255,255,.14);
}


.hero-btn-secondary:hover {

    background:
        rgba(255,255,255,.13);

    transform:
        translateY(-2px);
}

/* =========================================================
   HERO INTERACTIVE
========================================================= */

.public-hero {

    isolation: isolate;

    background-size:
        140% 140%;

    background-position:
        0% 50%;

    transform:
        translateY(0);

    transition:
        transform .45s cubic-bezier(.2,.8,.2,1),
        box-shadow .45s ease,
        background-position .7s ease,
        background .45s ease;
}


.public-hero::before,
.public-hero::after {

    transition:
        transform .65s cubic-bezier(.2,.8,.2,1),
        opacity .45s ease;
}


.hero-badge,
.hero-title,
.hero-description,
.hero-overview,
.hero-btn {

    transition:
        transform .4s cubic-bezier(.2,.8,.2,1),
        background .35s ease,
        border-color .35s ease,
        box-shadow .35s ease;
}


@media (hover: hover) and (pointer: fine) {

    .public-hero:hover {

        transform:
            translateY(-7px);

        background:
            radial-gradient(
                circle at 88% 12%,
                rgba(96,165,250,.42),
                transparent 30%
            ),
            radial-gradient(
                circle at 65% 100%,
                rgba(37,99,235,.30),
                transparent 34%
            ),
            linear-gradient(
                135deg,
                #0f172a 0%,
                #172554 45%,
                #1d4ed8 100%
            );

        background-position:
            100% 30%;

        box-shadow:
            0 30px 70px rgba(30,64,175,.27),
            0 10px 25px rgba(15,23,42,.10);
    }


    .public-hero:hover::before {

        transform:
            translate(-22px, 24px)
            scale(1.12);

        opacity:
            .95;
    }


    .public-hero:hover::after {

        transform:
            translate(-30px, 28px)
            scale(1.08);

        opacity:
            .9;
    }


    .public-hero:hover .hero-badge {

        transform:
            translateY(-3px);

        background:
            rgba(96,165,250,.14);

        border-color:
            rgba(147,197,253,.28);

        box-shadow:
            0 8px 20px rgba(0,0,0,.10);
    }


    .public-hero:hover .hero-title {

        transform:
            translateX(3px);
    }


    .public-hero:hover .hero-description {

        transform:
            translateX(2px);
    }


    .public-hero:hover .hero-overview {

        transform:
            translateY(-5px);

        border-color:
            rgba(147,197,253,.28);

        background:
            rgba(255,255,255,.12);

        box-shadow:
            0 18px 35px rgba(0,0,0,.12);
    }


    .public-hero:hover .hero-btn-primary {

        transform:
            translateY(-3px);
    }


    .public-hero:hover .hero-btn-secondary {

        transform:
            translateY(-3px);

        background:
            rgba(96,165,250,.15);

        border-color:
            rgba(147,197,253,.28);
    }

}


/* =========================================================
   EFEK KLIK
========================================================= */

.public-hero:active {

    transform:
        translateY(-2px)
        scale(.995);
}


/* =========================================================
   MOBILE
========================================================= */

@media (hover: none) {

    .public-hero:active {

        transform:
            scale(.985);

        box-shadow:
            0 20px 45px rgba(30,64,175,.20);
    }

}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .public-hero,
    .public-hero::before,
    .public-hero::after,
    .hero-badge,
    .hero-title,
    .hero-description,
    .hero-overview,
    .hero-btn {

        transition:
            none !important;
    }

}


/* =========================================================
   TRANSISI ELEMEN HERO
========================================================= */

.hero-badge,
.hero-title,
.hero-description,
.hero-overview,
.hero-btn {

    transition:
        transform .4s cubic-bezier(.2,.8,.2,1),
        background .35s ease,
        border-color .35s ease,
        box-shadow .35s ease;
}


/* =========================================================
   EFEK KLIK
========================================================= */

.public-hero:active {

    transform:
        translateY(-2px)
        scale(.995);
}


/* =========================================================
   MOBILE
========================================================= */

@media (hover: none) {

    .public-hero:active {

        transform:
            scale(.985);

        box-shadow:
            0 20px 45px rgba(30,64,175,.20);
    }

}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .public-hero,
    .public-hero::before,
    .public-hero::after,
    .hero-badge,
    .hero-title,
    .hero-description,
    .hero-overview,
    .hero-btn {

        transition:
            none !important;
    }

}

/* =========================================================
   SNAPSHOT HERO
========================================================= */

.hero-overview {

    padding: 21px;

    border:
        1px solid rgba(255,255,255,.13);

    border-radius: 18px;

    background:
        rgba(255,255,255,.08);

    backdrop-filter:
        blur(14px);

    box-shadow:
        inset 0 1px 0 rgba(255,255,255,.05);
}


.hero-overview-label {

    color:
        rgba(255,255,255,.52);

    font-size: 10px;

    font-weight: 800;

    letter-spacing: .10em;

    text-transform: uppercase;
}


.hero-overview-title {

    margin:
        7px 0 16px;

    font-size: 17px;

    font-weight: 800;
}


.hero-overview-row {

    display: flex;

    align-items: center;

    justify-content: space-between;

    gap: 15px;

    padding:
        12px 0;

    border-top:
        1px solid rgba(255,255,255,.09);
}


.hero-overview-row span {

    color:
        rgba(255,255,255,.56);

    font-size: 11px;
}


.hero-overview-row strong {

    color: #fff;

    font-size: 13px;

    font-weight: 800;

    text-align: right;
}


/* =========================================================
   SECTION
========================================================= */

.dashboard-section {

    margin-top: 34px;
}


.section-heading {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 16px;
}


.section-kicker {

    margin: 0 0 6px;

    color: #2563eb;

    font-size: 11px;

    font-weight: 700;

    letter-spacing: .08em;

    text-transform: uppercase;
}


.section-title {

    margin: 0;

    color: var(--text);

    font-size: 22px;

    font-weight: 800;

    line-height: 1.25;

    letter-spacing: -.025em;
}


.section-description {

    margin: 6px 0 0;

    color: var(--muted);

    font-size: 13px;

    font-weight: 400;

    line-height: 1.6;
}


.section-link {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    color:
        #2563eb;

    font-size: 11px;

    font-weight: 700;

    text-decoration: none;

    white-space: nowrap;
}


.section-link:hover {

    color:
        #1d4ed8;
}


/* =========================================================
   METRIC CARDS
========================================================= */

.metric-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 13px;
}


.metric-card {

    position: relative;

    overflow: hidden;

    min-height: 165px;

    padding: 20px;

    background:
        #fff;

    border:
        1px solid #e2e8f0;

    border-radius: 17px;

    box-shadow:
        0 6px 22px rgba(15,23,42,.04);

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        border-color .25s ease;
}


.metric-card:hover {

    transform:
        translateY(-5px);

    border-color:
        #cbd5e1;

    box-shadow:
        0 16px 32px rgba(15,23,42,.09);
}


.metric-card-dark {

    color: #fff;

    border-color:
        transparent;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(96,165,250,.22),
            transparent 38%
        ),
        linear-gradient(
            145deg,
            #111827,
            #172554
        );

    box-shadow:
        0 15px 32px rgba(15,23,42,.15);
}


.metric-top {

    display: flex;

    align-items: center;

    justify-content: space-between;
}


.metric-icon {

    width: 37px;
    height: 37px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background:
        #eff6ff;

    color:
        #2563eb;

    font-size: 18px;

    transition:
        .25s ease;
}


.metric-card:hover
.metric-icon {

    transform:
        translateY(-2px)
        scale(1.06);
}


.metric-card-dark
.metric-icon {

    color:
        #dbeafe;

    background:
        rgba(255,255,255,.09);
}


.metric-label {
    margin-top: 18px;
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    line-height: 1.4;
}


.metric-card-dark
.metric-label {

    color:
        rgba(255,255,255,.55);
}


.metric-value {

    margin-top: 5px;

    color:
        #0f172a;

    font-size:
        clamp(18px, 1.8vw, 24px);

    font-weight: 800;

    line-height: 1.15;

    letter-spacing: -.035em;
}


.metric-card-dark
.metric-value {

    color:
        #fff;
}


.metric-note {
    display: flex;
    align-items: center;
    gap: 5px;

    margin-top: 9px;

    color: #64748b;

    font-size: 11px;
    font-weight: 500;
    line-height: 1.4;
}


.metric-card-dark
.metric-note {

    color:
        rgba(255,255,255,.52);
}


.metric-decoration {

    position: absolute;

    right: -38px;
    bottom: -58px;

    width: 135px;
    height: 135px;

    border:
        1px solid rgba(37,99,235,.07);

    border-radius: 50%;

    transition:
        .4s ease;
}


.metric-card:hover
.metric-decoration {

    transform:
        scale(1.2);
}

/* =========================================================
   METRIC CARD - INTERACTIVE COLOR
========================================================= */

.metric-card {

    cursor:
        default;

    transform:
        translateY(0);

    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        box-shadow .35s ease,
        border-color .35s ease,
        background .35s ease;
}


/* =========================================================
   ICON
========================================================= */

.metric-icon {

    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        background .35s ease,
        color .35s ease,
        box-shadow .35s ease;
}


/* =========================================================
   VALUE
========================================================= */

.metric-value {

    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        color .35s ease;
}


/* =========================================================
   NOTE
========================================================= */

.metric-note {

    transition:
        transform .35s ease,
        color .35s ease;
}


/* =========================================================
   DECORATION
========================================================= */

.metric-decoration {

    transition:
        transform .55s cubic-bezier(.2,.8,.2,1),
        opacity .4s ease,
        border-color .4s ease;
}


/* =========================================================
   HOVER UTAMA
========================================================= */

@media (hover: hover) and (pointer: fine) {

    .metric-card:hover {

        transform:
            translateY(-8px);

        box-shadow:
            0 20px 38px rgba(15,23,42,.12);
    }


    .metric-card:hover .metric-icon {

        transform:
            translateY(-4px)
            scale(1.10);

        box-shadow:
            0 9px 20px rgba(37,99,235,.14);
    }


    .metric-card:hover .metric-value {

        transform:
            translateX(3px);
    }


    .metric-card:hover .metric-note {

        transform:
            translateX(3px);
    }


    .metric-card:hover .metric-decoration {

        transform:
            scale(1.45);

        opacity:
            .9;
    }


/* =========================================================
   METRIC CARD - COLORED & INTERACTIVE
========================================================= */

.metric-card {
    cursor: default;
    transform: translateY(0);

    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        box-shadow .35s ease,
        border-color .35s ease,
        background .45s ease;
}


/* =========================================================
   ICON
========================================================= */

.metric-icon {
    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        background .35s ease,
        color .35s ease,
        box-shadow .35s ease;
}


/* =========================================================
   VALUE
========================================================= */

.metric-value {
    transition:
        transform .35s cubic-bezier(.2,.8,.2,1),
        color .35s ease;
}


/* =========================================================
   NOTE
========================================================= */

.metric-note {
    transition:
        transform .35s ease,
        color .35s ease;
}


/* =========================================================
   DECORATION
========================================================= */

.metric-decoration {
    transition:
        transform .55s cubic-bezier(.2,.8,.2,1),
        opacity .4s ease,
        border-color .4s ease;
}


/* =========================================================
   1. PENDAPATAN
   DARK BLUE
========================================================= */

.metric-card:nth-child(1) {
    color: #ffffff;
    border-color: transparent;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(96,165,250,.28),
            transparent 40%
        ),
        linear-gradient(
            145deg,
            #111827 0%,
            #172554 55%,
            #1e3a8a 100%
        );

    box-shadow:
        0 15px 32px rgba(15,23,42,.15);
}

.metric-card:nth-child(1) .metric-label {
    color: rgba(255,255,255,.60);
}

.metric-card:nth-child(1) .metric-value {
    color: #ffffff;
}

.metric-card:nth-child(1) .metric-note {
    color: rgba(255,255,255,.60);
}

.metric-card:nth-child(1) .metric-icon {
    color: #dbeafe;
    background: rgba(255,255,255,.09);
}

.metric-card:nth-child(1) .metric-decoration {
    border-color: rgba(147,197,253,.12);
}


/* =========================================================
   2. BELANJA
   AMBER
========================================================= */

.metric-card:nth-child(2) {
    border-color: #fde68a;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(251,191,36,.18),
            transparent 38%
        ),
        linear-gradient(
            145deg,
            #ffffff 0%,
            #fffbeb 55%,
            #fef3c7 100%
        );

    box-shadow:
        0 10px 28px rgba(245,158,11,.08);
}

.metric-card:nth-child(2) .metric-icon {
    color: #d97706;
    background: #fef3c7;
}

.metric-card:nth-child(2) .metric-decoration {
    border-color: rgba(245,158,11,.14);
}


/* =========================================================
   3. PEMBIAYAAN NETO
   PURPLE
========================================================= */

.metric-card:nth-child(3) {
    border-color: #ddd6fe;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(167,139,250,.18),
            transparent 38%
        ),
        linear-gradient(
            145deg,
            #ffffff 0%,
            #f5f3ff 55%,
            #ede9fe 100%
        );

    box-shadow:
        0 10px 28px rgba(124,58,237,.08);
}

.metric-card:nth-child(3) .metric-icon {
    color: #7c3aed;
    background: #ede9fe;
}

.metric-card:nth-child(3) .metric-decoration {
    border-color: rgba(124,58,237,.14);
}


/* =========================================================
   4. SURPLUS
   GREEN
========================================================= */

.metric-card:nth-child(4) {
    border-color: #bbf7d0;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(74,222,128,.18),
            transparent 38%
        ),
        linear-gradient(
            145deg,
            #ffffff 0%,
            #f0fdf4 55%,
            #dcfce7 100%
        );

    box-shadow:
        0 10px 28px rgba(22,163,74,.08);
}

.metric-card:nth-child(4) .metric-icon {
    color: #16a34a;
    background: #dcfce7;
}

.metric-card:nth-child(4) .metric-decoration {
    border-color: rgba(22,163,74,.14);
}


/* =========================================================
   4. DEFISIT
   RED
========================================================= */

.metric-card:nth-child(4):has(.bx-minus-circle) {
    border-color: #fecaca;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(248,113,113,.18),
            transparent 38%
        ),
        linear-gradient(
            145deg,
            #ffffff 0%,
            #fef2f2 55%,
            #fee2e2 100%
        );

    box-shadow:
        0 10px 28px rgba(220,38,38,.08);
}

.metric-card:nth-child(4):has(.bx-minus-circle) .metric-icon {
    color: #dc2626;
    background: #fee2e2;
}

.metric-card:nth-child(4):has(.bx-minus-circle) .metric-decoration {
    border-color: rgba(220,38,38,.14);
}


/* =========================================================
   HOVER
========================================================= */

@media (hover: hover) and (pointer: fine) {

    .metric-card:hover {
        transform: translateY(-8px);
    }

    .metric-card:hover .metric-icon {
        transform:
            translateY(-4px)
            scale(1.10);
    }

    .metric-card:hover .metric-value {
        transform: translateX(3px);
    }

    .metric-card:hover .metric-note {
        transform: translateX(3px);
    }

    .metric-card:hover .metric-decoration {
        transform: scale(1.45);
        opacity: .9;
    }


    /* =====================================================
       PENDAPATAN HOVER
    ===================================================== */

    .metric-card:nth-child(1):hover {
        border-color: rgba(147,197,253,.40);

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(96,165,250,.42),
                transparent 42%
            ),
            linear-gradient(
                145deg,
                #111827 0%,
                #1e3a8a 55%,
                #2563eb 100%
            );

        box-shadow:
            0 24px 45px rgba(30,64,175,.28);
    }

    .metric-card:nth-child(1):hover .metric-icon {
        color: #ffffff;
        background: rgba(96,165,250,.22);
        box-shadow:
            0 9px 22px rgba(96,165,250,.18);
    }

    .metric-card:nth-child(1):hover .metric-value {
        color: #ffffff;
    }

    .metric-card:nth-child(1):hover .metric-note {
        color: rgba(255,255,255,.72);
    }

    .metric-card:nth-child(1):hover .metric-decoration {
        border-color: rgba(147,197,253,.18);
    }


    /* =====================================================
       BELANJA HOVER
    ===================================================== */

    .metric-card:nth-child(2):hover {
        border-color: #fbbf24;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(251,191,36,.28),
                transparent 42%
            ),
            linear-gradient(
                145deg,
                #ffffff 0%,
                #fef3c7 55%,
                #fde68a 100%
            );

        box-shadow:
            0 22px 42px rgba(245,158,11,.16);
    }

    .metric-card:nth-child(2):hover .metric-icon {
        color: #b45309;
        background: #fde68a;

        box-shadow:
            0 9px 20px rgba(245,158,11,.16);
    }


    /* =====================================================
       PEMBIAYAAN HOVER
    ===================================================== */

    .metric-card:nth-child(3):hover {
        border-color: #c4b5fd;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(167,139,250,.28),
                transparent 42%
            ),
            linear-gradient(
                145deg,
                #ffffff 0%,
                #ede9fe 55%,
                #ddd6fe 100%
            );

        box-shadow:
            0 22px 42px rgba(124,58,237,.16);
    }

    .metric-card:nth-child(3):hover .metric-icon {
        color: #6d28d9;
        background: #ddd6fe;

        box-shadow:
            0 9px 20px rgba(124,58,237,.16);
    }


    /* =====================================================
       SURPLUS HOVER
    ===================================================== */

    .metric-card:nth-child(4):hover {
        border-color: #86efac;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(74,222,128,.28),
                transparent 42%
            ),
            linear-gradient(
                145deg,
                #ffffff 0%,
                #dcfce7 55%,
                #bbf7d0 100%
            );

        box-shadow:
            0 22px 42px rgba(22,163,74,.16);
    }

    .metric-card:nth-child(4):hover .metric-icon {
        color: #15803d;
        background: #bbf7d0;

        box-shadow:
            0 9px 20px rgba(22,163,74,.16);
    }


    /* =====================================================
       DEFISIT HOVER
    ===================================================== */

    .metric-card:nth-child(4):has(.bx-minus-circle):hover {
        border-color: #fca5a5;

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(248,113,113,.28),
                transparent 42%
            ),
            linear-gradient(
                145deg,
                #ffffff 0%,
                #fee2e2 55%,
                #fecaca 100%
            );

        box-shadow:
            0 22px 42px rgba(220,38,38,.16);
    }

    .metric-card:nth-child(4):has(.bx-minus-circle):hover .metric-icon {
        color: #b91c1c;
        background: #fecaca;

        box-shadow:
            0 9px 20px rgba(220,38,38,.16);
    }
}


/* =========================================================
   TOUCH DEVICE
========================================================= */

@media (hover: none) {

    .metric-card:active {
        transform: scale(.985);
    }
}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .metric-card,
    .metric-icon,
    .metric-value,
    .metric-note,
    .metric-decoration {
        transition: none !important;
    }
}


    /* =====================================================
       SURPLUS / DEFISIT - DEFISIT
    ====================================================== */

    .metric-card:nth-child(4):has(.bx-minus-circle):hover {

        border-color:
            #fca5a5;

        background:
            linear-gradient(
                145deg,
                #ffffff 0%,
                #fef2f2 100%
            );

        box-shadow:
            0 20px 40px rgba(220,38,38,.12);
    }


    .metric-card:nth-child(4):has(.bx-minus-circle):hover .metric-icon {

        color:
            #dc2626;

        background:
            #fee2e2;
    }


    /* =====================================================
       DARK CARD - PENDAPATAN
    ====================================================== */

    .metric-card-dark {

        transition:
            transform .35s cubic-bezier(.2,.8,.2,1),
            box-shadow .35s ease,
            background .45s ease;
    }


    .metric-card-dark:hover {

        background:
            radial-gradient(
                circle at 100% 0%,
                rgba(96,165,250,.38),
                transparent 40%
            ),
            linear-gradient(
                145deg,
                #111827,
                #1e3a8a
            );

        box-shadow:
            0 24px 45px rgba(30,64,175,.24);
    }


    .metric-card-dark:hover .metric-icon {

        color:
            #ffffff;

        background:
            rgba(96,165,250,.20);

        box-shadow:
            0 9px 22px rgba(96,165,250,.15);
    }

}


/* =========================================================
   MOBILE / TOUCH
========================================================= */

@media (hover: none) {

    .metric-card:active {

        transform:
            scale(.985);
    }

}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .metric-card,
    .metric-icon,
    .metric-value,
    .metric-note,
    .metric-decoration {

        transition:
            none !important;
    }

}

/* =========================================================
   REALISASI
========================================================= */

.realisasi-grid {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 13px;
}


.realisasi-card {

    padding: 21px;

    background:
        #fff;

    border:
        1px solid #e2e8f0;

    border-radius: 17px;

    box-shadow:
        0 6px 22px rgba(15,23,42,.04);
}


.realisasi-header {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 20px;
}


.realisasi-title-wrap {

    display: flex;

    align-items: center;

    gap: 10px;
}


.realisasi-icon {

    width: 37px;
    height: 37px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background:
        #f1f5f9;

    color:
        #0f172a;

    font-size: 17px;
}


.realisasi-title {

    margin: 0;

    color:
        #0f172a;

    font-size: 13px;

    font-weight: 800;
}


.realisasi-subtitle {

    margin:
        3px 0 0;

    color:
        #64748b;

    font-size: 10px;
}


.realisasi-percent {

    color:
        #2563eb;

    font-size: 20px;

    font-weight: 800;

    letter-spacing: -.04em;
}


.progress-track {

    width: 100%;

    height: 8px;

    margin-top: 23px;

    overflow: hidden;

    border-radius: 999px;

    background:
        #eef2f7;
}


.progress-bar {

    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #2563eb,
            #60a5fa
        );

    transition:
        width .8s ease;
}


.realisasi-bottom {

    display: flex;

    justify-content: space-between;

    gap: 15px;

    margin-top: 11px;

    color:
        #64748b;

    font-size: 10px;
}


.realisasi-bottom strong {

    color:
        #0f172a;

    font-weight: 800;
}


/* =========================================================
   ANALISIS KEUANGAN
========================================================= */

.financial-grid {

    display: grid;

    grid-template-columns:
        minmax(0, 1.1fr)
        minmax(300px, .9fr);

    gap: 13px;
}


.financial-card {

    padding: 22px;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    background:
        #fff;

    box-shadow:
        0 6px 22px rgba(15,23,42,.04);
}


.financial-card-dark {

    color:
        #fff;

    border-color:
        transparent;

    background:
        radial-gradient(
            circle at 100% 0%,
            rgba(96,165,250,.23),
            transparent 35%
        ),
        linear-gradient(
            145deg,
            #111827,
            #172554
        );
}


.financial-card-header {

    display: flex;

    justify-content: space-between;

    align-items: flex-start;

    gap: 20px;

    margin-bottom: 23px;
}


.financial-card-title {

    margin: 0;

    color:
        #0f172a;

    font-size: 14px;

    font-weight: 800;
}


.financial-card-dark
.financial-card-title {

    color:
        #fff;
}


.financial-card-subtitle {

    margin:
        4px 0 0;

    color:
        #64748b;

    font-size: 10px;
}


.financial-card-dark
.financial-card-subtitle {

    color:
        rgba(255,255,255,.52);
}


.financial-list {

    display: grid;

    gap: 17px;
}


.financial-item {

    display: grid;

    gap: 7px;
}


.financial-item-top {

    display: flex;

    justify-content: space-between;

    gap: 15px;

    font-size: 11px;
}


.financial-item-top span {

    color:
        #64748b;

    font-weight: 600;
}


.financial-item-top strong {

    color:
        #0f172a;

    font-weight: 800;
}


.financial-line {

    width: 100%;

    height: 7px;

    overflow: hidden;

    border-radius: 999px;

    background:
        #eef2f7;
}


.financial-line span {

    display: block;

    height: 100%;

    border-radius: inherit;

    background:
        linear-gradient(
            90deg,
            #1d4ed8,
            #60a5fa
        );
}


/* =========================================================
   KONDISI APBDESA
========================================================= */

.balance-main {

    display: flex;

    align-items: flex-end;

    justify-content: space-between;

    gap: 20px;

    margin-bottom: 23px;
}


.balance-label {

    color:
        rgba(255,255,255,.52);

    font-size: 10px;

    font-weight: 600;
}


.balance-value {

    margin-top: 7px;

    color:
        #fff;

    font-size:
        clamp(27px, 3vw, 38px);

    font-weight: 800;

    line-height: 1;

    letter-spacing: -.05em;
}


.balance-status {

    display: inline-flex;

    align-items: center;

    gap: 5px;

    padding: 6px 9px;

    border-radius: 999px;

    background:
        rgba(255,255,255,.09);

    color:
        rgba(255,255,255,.75);

    font-size: 9px;

    font-weight: 700;

    white-space: nowrap;
}


.balance-details {

    display: grid;

    grid-template-columns:
        repeat(2, minmax(0,1fr));

    border-top:
        1px solid rgba(255,255,255,.09);
}


.balance-detail {

    padding-top: 15px;
}


.balance-detail + .balance-detail {

    padding-left: 16px;

    border-left:
        1px solid rgba(255,255,255,.09);
}


.balance-detail-label {

    color:
        rgba(255,255,255,.44);

    font-size: 9px;
}


.balance-detail-value {

    margin-top: 5px;

    color:
        #fff;

    font-size: 13px;

    font-weight: 800;
}


/* =========================================================
   AKSES INFORMASI
========================================================= */

.quick-grid {

    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 12px;
}


.quick-card {

    display: flex;

    align-items: center;

    gap: 12px;

    min-height: 82px;

    padding: 14px;

    color:
        #0f172a;

    text-decoration: none;

    border:
        1px solid #e2e8f0;

    border-radius: 15px;

    background:
        #fff;

    box-shadow:
        0 5px 18px rgba(15,23,42,.035);

    transition:
        .25s ease;
}


.quick-card:hover {

    transform:
        translateY(-4px);

    border-color:
        #bfdbfe;

    box-shadow:
        0 13px 28px rgba(15,23,42,.08);
}


.quick-icon {

    flex: 0 0 auto;

    width: 38px;
    height: 38px;

    display: inline-flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background:
        #eff6ff;

    color:
        #2563eb;

    font-size: 17px;
}


.quick-content {

    min-width: 0;

    flex: 1;
}


.quick-title {
    margin: 0;
    font-size: 13px;
    font-weight: 800;
    line-height: 1.35;
}


.quick-description {
    margin: 4px 0 0;

    color: #64748b;

    font-size: 11px;

    line-height: 1.5;
}


.quick-arrow {

    color:
        #94a3b8;

    font-size: 16px;

    transition:
        .25s ease;
}


.quick-card:hover
.quick-arrow {

    color:
        #2563eb;

    transform:
        translateX(3px);
}


/* =========================================================
   INFO
========================================================= */

.info-panel {

    position: relative;

    overflow: hidden;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        auto;

    align-items: center;

    gap: 30px;

    padding:
        23px 25px;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    background:
        #f8fafc;
}


.info-panel::after {

    content: "";

    position: absolute;

    right: -70px;
    bottom: -100px;

    width: 230px;
    height: 230px;

    border:
        1px solid #e2e8f0;

    border-radius: 50%;
}


.info-title {

    margin:
        0 0 6px;

    color:
        #0f172a;

    font-size: 15px;

    font-weight: 800;
}


.info-text {

    max-width: 800px;

    margin: 0;

    color:
        #64748b;

    font-size: 11px;

    line-height: 1.7;
}


.info-button {

    position: relative;

    z-index: 2;

    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding:
        10px 14px;

    border-radius: 10px;

    background:
        #0f172a;

    color:
        #fff;

    text-decoration: none;

    font-size: 10px;

    font-weight: 700;

    white-space: nowrap;

    transition:
        .25s ease;
}


.info-button:hover {

    background:
        #1e293b;

    transform:
        translateY(-2px);
}


/* =========================================================
   EMPTY STATE
========================================================= */

.empty-card {

    text-align: center;

    padding:
        60px 25px;

    border:
        1px solid #e2e8f0;

    border-radius: 18px;

    background:
        #fff;

    box-shadow:
        0 6px 22px rgba(15,23,42,.04);
}


.empty-icon {

    width: 62px;
    height: 62px;

    margin:
        0 auto 17px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 17px;

    background:
        #eff6ff;

    color:
        #2563eb;

    font-size: 27px;
}


.empty-title {

    margin: 0;

    color:
        #0f172a;

    font-size: 19px;

    font-weight: 800;
}


.empty-text {

    max-width: 500px;

    margin:
        9px auto 0;

    color:
        #64748b;

    font-size: 12px;

    line-height: 1.7;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .public-dashboard {

        width:
            min(
                calc(100% - 36px),
                1150px
            );
    }


    .metric-grid {

        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }


    .quick-grid {

        grid-template-columns:
            repeat(2, minmax(0,1fr));
    }

}


@media (max-width: 900px) {

    .public-dashboard {

        width:
            calc(100% - 30px);
    }


    .public-hero {

        padding:
            34px 30px;
    }


    .hero-grid {

        grid-template-columns:
            1fr;
    }


    .hero-overview {

        max-width:
            500px;
    }


    .financial-grid {

        grid-template-columns:
            1fr;
    }


    .realisasi-grid {

        grid-template-columns:
            1fr;
    }

}


@media (max-width: 650px) {

    .public-dashboard {

        width:
            calc(100% - 20px);

        padding-bottom:
            50px;
    }


    .public-hero {

        margin-top:
            10px;

        margin-bottom:
            26px;

        padding:
            27px 20px;

        border-radius:
            20px;
    }


    .hero-title {

        font-size:
            31px;
    }


    .hero-description {

        font-size:
            12px;

        line-height:
            1.7;
    }


    .hero-actions {

        display:
            grid;

        grid-template-columns:
            1fr;
    }


    .hero-btn {

        width:
            100%;
    }


    .hero-overview {

        padding:
            18px;
    }


    .metric-grid {

        grid-template-columns:
            1fr;
    }


    .quick-grid {

        grid-template-columns:
            1fr;
    }


    .section-heading {

        align-items:
            flex-start;
    }


    .section-title {

        font-size:
            19px;
    }


    .section-link {

        display:
            none;
    }


    .metric-card {

        min-height:
            150px;
    }


    .financial-card,
    .realisasi-card {

        padding:
            19px;
    }


    .balance-main {

        display:
            block;
    }


    .balance-status {

        margin-top:
            14px;
    }


    .info-panel {

        grid-template-columns:
            1fr;

        padding:
            21px 19px;
    }


    .info-button {

        justify-self:
            flex-start;
    }

}


@media (prefers-reduced-motion: reduce) {

    .metric-card,
    .metric-icon,
    .metric-decoration,
    .quick-card,
    .quick-arrow,
    .hero-btn,
    .info-button {

        transition:
            none !important;
    }

}

/* =========================================================
   STATISTIK PENGUNJUNG
========================================================= */

.visitor-section {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
    margin-top: 18px;
}

.visitor-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 14px;

    min-height: 88px;
    padding: 16px 18px;

    overflow: hidden;

    border: 1px solid #e2e8f0;
    border-radius: 17px;

    background:
        linear-gradient(
            145deg,
            #ffffff 0%,
            #f8fafc 100%
        );

    box-shadow:
        0 6px 20px rgba(15, 23, 42, .045);

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        border-color .3s ease;
}

.visitor-card::after {
    content: "";

    position: absolute;

    width: 110px;
    height: 110px;

    right: -55px;
    bottom: -65px;

    border-radius: 50%;

    background:
        rgba(37, 99, 235, .055);

    pointer-events: none;
}

.visitor-card:hover {
    transform: translateY(-4px);

    border-color: #bfdbfe;

    box-shadow:
        0 15px 30px rgba(15, 23, 42, .08);
}


/* ICON */

.visitor-icon {
    position: relative;
    z-index: 1;

    width: 46px;
    height: 46px;

    flex: 0 0 46px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 13px;

    color: #2563eb;

    background:
        #eff6ff;

    font-size: 21px;

    transition:
        transform .3s ease,
        background .3s ease;
}

.visitor-card:hover .visitor-icon {
    transform: scale(1.06);

    background:
        #dbeafe;
}


/* CONTENT */

.visitor-content {
    position: relative;
    z-index: 1;

    min-width: 0;
}

.visitor-label {
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.35;
}

.visitor-value {
    margin-top: 3px;

    color: #0f172a;

    font-size: 24px;

    line-height: 1.1;

    font-weight: 800;

    letter-spacing: -.035em;
}

.visitor-note {
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
    line-height: 1.45;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 900px) {

    .visitor-section {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 600px) {

    .visitor-card {
        min-height: 82px;

        padding: 14px 16px;
    }

    .visitor-icon {
        width: 42px;
        height: 42px;

        flex-basis: 42px;

        font-size: 19px;
    }

    .visitor-value {
        font-size: 22px;
    }

}


/* =========================================================
   REDUCED MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .visitor-card,
    .visitor-icon {
        transition: none !important;
    }

}

</style>


<div class="public-dashboard">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="public-hero">

        <div class="hero-grid">


            <div class="hero-content">

                <div class="hero-badge">

                    <i class='bx bx-bar-chart-alt-2'></i>

                    Publikasi APBDesa

                    @if($year)
                        • Tahun {{ $year->tahun }}
                    @endif

                </div>


                <h1 class="hero-title">

                    Transparansi Anggaran

                    <span>
                        Desa {{ $namaDesaBersih }}
                    </span>

                </h1>


                <p class="hero-description">

                    Akses informasi APBDesa secara terbuka dan mudah
                    dipahami. Lihat anggaran, realisasi, pembiayaan,
                    serta informasi publikasi keuangan desa dalam
                    satu tempat.

                </p>


                @if($year)

                    <div class="hero-actions">

                        <a
                            href="{{ route('apbdesa', $year->tahun) }}"
                            class="hero-btn hero-btn-primary"
                        >

                            <i class='bx bx-wallet'></i>

                            Lihat APBDesa

                        </a>


                        <a
                            href="{{ route('realisasi', $year->tahun) }}"
                            class="hero-btn hero-btn-secondary"
                        >

                            <i class='bx bx-line-chart'></i>

                            Lihat Realisasi

                        </a>

                    </div>

                @endif

            </div>


            {{-- SNAPSHOT --}}

            <div class="hero-overview">

                <div class="hero-overview-label">

                    Ringkasan Tahun Anggaran

                </div>


                <div class="hero-overview-title">

                    APBDesa {{ $year->tahun ?? '-' }}

                </div>


                <div class="hero-overview-row">

                    <span>
                        Total Pendapatan
                    </span>

                    <strong>
    {{ $formatRupiah($income) }}
</strong>

                </div>


                <div class="hero-overview-row">

                    <span>
                        Total Belanja
                    </span>

                    <strong>
                        {{ $formatRupiah($expense) }}
                    </strong>

                </div>


                <div class="hero-overview-row">

                    <span>
                        Realisasi Keseluruhan
                    </span>

                    <strong>
                        {{ number_format(
                            $overallRate,
                            1,
                            ',',
                            '.'
                        ) }}%
                    </strong>

                </div>

            </div>

        </div>

    </section>



    @if($year && $summary)


        {{-- =================================================
             RINGKASAN UTAMA
        ================================================== --}}

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="section-kicker">
                        Ringkasan Keuangan
                    </p>

                    <h2 class="section-title">
                        Ringkasan APBDesa
                    </h2>

                    <p class="section-description">

                        Gambaran utama anggaran
                        Desa {{ $namaDesaBersih }}
                        tahun {{ $year->tahun }}.

                    </p>

                </div>


                <a
                    href="{{ route(
                        'apbdesa',
                        $year->tahun
                    ) }}"
                    class="section-link"
                >

                    Lihat rincian

                    <i class='bx bx-right-arrow-alt'></i>

                </a>

            </div>


            <div class="metric-grid">


                {{-- PENDAPATAN --}}

                <div class="metric-card metric-card-dark">

                    <div class="metric-top">

                        <div class="metric-icon">

                            <i class='bx bx-trending-up'></i>

                        </div>

                    </div>


                    <div class="metric-label">
                        Total Pendapatan
                    </div>


                    <div class="metric-value">

                        {{ $formatRupiah($income) }}

                    </div>


                    <div class="metric-note">

                        <i class='bx bx-check-circle'></i>

                        Realisasi
                        {{ number_format(
                            $incomeRate,
                            1,
                            ',',
                            '.'
                        ) }}%

                    </div>


                    <div class="metric-decoration"></div>

                </div>



                {{-- BELANJA --}}

                <div class="metric-card">

                    <div class="metric-top">

                        <div class="metric-icon">

                            <i class='bx bx-wallet'></i>

                        </div>

                    </div>


                    <div class="metric-label">
                        Total Belanja
                    </div>


                    <div class="metric-value">

                        {{ $formatRupiah($expense) }}

                    </div>


                    <div class="metric-note">

                        <i class='bx bx-pie-chart-alt-2'></i>

                        Realisasi
                        {{ number_format(
                            $expenseRate,
                            1,
                            ',',
                            '.'
                        ) }}%

                    </div>


                    <div class="metric-decoration"></div>

                </div>



                {{-- PEMBIAYAAN --}}

                <div class="metric-card">

                    <div class="metric-top">

                        <div class="metric-icon">

                            <i class='bx bx-transfer-alt'></i>

                        </div>

                    </div>


                    <div class="metric-label">
                        Pembiayaan Neto
                    </div>


                    <div class="metric-value">

                        {{ $formatRupiah($netFinancing) }}

                    </div>


                    <div class="metric-note">

                        <i class='bx bx-transfer'></i>

                        Arus pembiayaan desa

                    </div>


                    <div class="metric-decoration"></div>

                </div>



                {{-- SURPLUS / DEFISIT --}}

                <div class="metric-card">

                    <div class="metric-top">

                        <div class="metric-icon">

                            <i class='bx
                                {{ $surplusPositive
                                    ? 'bx-check-circle'
                                    : 'bx-minus-circle' }}'>
                            </i>

                        </div>

                    </div>


                    <div class="metric-label">
                        Surplus / Defisit
                    </div>


                    <div class="metric-value">

                        {{ $formatRupiah($surplus) }}

                    </div>


                    <div class="metric-note">

                        <i class='bx
                            {{ $surplusPositive
                                ? 'bx-up-arrow-alt'
                                : 'bx-down-arrow-alt' }}'>
                        </i>

                        Posisi anggaran

                    </div>


                    <div class="metric-decoration"></div>

                </div>


            </div>

        </section>



        {{-- =================================================
             REALISASI
        ================================================== --}}

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="section-kicker">
                        Realisasi Anggaran
                    </p>

                    <h2 class="section-title">
                        Perkembangan Realisasi
                    </h2>

                    <p class="section-description">

                        Perbandingan antara anggaran dan
                        realisasi pendapatan serta belanja.

                    </p>

                </div>


                <a
                    href="{{ route(
                        'realisasi',
                        $year->tahun
                    ) }}"
                    class="section-link"
                >

                    Detail realisasi

                    <i class='bx bx-right-arrow-alt'></i>

                </a>

            </div>


            <div class="realisasi-grid">


                {{-- PENDAPATAN --}}

                <div class="realisasi-card">

                    <div class="realisasi-header">

                        <div class="realisasi-title-wrap">

                            <div class="realisasi-icon">

                                <i class='bx bx-up-arrow-circle'></i>

                            </div>


                            <div>

                                <h3 class="realisasi-title">
                                    Pendapatan
                                </h3>

                                <p class="realisasi-subtitle">
                                    Realisasi penerimaan
                                </p>

                            </div>

                        </div>


                        <div class="realisasi-percent">

                            {{ number_format(
                                $incomeRate,
                                1,
                                ',',
                                '.'
                            ) }}%

                        </div>

                    </div>


                    <div class="progress-track">

                        <div
                            class="progress-bar"
                            style="
                                width:
                                {{ $incomeRate }}%;
                            "
                        ></div>

                    </div>


                    <div class="realisasi-bottom">

                        <span>

                            Realisasi

                            <strong>
                                {{ $formatRupiah(
                                    $incomeReal
                                ) }}
                            </strong>

                        </span>


                        <span>

                            Anggaran

                            <strong>
                                {{ $formatRupiah(
                                    $income
                                ) }}
                            </strong>

                        </span>

                    </div>

                </div>



                {{-- BELANJA --}}

                <div class="realisasi-card">

                    <div class="realisasi-header">

                        <div class="realisasi-title-wrap">

                            <div class="realisasi-icon">

                                <i class='bx bx-down-arrow-circle'></i>

                            </div>


                            <div>

                                <h3 class="realisasi-title">
                                    Belanja
                                </h3>

                                <p class="realisasi-subtitle">
                                    Realisasi pengeluaran
                                </p>

                            </div>

                        </div>


                        <div class="realisasi-percent">

                            {{ number_format(
                                $expenseRate,
                                1,
                                ',',
                                '.'
                            ) }}%

                        </div>

                    </div>


                    <div class="progress-track">

                        <div
                            class="progress-bar"
                            style="
                                width:
                                {{ $expenseRate }}%;
                            "
                        ></div>

                    </div>


                    <div class="realisasi-bottom">

                        <span>

                            Realisasi

                            <strong>
                                {{ $formatRupiah(
                                    $expenseReal
                                ) }}
                            </strong>

                        </span>


                        <span>

                            Anggaran

                            <strong>
                                {{ $formatRupiah(
                                    $expense
                                ) }}
                            </strong>

                        </span>

                    </div>

                </div>

            </div>

        </section>



        {{-- =================================================
             ANALISIS KEUANGAN
        ================================================== --}}

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="section-kicker">
                        Analisis Keuangan
                    </p>

                    <h2 class="section-title">
                        Gambaran Keuangan Desa
                    </h2>

                    <p class="section-description">

                        Ringkasan komposisi pendapatan,
                        belanja dan pembiayaan.

                    </p>

                </div>

            </div>


            <div class="financial-grid">


                {{-- KOMPOSISI ANGGARAN --}}

                <div class="financial-card">

                    <div class="financial-card-header">

                        <div>

                            <h3 class="financial-card-title">
                                Komposisi Anggaran
                            </h3>

                            <p class="financial-card-subtitle">
                                Perbandingan nilai utama APBDesa
                            </p>

                        </div>

                    </div>


                    <div class="financial-list">


                        {{-- PENDAPATAN --}}

                        <div class="financial-item">

                            <div class="financial-item-top">

                                <span>
                                    Pendapatan
                                </span>

                                <strong>
                                    {{ $formatCompact(
                                        $income
                                    ) }}
                                </strong>

                            </div>


                            <div class="financial-line">

                                <span
                                    style="
                                        width:
                                        {{ $income > 0
                                            ? 100
                                            : 0 }}%;
                                    "
                                ></span>

                            </div>

                        </div>



                        {{-- BELANJA --}}

                        <div class="financial-item">

                            <div class="financial-item-top">

                                <span>
                                    Belanja
                                </span>

                                <strong>
                                    {{ $formatCompact(
                                        $expense
                                    ) }}
                                </strong>

                            </div>


                            <div class="financial-line">

                                <span
                                    style="
                                        width:
                                        {{ $income > 0
                                            ? min(
                                                100,
                                                ($expense / $income) * 100
                                            )
                                            : 0
                                        }}%;
                                    "
                                ></span>

                            </div>

                        </div>



                        {{-- PEMBIAYAAN --}}

                        <div class="financial-item">

                            <div class="financial-item-top">

                                <span>
                                    Pembiayaan Neto
                                </span>

                                <strong>
                                    {{ $formatCompact(
                                        $netFinancing
                                    ) }}
                                </strong>

                            </div>


                            <div class="financial-line">

                                <span
                                    style="
                                        width:
                                        {{ $income > 0
                                            ? min(
                                                100,
                                                (
                                                    abs($netFinancing)
                                                    / $income
                                                ) * 100
                                            )
                                            : 0
                                        }}%;
                                    "
                                ></span>

                            </div>

                        </div>


                    </div>

                </div>



                {{-- KONDISI APBDESA --}}

                <div class="financial-card financial-card-dark">

                    <div class="financial-card-header">

                        <div>

                            <h3 class="financial-card-title">
                                Kondisi APBDesa
                            </h3>

                            <p class="financial-card-subtitle">

                                Ringkasan posisi keuangan
                                tahun {{ $year->tahun }}

                            </p>

                        </div>

                    </div>


                    <div class="balance-main">

                        <div>

                            <div class="balance-label">
                                Surplus / Defisit
                            </div>


                            <div class="balance-value">

                                {{ $formatRupiah(
                                    $surplus
                                ) }}

                            </div>

                        </div>


                        <div class="balance-status">

                            <i class='bx
                                {{ $surplusPositive
                                    ? 'bx-check'
                                    : 'bx-minus' }}'>
                            </i>

                            {{ $surplusPositive
                                ? 'Surplus'
                                : 'Defisit' }}

                        </div>

                    </div>


                    <div class="balance-details">


                        <div class="balance-detail">

                            <div class="balance-detail-label">

                                Penerimaan Pembiayaan

                            </div>


                            <div class="balance-detail-value">

                                {{ $formatRupiah(
                                    $inflow
                                ) }}

                            </div>

                        </div>



                        <div class="balance-detail">

                            <div class="balance-detail-label">

                                Pengeluaran Pembiayaan

                            </div>


                            <div class="balance-detail-value">

                                {{ $formatRupiah(
                                    $outflow
                                ) }}

                            </div>

                        </div>


                    </div>

                </div>

            </div>

        </section>

        {{-- =================================================
             INFORMASI PUBLIK
        ================================================== --}}

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="section-kicker">
                        Informasi Publik
                    </p>

                    <h2 class="section-title">
                        Akses Informasi
                    </h2>

                    <p class="section-description">

                        Akses cepat ke informasi APBDesa
                        dan publikasi keuangan.

                    </p>

                </div>

            </div>


            <div class="quick-grid">


                {{-- PENDAPATAN --}}

                <a
                    href="{{ route(
                        'pendapatan',
                        $year->tahun
                    ) }}"
                    class="quick-card"
                >

                    <div class="quick-icon">

                        <i class='bx bx-trending-up'></i>

                    </div>


                    <div class="quick-content">

                        <h3 class="quick-title">
                            Pendapatan
                        </h3>

                        <p class="quick-description">

                            Lihat rincian sumber
                            pendapatan desa.

                        </p>

                    </div>


                    <i class='bx bx-chevron-right quick-arrow'></i>

                </a>



                {{-- BELANJA --}}

                <a
                    href="{{ route(
                        'belanja',
                        $year->tahun
                    ) }}"
                    class="quick-card"
                >

                    <div class="quick-icon">

                        <i class='bx bx-wallet'></i>

                    </div>


                    <div class="quick-content">

                        <h3 class="quick-title">
                            Belanja
                        </h3>

                        <p class="quick-description">

                            Lihat rincian belanja
                            berdasarkan kegiatan.

                        </p>

                    </div>


                    <i class='bx bx-chevron-right quick-arrow'></i>

                </a>



                {{-- PEMBIAYAAN --}}

                <a
                    href="{{ route(
                        'pembiayaan',
                        $year->tahun
                    ) }}"
                    class="quick-card"
                >

                    <div class="quick-icon">

                        <i class='bx bx-transfer-alt'></i>

                    </div>


                    <div class="quick-content">

                        <h3 class="quick-title">
                            Pembiayaan
                        </h3>

                        <p class="quick-description">

                            Lihat penerimaan dan
                            pengeluaran pembiayaan.

                        </p>

                    </div>


                    <i class='bx bx-chevron-right quick-arrow'></i>

                </a>



                {{-- DOKUMEN --}}

                <a
                    href="{{ route(
                        'dokumen',
                        $year->tahun
                    ) }}"
                    class="quick-card"
                >

                    <div class="quick-icon">

                        <i class='bx bx-file'></i>

                    </div>


                    <div class="quick-content">

                        <h3 class="quick-title">
                            Dokumen Publikasi
                        </h3>

                        <p class="quick-description">

                            Akses dokumen APBDesa
                            yang dipublikasikan.

                        </p>

                    </div>


                    <i class='bx bx-chevron-right quick-arrow'></i>

                </a>


            </div>

        </section>



        {{-- =================================================
             TENTANG E-APBDESA
        ================================================== --}}

        <section class="dashboard-section">

            <div class="info-panel">

                <div>

                    <h3 class="info-title">
                        Tentang e-APBDesa
                    </h3>


                    <p class="info-text">

                        e-APBDesa merupakan media publikasi informasi
                        Anggaran Pendapatan dan Belanja Desa (APBDesa).
                        Sistem ini membantu masyarakat memperoleh informasi
                        mengenai pendapatan, belanja, pembiayaan dan
                        realisasi anggaran desa secara lebih terbuka.

                    </p>

                </div>


                {{-- ROUTE PUBLIK YANG BENAR --}}

                <a
                    href="{{ route('profil') }}"
                    class="info-button"
                >

                    Profil Desa

                    <i class='bx bx-right-arrow-alt'></i>

                </a>

            </div>

        </section>


{{-- =================================================
     STATISTIK PENGUNJUNG
================================================== --}}

<section class="dashboard-section">

    <div class="section-heading">

        <div>

            <p class="section-kicker">
                Statistik Website
            </p>

            <h2 class="section-title">
                Pengunjung Website
            </h2>

            <p class="section-description">
                Informasi jumlah pengunjung
                e-APBDesa.
            </p>

        </div>

    </div>


    <div class="visitor-section">

        <div class="visitor-card">

            <div class="visitor-icon">
                <i class='bx bx-show'></i>
            </div>

            <div class="visitor-content">

                <div class="visitor-label">
                    Jumlah Pengunjung
                </div>

                <div class="visitor-value">
                    {{ number_format(
                        $visitorStats['total'] ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div class="visitor-note">
                    Total pengunjung website
                </div>

            </div>

        </div>


        <div class="visitor-card">

            <div class="visitor-icon">
                <i class='bx bx-calendar'></i>
            </div>

            <div class="visitor-content">

                <div class="visitor-label">
                    Hari Ini
                </div>

                <div class="visitor-value">
                    {{ number_format(
                        $visitorStats['today'] ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div class="visitor-note">
                    Pengunjung hari ini
                </div>

            </div>

        </div>


        <div class="visitor-card">

            <div class="visitor-icon">
                <i class='bx bx-bar-chart-alt-2'></i>
            </div>

            <div class="visitor-content">

                <div class="visitor-label">
                    Bulan Ini
                </div>

                <div class="visitor-value">
                    {{ number_format(
                        $visitorStats['month'] ?? 0,
                        0,
                        ',',
                        '.'
                    ) }}
                </div>

                <div class="visitor-note">
                    Pengunjung bulan ini
                </div>

            </div>

        </div>

    </div>

</section>


@else


        {{-- =================================================
             EMPTY STATE
        ================================================== --}}

        <section class="dashboard-section">

            <div class="empty-card">

                <div class="empty-icon">

                    <i class='bx bx-data'></i>

                </div>


                <h2 class="empty-title">

                    Belum Ada Tahun Anggaran Aktif

                </h2>


                <p class="empty-text">

                    Informasi APBDesa belum dapat ditampilkan
                    karena belum terdapat tahun anggaran yang aktif.

                </p>

            </div>

        </section>


    @endif


</div>

@endsection