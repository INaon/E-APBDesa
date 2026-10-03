@extends('layouts.public')

@section('title', 'APBDesa')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | FORMAT RUPIAH
    |--------------------------------------------------------------------------
    */
    $formatRupiah = function ($value) {
        $value = (float) $value;

        if ($value < 0) {
            return '-Rp ' . number_format(
                abs($value),
                0,
                ',',
                '.'
            );
        }

        return 'Rp ' . number_format(
            $value,
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
    $namaDesa = trim($desa->nama ?? 'Desa');

    /*
    |--------------------------------------------------------------------------
    | TOTAL APBDESA
    |--------------------------------------------------------------------------
    */
    $totalPendapatan = (float) ($summary['income'] ?? 0);
    $totalBelanja = (float) ($summary['expense'] ?? 0);
    $totalPembiayaan = (float) ($summary['netFinancing'] ?? 0);

    /*
    |--------------------------------------------------------------------------
    | SURPLUS / DEFISIT
    |--------------------------------------------------------------------------
    */
    $surplusDefisit = $totalPendapatan - $totalBelanja;

    /*
    |--------------------------------------------------------------------------
    | SILPA
    |--------------------------------------------------------------------------
    */
    $silpa = $surplusDefisit + $totalPembiayaan;

    $labelSurplusDefisit = $surplusDefisit >= 0
        ? 'Surplus'
        : 'Defisit';

    /*
    |--------------------------------------------------------------------------
    | KELOMPOK PENDAPATAN
    |--------------------------------------------------------------------------
    */
    $kelompokPendapatan = [
        '4.1' => 'Pendapatan Asli Desa',
        '4.2' => 'Pendapatan Transfer',
        '4.3' => 'Pendapatan Lain-lain',
    ];

    /*
    |--------------------------------------------------------------------------
    | KELOMPOK PEMBIAYAAN
    |--------------------------------------------------------------------------
    */
    $kelompokPembiayaan = [
        '6.1' => 'Penerimaan Pembiayaan',
        '6.2' => 'Pengeluaran Pembiayaan',
    ];
@endphp


<style>

/* =========================================================
   APBDESA
   BASE
========================================================= */

.apbdesa-page {
    --money-width: 260px;
    --side-padding: 23px;
    --column-gap: 25px;

    width: min(1280px, calc(100% - 48px));
    max-width: 1280px;

    margin: 0 auto;
    padding: 34px 0 70px;

    box-sizing: border-box;
}

.apbdesa-page,
.apbdesa-page *,
.apbdesa-page *::before,
.apbdesa-page *::after {
    box-sizing: border-box;
}


/* =========================================================
   HERO
========================================================= */

.apbdesa-hero {
    position: relative;

    width: 100%;
    max-width: 100%;

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

    box-shadow: 0 18px 45px rgba(15,23,42,.13);
}

.apbdesa-hero::before {
    content: "";

    position: absolute;

    width: 300px;
    height: 300px;

    right: -130px;
    bottom: -180px;

    border: 1px solid rgba(255,255,255,.08);

    border-radius: 50%;

    pointer-events: none;
}

.apbdesa-hero-grid {
    position: relative;
    z-index: 2;

    display: grid;

    grid-template-columns:
        minmax(0, 1fr)
        auto;

    align-items: center;

    gap: 30px;

    width: 100%;
    max-width: 100%;

    min-width: 0;
}

.apbdesa-hero-grid > div {
    min-width: 0;
    max-width: 100%;
}

.apbdesa-kicker {
    margin: 0 0 7px;

    color: #93c5fd;

    font-size: 12px;
    font-weight: 800;

    letter-spacing: .09em;
    text-transform: uppercase;
}

.apbdesa-title {
    margin: 0;

    color: #fff;

    font-size: clamp(30px,4vw,42px);
    line-height: 1.08;

    font-weight: 800;

    letter-spacing: -.04em;

    overflow-wrap: anywhere;
    word-break: break-word;
}

.apbdesa-description {
    width: 100%;
    max-width: 720px;

    margin: 12px 0 0;

    color: rgba(255,255,255,.68);

    font-size: 14px;
    line-height: 1.7;

    overflow-wrap: anywhere;
    word-break: break-word;
}


/* =========================================================
   TAHUN
========================================================= */

.apbdesa-year {
    width: 190px;
    min-width: 190px;
    max-width: 100%;

    padding: 18px 20px;

    border: 1px solid rgba(255,255,255,.13);

    border-radius: 17px;

    background: rgba(255,255,255,.08);

    backdrop-filter: blur(12px);
}

.apbdesa-year-label {
    color: rgba(255,255,255,.55);

    font-size: 10px;
    font-weight: 700;

    letter-spacing: .08em;
    text-transform: uppercase;
}

.apbdesa-year-value {
    margin-top: 5px;

    color: #fff;

    font-size: 27px;
    font-weight: 800;
    line-height: 1.2;

    font-variant-numeric: tabular-nums;
}


/* =========================================================
   SECTION
========================================================= */

.apbdesa-section {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    margin-top: 25px;

    overflow: hidden;

    border: 1px solid #e2e8f0;

    border-radius: 20px;

    background: #fff;

    box-shadow: 0 7px 25px rgba(15,23,42,.04);
}


/* =========================================================
   SECTION HEADER
========================================================= */

.apbdesa-section-header {
    display: grid;

    grid-template-columns:
        minmax(0,1fr)
        var(--money-width);

    align-items: center;

    gap: var(--column-gap);

    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 20px var(--side-padding);

    border-bottom: 1px solid #e2e8f0;

    background: linear-gradient(
        180deg,
        #f8fafc,
        #f1f5f9
    );
}

.apbdesa-section-header > div {
    min-width: 0;
    max-width: 100%;
}

.apbdesa-section-title {
    margin: 0;

    color: #0f172a;

    font-size: 20px;
    font-weight: 800;
    line-height: 1.4;

    overflow-wrap: anywhere;
    word-break: break-word;
}

.apbdesa-section-total {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    text-align: right;
}

.apbdesa-section-total-value {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #0f172a;

    font-size: 18px;
    font-weight: 800;
    line-height: 1.4;

    text-align: right;

    white-space: nowrap;

    font-variant-numeric: tabular-nums;
}


/* =========================================================
   SUB SECTION
========================================================= */

.apbdesa-subsection {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    border-bottom: 1px solid #eef2f7;
}

.apbdesa-subsection:last-child {
    border-bottom: 0;
}

.apbdesa-subsection-header {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 17px var(--side-padding) 10px;
}

.apbdesa-subsection-title {
    width: 100%;
    max-width: 100%;

    margin: 0;

    color: #334155;

    font-size: 14px;
    font-weight: 800;
    line-height: 1.5;

    overflow-wrap: anywhere;
    word-break: break-word;
}


/* =========================================================
   ITEM PENDAPATAN / PEMBIAYAAN
========================================================= */

.apbdesa-item {
    display: grid;

    grid-template-columns:
        minmax(0,1fr)
        var(--money-width);

    align-items: center;

    gap: var(--column-gap);

    width: 100%;
    max-width: 100%;

    min-width: 0;

    margin: 0;

    padding: 10px var(--side-padding);

    border-bottom: 1px solid #f1f5f9;

    transition: background .2s ease;
}

.apbdesa-item:last-child {
    border-bottom: 0;
}

.apbdesa-item:hover {
    background: #f8fafc;
}

.apbdesa-item-left {
    display: grid;

    grid-template-columns:
        100px
        minmax(0,1fr);

    align-items: start;

    gap: 10px;

    width: 100%;
    max-width: 100%;

    min-width: 0;
}

.apbdesa-item-code {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #2563eb;

    font-size: 12px;
    font-weight: 700;
    line-height: 1.5;

    white-space: nowrap;

    font-variant-numeric: tabular-nums;
}

.apbdesa-item-name {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #334155;

    font-size: 13px;
    font-weight: 500;
    line-height: 1.5;

    overflow-wrap: anywhere;
    word-break: break-word;
}

.apbdesa-item-value {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #0f172a;

    font-size: 13px;
    font-weight: 700;
    line-height: 1.5;

    text-align: right;

    white-space: nowrap;

    font-variant-numeric: tabular-nums;
}


/* =========================================================
   SUMMARY
========================================================= */

.apbdesa-summary-block {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 7px var(--side-padding) 18px;
}

.apbdesa-summary-row {
    display: grid;

    grid-template-columns:
        minmax(0,1fr)
        var(--money-width);

    align-items: center;

    gap: var(--column-gap);

    width: 100%;
    max-width: 100%;

    min-width: 0;

    min-height: 38px;

    padding: 7px 0;
}

.apbdesa-summary-row-label {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #475569;

    font-size: 13px;
    font-weight: 700;
    line-height: 1.4;

    overflow-wrap: anywhere;
    word-break: break-word;
}

.apbdesa-summary-row-value {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #0f172a;

    font-size: 15px;
    font-weight: 800;
    line-height: 1.4;

    text-align: right;

    white-space: nowrap;

    font-variant-numeric: tabular-nums;
}

.apbdesa-surplus .apbdesa-summary-row-label,
.apbdesa-surplus .apbdesa-summary-row-value {
    color: #1d4ed8;
}

.apbdesa-defisit .apbdesa-summary-row-label,
.apbdesa-defisit .apbdesa-summary-row-value {
    color: #b91c1c;
}


/* =========================================================
   BELANJA - BIDANG
========================================================= */

.apbdesa-bidang {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    border-bottom: 1px solid #eef2f7;
}

.apbdesa-bidang:last-child {
    border-bottom: 0;
}

.apbdesa-bidang-header {
    display: flex;

    align-items: center;

    gap: 13px;

    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 18px var(--side-padding);
}

.apbdesa-bidang-code {
    display: flex;

    align-items: center;
    justify-content: center;

    flex: 0 0 40px;

    width: 40px;
    height: 40px;

    border-radius: 11px;

    color: #2563eb;
    background: #dbeafe;

    font-size: 12px;
    font-weight: 800;
}

.apbdesa-bidang-name {
    flex: 1 1 auto;

    width: auto;

    max-width: 100%;

    min-width: 0;

    color: #0f172a;

    font-size: 15px;
    font-weight: 800;
    line-height: 1.45;

    overflow-wrap: anywhere;
    word-break: break-word;
}


/* =========================================================
   SUB BIDANG
========================================================= */

.apbdesa-belanja-subbidang {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 11px 0 5px;

    border-top: 1px solid #f1f5f9;
}

.apbdesa-belanja-subbidang-title {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 0 var(--side-padding);

    color: #334155;

    font-size: 13px;
    font-weight: 700;
    line-height: 1.5;

    overflow-wrap: anywhere;
    word-break: break-word;
}


/* =========================================================
   KEGIATAN
========================================================= */

.apbdesa-kegiatan {
    display: grid;

    grid-template-columns:
        minmax(0,1fr)
        var(--money-width);

    align-items: center;

    gap: var(--column-gap);

    width: 100%;
    max-width: 100%;

    min-width: 0;

    padding: 9px var(--side-padding) 9px 73px;

    border-bottom: 1px solid #f1f5f9;
}

.apbdesa-kegiatan:last-child {
    border-bottom: 0;
}

.apbdesa-kegiatan-name {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #475569;

    font-size: 12px;
    font-weight: 500;
    line-height: 1.5;

    overflow-wrap: anywhere;
    word-break: break-word;
}

.apbdesa-kegiatan-value {
    width: 100%;
    max-width: 100%;

    min-width: 0;

    color: #334155;

    font-size: 12px;
    font-weight: 700;
    line-height: 1.5;

    text-align: right;

    white-space: nowrap;

    font-variant-numeric: tabular-nums;
}


/* =========================================================
   EMPTY
========================================================= */

.apbdesa-empty {
    width: 100%;
    max-width: 100%;

    padding: 45px 20px;

    text-align: center;
}

.apbdesa-empty-icon {
    display: flex;

    align-items: center;
    justify-content: center;

    width: 52px;
    height: 52px;

    margin: 0 auto 12px;

    border-radius: 14px;

    color: #94a3b8;
    background: #f1f5f9;

    font-size: 23px;
}

.apbdesa-empty-title {
    color: #475569;

    font-size: 14px;
    font-weight: 700;
}

.apbdesa-empty-text {
    margin-top: 4px;

    color: #94a3b8;

    font-size: 11px;
    line-height: 1.5;
}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 900px) {

    .apbdesa-page {
        width: calc(100% - 30px);
    }

    .apbdesa-hero {
        padding: 28px;
    }

    .apbdesa-hero-grid {
        grid-template-columns: 1fr;
    }

    .apbdesa-year {
        width: 100%;
        min-width: 0;
    }

    .apbdesa-section-header,
    .apbdesa-item,
    .apbdesa-summary-row,
    .apbdesa-kegiatan {
        --money-width: 220px;
    }
}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 650px) {

    html,
    body {
        width: 100%;
        max-width: 100%;

        overflow-x: hidden !important;
    }

    .apbdesa-page {
        width: calc(100% - 20px) !important;
        max-width: 100% !important;

        min-width: 0 !important;

        margin-left: auto !important;
        margin-right: auto !important;

        padding: 16px 0 40px !important;

        overflow: visible !important;
    }

    .apbdesa-page,
    .apbdesa-page * {
        min-width: 0 !important;
    }


    /* =====================================================
       HERO MOBILE
    ===================================================== */

    .apbdesa-hero {
        width: 100% !important;
        max-width: 100% !important;

        padding: 20px 16px !important;

        border-radius: 17px;
    }

    .apbdesa-hero-grid {
        display: flex !important;

        flex-direction: column !important;
        flex-wrap: nowrap !important;

        align-items: stretch !important;

        gap: 15px !important;

        width: 100% !important;
        max-width: 100% !important;
    }

    .apbdesa-hero-grid > div {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;
    }

    .apbdesa-title {
        width: 100% !important;
        max-width: 100% !important;

        font-size: 25px;

        line-height: 1.2;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-kicker {
        font-size: 10px;
    }

    .apbdesa-description {
        width: 100% !important;
        max-width: 100% !important;

        margin-top: 10px;

        font-size: 12px;
        line-height: 1.6;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-year {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        padding: 13px 15px;
    }

    .apbdesa-year-value {
        font-size: 22px;
    }


    /* =====================================================
       SECTION MOBILE
    ===================================================== */

    .apbdesa-section {
        width: 100% !important;
        max-width: 100% !important;

        margin-top: 16px;

        border-radius: 15px;
    }


    /* =====================================================
       SECTION HEADER MOBILE
    ===================================================== */

    .apbdesa-section-header {
        display: flex !important;

        flex-direction: column !important;
        flex-wrap: nowrap !important;

        align-items: stretch !important;

        gap: 5px !important;

        width: 100% !important;
        max-width: 100% !important;

        padding: 14px 15px !important;
    }

    .apbdesa-section-header > div {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;
    }

    .apbdesa-section-title {
        width: 100% !important;
        max-width: 100% !important;

        font-size: 17px;
        line-height: 1.35;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-section-total {
        width: 100% !important;
        max-width: 100% !important;

        text-align: right;
    }

    .apbdesa-section-total-value {
        width: 100% !important;
        max-width: 100% !important;

        font-size: 14px;

        text-align: right;

        white-space: normal !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       SUB SECTION MOBILE
    ===================================================== */

    .apbdesa-subsection {
        width: 100% !important;
        max-width: 100% !important;
    }

    .apbdesa-subsection-header {
        width: 100% !important;
        max-width: 100% !important;

        padding: 12px 15px 8px !important;
    }

    .apbdesa-subsection-title {
        width: 100% !important;
        max-width: 100% !important;

        font-size: 12px;
        line-height: 1.5;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       PENDAPATAN / PEMBIAYAAN MOBILE
    ===================================================== */

    .apbdesa-item {
        display: flex !important;

        flex-direction: column !important;
        flex-wrap: nowrap !important;

        align-items: stretch !important;

        gap: 5px !important;

        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        padding: 10px 15px !important;
    }

    .apbdesa-item-left {
        display: grid !important;

        grid-template-columns:
            68px
            minmax(0,1fr) !important;

        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        gap: 7px !important;
    }

    .apbdesa-item-code {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 10px;

        line-height: 1.45;

        white-space: normal !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-item-name {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 12px;

        line-height: 1.5;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-item-value {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 13px;

        line-height: 1.4;

        text-align: right;

        white-space: normal !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       BIDANG MOBILE
    ===================================================== */

    .apbdesa-bidang {
        width: 100% !important;
        max-width: 100% !important;
    }

    .apbdesa-bidang-header {
        display: flex !important;

        flex-direction: row !important;
        flex-wrap: nowrap !important;

        align-items: flex-start !important;

        gap: 9px !important;

        width: 100% !important;
        max-width: 100% !important;

        padding: 13px 15px !important;
    }

    .apbdesa-bidang-code {
        flex: 0 0 34px !important;

        width: 34px !important;
        height: 34px !important;

        border-radius: 9px;

        font-size: 9px;
    }

    .apbdesa-bidang-name {
        flex: 1 1 auto !important;

        width: auto !important;
        max-width: calc(100% - 43px) !important;

        min-width: 0 !important;

        font-size: 13px;

        line-height: 1.5;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       SUB BIDANG MOBILE
    ===================================================== */

    .apbdesa-belanja-subbidang {
        width: 100% !important;
        max-width: 100% !important;

        padding: 8px 0 3px !important;
    }

    .apbdesa-belanja-subbidang-title {
        width: 100% !important;
        max-width: 100% !important;

        padding: 0 15px !important;

        font-size: 11px;

        line-height: 1.5;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       KEGIATAN MOBILE
    ===================================================== */

    .apbdesa-kegiatan {
        display: flex !important;

        flex-direction: column !important;
        flex-wrap: nowrap !important;

        align-items: stretch !important;

        gap: 3px !important;

        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        padding: 8px 15px 8px 28px !important;
    }

    .apbdesa-kegiatan-name {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 11px;

        line-height: 1.5;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-kegiatan-value {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 12px;

        line-height: 1.4;

        text-align: right;

        white-space: normal !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       SUMMARY MOBILE
    ===================================================== */

    .apbdesa-summary-block {
        width: 100% !important;
        max-width: 100% !important;

        padding: 6px 15px 14px !important;
    }

    .apbdesa-summary-row {
        display: flex !important;

        flex-direction: column !important;
        flex-wrap: nowrap !important;

        align-items: stretch !important;

        gap: 2px !important;

        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        min-height: auto !important;

        padding: 7px 0 !important;
    }

    .apbdesa-summary-row-label {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 11px;

        line-height: 1.45;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }

    .apbdesa-summary-row-value {
        width: 100% !important;
        max-width: 100% !important;

        min-width: 0 !important;

        font-size: 14px;

        line-height: 1.4;

        text-align: right;

        white-space: normal !important;

        overflow-wrap: anywhere !important;
        word-break: break-word !important;
    }


    /* =====================================================
       EMPTY MOBILE
    ===================================================== */

    .apbdesa-empty {
        width: 100% !important;
        max-width: 100% !important;

        padding: 30px 15px !important;
    }

    .apbdesa-empty-title {
        font-size: 13px;
    }

    .apbdesa-empty-text {
        font-size: 11px;
        line-height: 1.5;
    }
}


/* =========================================================
   EXTRA SMALL PHONE
========================================================= */

@media (max-width: 380px) {

    .apbdesa-page {
        width: calc(100% - 14px) !important;
    }

    .apbdesa-hero {
        padding: 18px 14px !important;
    }

    .apbdesa-title {
        font-size: 23px;
    }

    .apbdesa-item-left {
        grid-template-columns:
            60px
            minmax(0,1fr) !important;
    }

    .apbdesa-kegiatan {
        padding-left: 22px !important;
    }
}


/* =========================================================
   REDUCE MOTION
========================================================= */

@media (prefers-reduced-motion: reduce) {

    .apbdesa-item {
        transition: none;
    }
}

</style>


<div class="apbdesa-page">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="apbdesa-hero">

        <div class="apbdesa-hero-grid">

            <div>

                <p class="apbdesa-kicker">
                    Transparansi Anggaran Desa
                </p>

                <h1 class="apbdesa-title">
                    APBDesa {{ $namaDesa }}
                </h1>

                <p class="apbdesa-description">
                    Ringkasan Anggaran Pendapatan dan Belanja
                    Desa Tahun Anggaran {{ $year->tahun }}.
                    Hanya data yang memiliki nilai anggaran
                    yang ditampilkan.
                </p>

            </div>

            <div class="apbdesa-year">

                <div class="apbdesa-year-label">
                    Tahun Anggaran
                </div>

                <div class="apbdesa-year-value">
                    {{ $year->tahun }}
                </div>

            </div>

        </div>

    </section>


    {{-- =====================================================
         PENDAPATAN
    ====================================================== --}}

    <section class="apbdesa-section">

        <div class="apbdesa-section-header">

            <div>
                <h2 class="apbdesa-section-title">
                    Pendapatan
                </h2>
            </div>

            <div class="apbdesa-section-total">

                <div class="apbdesa-section-total-value">
                    {{ $formatRupiah($totalPendapatan) }}
                </div>

            </div>

        </div>


        @foreach($kelompokPendapatan as $prefix => $namaKelompok)

            @php
                $itemsPendapatan = $pendapatan
                    ->filter(function ($item) use ($prefix) {
                        return str_starts_with(
                            trim($item->kode ?? ''),
                            $prefix . '.'
                        );
                    })
                    ->values();
            @endphp

            @if($itemsPendapatan->isNotEmpty())

                <div class="apbdesa-subsection">

                    <div class="apbdesa-subsection-header">

                        <h3 class="apbdesa-subsection-title">
                            {{ $prefix }} — {{ $namaKelompok }}
                        </h3>

                    </div>


                    @foreach($itemsPendapatan as $item)

                        <div class="apbdesa-item">

                            <div class="apbdesa-item-left">

                                <div class="apbdesa-item-code">
                                    {{ $item->kode }}
                                </div>

                                <div class="apbdesa-item-name">
                                    {{ $item->uraian }}
                                </div>

                            </div>

                            <div class="apbdesa-item-value">
                                {{ $formatRupiah($item->anggaran) }}
                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        @endforeach


        @if($pendapatan->isEmpty())

            <div class="apbdesa-empty">

                <div class="apbdesa-empty-icon">
                    <i class='bx bx-folder-open'></i>
                </div>

                <div class="apbdesa-empty-title">
                    Belum Ada Pendapatan
                </div>

                <div class="apbdesa-empty-text">
                    Belum terdapat pendapatan yang
                    dipublikasikan untuk tahun ini.
                </div>

            </div>

        @endif


        @if($pendapatan->isNotEmpty())

            <div class="apbdesa-summary-block">

                <div class="apbdesa-summary-row">

                    <div class="apbdesa-summary-row-label">
                        Jumlah Pendapatan
                    </div>

                    <div class="apbdesa-summary-row-value">
                        {{ $formatRupiah($totalPendapatan) }}
                    </div>

                </div>

            </div>

        @endif

    </section>


    {{-- =====================================================
         BELANJA
    ====================================================== --}}

    <section class="apbdesa-section">

        <div class="apbdesa-section-header">

            <div>
                <h2 class="apbdesa-section-title">
                    Belanja
                </h2>
            </div>

            <div class="apbdesa-section-total">

                <div class="apbdesa-section-total-value">
                    {{ $formatRupiah($totalBelanja) }}
                </div>

            </div>

        </div>


        @if($belanja->isNotEmpty())

            @php
                $bidangGroups = $belanja->groupBy(
                    function ($item) {
                        return $item->bidang?->id
                            ?? 'tanpa-bidang';
                    }
                );
            @endphp


            @foreach($bidangGroups as $bidangId => $bidangItems)

                @php
                    $bidang = $bidangItems->first()?->bidang;

                    $subBidangGroups = $bidangItems->groupBy(
                        function ($item) {
                            return $item->kegiatan?->sub_bidang_id
                                ?? 'tanpa-sub-bidang';
                        }
                    );
                @endphp


                <div class="apbdesa-bidang">

                    {{-- BIDANG --}}

                    <div class="apbdesa-bidang-header">

                        <div class="apbdesa-bidang-code">
                            {{ $bidang?->kode ?? '—' }}
                        </div>

                        <div class="apbdesa-bidang-name">
                            {{ $bidang?->nama ?? 'Belanja Lainnya' }}
                        </div>

                    </div>


                    {{-- SUB BIDANG --}}

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

                            $subBidangNama = $subBidang
                                ? preg_replace(
                                    '/^\s*sub\s+bidang\s+/i',
                                    '',
                                    trim($subBidang->nama)
                                )
                                : null;
                        @endphp


                        <div class="apbdesa-belanja-subbidang">

                            <div class="apbdesa-belanja-subbidang-title">

                                @if($subBidang)

                                    {{ $subBidang->kode }}
                                    —
                                    Sub Bidang
                                    {{ $subBidangNama }}

                                @else

                                    Sub Bidang Belanja Lainnya

                                @endif

                            </div>


                            {{-- KEGIATAN --}}

                            @foreach($kegiatanGroups as $kegiatanId => $kegiatanItems)

                                @php
                                    $kegiatan =
                                        $kegiatanItems
                                            ->first()?->kegiatan;

                                    $kegiatanTotal =
                                        $kegiatanItems
                                            ->sum('anggaran');
                                @endphp


                                <div class="apbdesa-kegiatan">

                                    <div class="apbdesa-kegiatan-name">

                                        @if($kegiatan)

                                            {{ $kegiatan->kode }}
                                            —
                                            {{ $kegiatan->nama }}

                                        @else

                                            {{ $kegiatanItems->first()->uraian }}

                                        @endif

                                    </div>

                                    <div class="apbdesa-kegiatan-value">
                                        {{ $formatRupiah($kegiatanTotal) }}
                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @endforeach

                </div>

            @endforeach


            {{-- RINGKASAN BELANJA --}}

            <div class="apbdesa-summary-block">

                <div class="apbdesa-summary-row">

                    <div class="apbdesa-summary-row-label">
                        Jumlah Belanja
                    </div>

                    <div class="apbdesa-summary-row-value">
                        {{ $formatRupiah($totalBelanja) }}
                    </div>

                </div>


                <div class="
                    apbdesa-summary-row
                    {{ $surplusDefisit >= 0
                        ? 'apbdesa-surplus'
                        : 'apbdesa-defisit'
                    }}
                ">

                    <div class="apbdesa-summary-row-label">
                        {{ $labelSurplusDefisit }}
                    </div>

                    <div class="apbdesa-summary-row-value">
                        {{ $formatRupiah(abs($surplusDefisit)) }}
                    </div>

                </div>

            </div>


        @else

            <div class="apbdesa-empty">

                <div class="apbdesa-empty-icon">
                    <i class='bx bx-folder-open'></i>
                </div>

                <div class="apbdesa-empty-title">
                    Belum Ada Belanja
                </div>

                <div class="apbdesa-empty-text">
                    Belum terdapat belanja yang
                    dipublikasikan untuk tahun ini.
                </div>

            </div>

        @endif

    </section>


    {{-- =====================================================
         PEMBIAYAAN
    ====================================================== --}}

    <section class="apbdesa-section">

        <div class="apbdesa-section-header">

            <div>
                <h2 class="apbdesa-section-title">
                    Pembiayaan
                </h2>
            </div>

            <div class="apbdesa-section-total">

                <div class="apbdesa-section-total-value">
                    {{ $formatRupiah($totalPembiayaan) }}
                </div>

            </div>

        </div>


        @foreach($kelompokPembiayaan as $prefix => $namaKelompok)

            @php
                $itemsPembiayaan = $pembiayaan
                    ->filter(function ($item) use ($prefix) {
                        return str_starts_with(
                            trim($item->kode ?? ''),
                            $prefix . '.'
                        );
                    })
                    ->values();
            @endphp


            @if($itemsPembiayaan->isNotEmpty())

                <div class="apbdesa-subsection">

                    <div class="apbdesa-subsection-header">

                        <h3 class="apbdesa-subsection-title">
                            {{ $prefix }} — {{ $namaKelompok }}
                        </h3>

                    </div>


                    @foreach($itemsPembiayaan as $item)

                        <div class="apbdesa-item">

                            <div class="apbdesa-item-left">

                                <div class="apbdesa-item-code">
                                    {{ rtrim($item->kode ?? '—', '.') }}
                                </div>

                                <div class="apbdesa-item-name">
                                    {{ $item->uraian }}
                                </div>

                            </div>

                            <div class="apbdesa-item-value">
                                {{ $formatRupiah($item->anggaran) }}
                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        @endforeach


        @if($pembiayaan->isNotEmpty())

            <div class="apbdesa-summary-block">

                <div class="apbdesa-summary-row">

                    <div class="apbdesa-summary-row-label">
                        Pembiayaan Netto
                    </div>

                    <div class="apbdesa-summary-row-value">
                        {{ $formatRupiah($totalPembiayaan) }}
                    </div>

                </div>


                <div class="apbdesa-summary-row">

                    <div class="apbdesa-summary-row-label">
                        Sisa Lebih Pembiayaan Anggaran
                    </div>

                    <div class="apbdesa-summary-row-value">
                        {{ $formatRupiah($silpa) }}
                    </div>

                </div>

            </div>

        @endif


        @if($pembiayaan->isEmpty())

            <div class="apbdesa-empty">

                <div class="apbdesa-empty-icon">
                    <i class='bx bx-folder-open'></i>
                </div>

                <div class="apbdesa-empty-title">
                    Belum Ada Pembiayaan
                </div>

                <div class="apbdesa-empty-text">
                    Belum terdapat pembiayaan yang
                    dipublikasikan untuk tahun ini.
                </div>

            </div>

        @endif

    </section>

</div>

@endsection