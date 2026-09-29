@extends('layouts.public')

@section('title', 'Beranda')

@section('content')

<style>
    .apb-home {
        overflow: hidden;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .apb-hero {
        position: relative;
        min-height: 560px;

        display: flex;
        align-items: center;

        padding: 70px 6%;

        background:
            linear-gradient(
                135deg,
                rgba(15, 23, 42, .94),
                rgba(30, 64, 175, .84)
            );

        color: white;

        overflow: hidden;
    }

    .apb-hero::before {
        content: "";

        position: absolute;

        width: 500px;
        height: 500px;

        border-radius: 50%;

        background: rgba(96, 165, 250, .16);

        top: -180px;
        right: -120px;

        filter: blur(10px);
    }

    .apb-hero::after {
        content: "";

        position: absolute;

        width: 350px;
        height: 350px;

        border-radius: 50%;

        background: rgba(14, 165, 233, .12);

        bottom: -180px;
        left: -100px;

        filter: blur(10px);
    }

    .apb-hero-container {
        position: relative;
        z-index: 2;

        width: 100%;
        max-width: 1200px;

        margin: auto;
    }

    .apb-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 8px 14px;

        border-radius: 999px;

        background: rgba(255,255,255,.12);

        border: 1px solid rgba(255,255,255,.18);

        font-size: 12px;

        color: rgba(255,255,255,.85);

        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .apb-hero h1 {
        max-width: 850px;

        margin-top: 20px;

        font-size: clamp(34px, 6vw, 64px);

        line-height: 1.08;

        font-weight: 800;

        letter-spacing: -1.5px;
    }

    .apb-hero h1 span {
        color: #93c5fd;
    }

    .apb-hero-description {
        max-width: 650px;

        margin-top: 20px;

        color: rgba(255,255,255,.75);

        font-size: 16px;

        line-height: 1.8;
    }

    .apb-hero-actions {
        display: flex;
        flex-wrap: wrap;

        gap: 12px;

        margin-top: 30px;
    }

    .apb-btn {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 12px 20px;

        border-radius: 12px;

        text-decoration: none;

        font-size: 14px;

        font-weight: 600;

        transition: .3s;
    }

    .apb-btn-primary {
        color: #0f172a;

        background: white;
    }

    .apb-btn-primary:hover {
        transform: translateY(-2px);

        box-shadow: 0 10px 25px rgba(0,0,0,.18);
    }

    .apb-btn-secondary {
        color: white;

        background: rgba(255,255,255,.1);

        border: 1px solid rgba(255,255,255,.2);

        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .apb-btn-secondary:hover {
        background: rgba(255,255,255,.18);

        transform: translateY(-2px);
    }


    /* =========================================================
       SECTION
    ========================================================= */

    .apb-section {
        max-width: 1200px;

        margin: auto;

        padding: 70px 6%;
    }

    .apb-section-header {
        margin-bottom: 30px;
    }

    .apb-section-label {
        color: #2563eb;

        font-size: 12px;

        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: 1.5px;
    }

    .apb-section-title {
        margin-top: 7px;

        color: #0f172a;

        font-size: clamp(25px, 4vw, 34px);

        font-weight: 700;
    }

    .apb-section-description {
        margin-top: 8px;

        color: #64748b;

        font-size: 14px;

        line-height: 1.7;
    }


    /* =========================================================
       STATISTIC CARDS
    ========================================================= */

    .apb-stat-grid {
        display: grid;

        grid-template-columns: repeat(3, 1fr);

        gap: 20px;
    }

    .apb-stat-card {
        position: relative;

        padding: 25px;

        border-radius: 22px;

        background: rgba(255,255,255,.72);

        border: 1px solid rgba(255,255,255,.7);

        box-shadow:
            0 15px 40px rgba(15,23,42,.08);

        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);

        overflow: hidden;

        transition: .3s;
    }

    .apb-stat-card:hover {
        transform: translateY(-5px);

        box-shadow:
            0 20px 45px rgba(15,23,42,.13);
    }

    .apb-stat-card::before {
        content: "";

        position: absolute;

        width: 120px;
        height: 120px;

        border-radius: 50%;

        background: rgba(37,99,235,.07);

        right: -45px;
        top: -45px;
    }

    .apb-card-icon {
        position: relative;

        width: 48px;
        height: 48px;

        display: flex;

        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: #eff6ff;

        color: #2563eb;

        font-size: 24px;
    }

    .apb-card-label {
        margin-top: 20px;

        color: #64748b;

        font-size: 13px;

        font-weight: 500;
    }

    .apb-card-value {
        margin-top: 6px;

        color: #0f172a;

        font-size: clamp(21px, 3vw, 29px);

        font-weight: 700;

        word-break: break-word;
    }


    /* =========================================================
       REALISASI
    ========================================================= */

    .apb-realisasi {
        margin-top: 20px;

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 20px;
    }

    .apb-progress-card {
        padding: 25px;

        border-radius: 22px;

        background: #0f172a;

        color: white;

        box-shadow:
            0 15px 40px rgba(15,23,42,.14);
    }

    .apb-progress-header {
        display: flex;

        justify-content: space-between;

        align-items: center;

        gap: 20px;
    }

    .apb-progress-title {
        font-size: 14px;

        color: rgba(255,255,255,.7);
    }

    .apb-progress-percent {
        margin-top: 4px;

        font-size: 27px;

        font-weight: 700;
    }

    .apb-progress-track {
        height: 10px;

        margin-top: 20px;

        border-radius: 999px;

        background: rgba(255,255,255,.1);

        overflow: hidden;
    }

    .apb-progress-bar {
        height: 100%;

        border-radius: inherit;

        background: #60a5fa;

        transition: width .8s ease;
    }

    .apb-progress-info {
        margin-top: 15px;

        display: flex;

        justify-content: space-between;

        gap: 10px;

        font-size: 12px;

        color: rgba(255,255,255,.55);
    }

    .apb-progress-info strong {
        color: rgba(255,255,255,.9);
    }


    /* =========================================================
       PEMBIAYAAN / SURPLUS
    ========================================================= */

    .apb-finance-grid {
        display: grid;

        grid-template-columns: repeat(2, 1fr);

        gap: 20px;

        margin-top: 20px;
    }

    .apb-finance-card {
        padding: 24px;

        border-radius: 22px;

        background: white;

        border: 1px solid #e2e8f0;

        box-shadow:
            0 12px 35px rgba(15,23,42,.06);
    }

    .apb-finance-title {
        display: flex;

        align-items: center;

        gap: 10px;

        color: #475569;

        font-size: 13px;

        font-weight: 600;
    }

    .apb-finance-title i {
        color: #2563eb;

        font-size: 21px;
    }

    .apb-finance-value {
        margin-top: 8px;

        color: #0f172a;

        font-size: 24px;

        font-weight: 700;
    }


    /* =========================================================
       INFORMATION
    ========================================================= */

    .apb-info-card {
        padding: 25px;

        border-radius: 22px;

        background: white;

        border: 1px solid #e2e8f0;

        box-shadow:
            0 12px 35px rgba(15,23,42,.06);
    }

    .apb-info-title {
        display: flex;

        align-items: center;

        gap: 9px;

        color: #0f172a;

        font-size: 16px;

        font-weight: 700;
    }

    .apb-info-title i {
        color: #2563eb;

        font-size: 22px;
    }

    .apb-info-text {
        margin-top: 12px;

        color: #64748b;

        font-size: 13px;

        line-height: 1.8;
    }


    /* =========================================================
       MOBILE / TABLET
    ========================================================= */

    @media (max-width: 900px) {

        .apb-stat-grid {
            grid-template-columns: 1fr 1fr;
        }

        .apb-realisasi {
            grid-template-columns: 1fr;
        }

        .apb-finance-grid {
            grid-template-columns: 1fr;
        }

    }


    @media (max-width: 600px) {

        .apb-hero {
            min-height: 520px;

            padding: 55px 6%;
        }

        .apb-hero h1 {
            font-size: 36px;
        }

        .apb-hero-description {
            font-size: 14px;
        }

        .apb-stat-grid {
            grid-template-columns: 1fr;
        }

        .apb-section {
            padding-top: 50px;

            padding-bottom: 50px;
        }

        .apb-hero-actions {
            flex-direction: column;

            align-items: stretch;
        }

        .apb-btn {
            width: 100%;
        }

        .apb-progress-percent {
            font-size: 23px;
        }

    }
</style>


<div class="apb-home">


    {{-- =====================================================
         HERO
    ====================================================== --}}

    <section class="apb-hero">

        <div class="apb-hero-container">

            <div class="apb-badge">

                <i class='bx bx-shield-quarter'></i>

                Publikasi APB Desa

                <span>•</span>

                Tahun {{ $year->tahun }}

            </div>


            <h1>

                Transparansi Anggaran

                <span>Desa Sumber Jaya</span>

            </h1>


            <p class="apb-hero-description">

                e-APBDesa merupakan media publikasi informasi
                Anggaran Pendapatan dan Belanja Desa secara
                terbuka dan mudah diakses oleh masyarakat.

            </p>


            <div class="apb-hero-actions">

                <a
                    href="{{ route('apbdesa', $year->tahun) }}"
                    class="apb-btn apb-btn-primary"
                >

                    <i class='bx bx-bar-chart-alt-2'></i>

                    Lihat APBDesa

                </a>


                <a
                    href="{{ route('realisasi', $year->tahun) }}"
                    class="apb-btn apb-btn-secondary"
                >

                    <i class='bx bx-line-chart'></i>

                    Lihat Realisasi

                </a>

            </div>

        </div>

    </section>


    {{-- =====================================================
         RINGKASAN APBDESA
    ====================================================== --}}

    <section class="apb-section">

        <div class="apb-section-header">

            <div class="apb-section-label">
                Ringkasan Anggaran
            </div>


            <div class="apb-section-title">

                APBDesa Tahun {{ $year->tahun }}

            </div>


            <p class="apb-section-description">

                Ringkasan anggaran Desa Sumber Jaya berdasarkan
                data APBDesa tahun berjalan.

            </p>

        </div>


        <div class="apb-stat-grid">


            {{-- =================================================
                 PENDAPATAN
            ================================================== --}}

            <div class="apb-stat-card">

                <div class="apb-card-icon">

                    <i class='bx bx-money'></i>

                </div>


                <div class="apb-card-label">

                    Total Pendapatan

                </div>


                <div class="apb-card-value">

                    Rp {{ number_format($summary['income'], 0, ',', '.') }}

                </div>

            </div>


            {{-- =================================================
                 BELANJA
            ================================================== --}}

            <div class="apb-stat-card">

                <div class="apb-card-icon">

                    <i class='bx bx-cart'></i>

                </div>


                <div class="apb-card-label">

                    Total Belanja

                </div>


                <div class="apb-card-value">

                    Rp {{ number_format($summary['expense'], 0, ',', '.') }}

                </div>

            </div>


            {{-- =================================================
                 PEMBIAYAAN NETO
            ================================================== --}}

            <div class="apb-stat-card">

                <div class="apb-card-icon">

                    <i class='bx bx-transfer-alt'></i>

                </div>


                <div class="apb-card-label">

                    Pembiayaan Neto

                </div>


                <div class="apb-card-value">

                    Rp {{ number_format($summary['netFinancing'], 0, ',', '.') }}

                </div>

            </div>


        </div>


        {{-- =====================================================
             REALISASI
        ====================================================== --}}

        <div class="apb-realisasi">


            {{-- REALISASI PENDAPATAN --}}

            <div class="apb-progress-card">

                <div class="apb-progress-header">

                    <div>

                        <div class="apb-progress-title">

                            Realisasi Pendapatan

                        </div>


                        <div class="apb-progress-percent">

                            Rp {{ number_format($summary['incomeReal'], 0, ',', '.') }}

                        </div>

                    </div>

                </div>


                <div class="apb-progress-track">

                    <div
                        class="apb-progress-bar"
                        style="width: {{ min(100, max(0, $summary['incomeRate'])) }}%;"
                    ></div>

                </div>


                <div class="apb-progress-info">

                    <span>

                        Realisasi

                        <strong>
                            {{ number_format($summary['incomeRate'], 2, ',', '.') }}%
                        </strong>

                    </span>


                    <span>

                        Anggaran

                        <strong>
                            Rp {{ number_format($summary['income'], 0, ',', '.') }}
                        </strong>

                    </span>

                </div>

            </div>


            {{-- REALISASI BELANJA --}}

            <div class="apb-progress-card">

                <div class="apb-progress-header">

                    <div>

                        <div class="apb-progress-title">

                            Realisasi Belanja

                        </div>


                        <div class="apb-progress-percent">

                            Rp {{ number_format($summary['expenseReal'], 0, ',', '.') }}

                        </div>

                    </div>

                </div>


                <div class="apb-progress-track">

                    <div
                        class="apb-progress-bar"
                        style="width: {{ min(100, max(0, $summary['expenseRate'])) }}%;"
                    ></div>

                </div>


                <div class="apb-progress-info">

                    <span>

                        Realisasi

                        <strong>
                            {{ number_format($summary['expenseRate'], 2, ',', '.') }}%
                        </strong>

                    </span>


                    <span>

                        Anggaran

                        <strong>
                            Rp {{ number_format($summary['expense'], 0, ',', '.') }}
                        </strong>

                    </span>

                </div>

            </div>


        </div>


        {{-- =====================================================
             PEMBIAYAAN & SURPLUS
        ====================================================== --}}

        <div class="apb-finance-grid">


            {{-- PEMBIAYAAN --}}

            <div class="apb-finance-card">

                <div class="apb-finance-title">

                    <i class='bx bx-transfer'></i>

                    Pembiayaan Neto

                </div>


                <div class="apb-finance-value">

                    Rp {{ number_format($summary['netFinancing'], 0, ',', '.') }}

                </div>

            </div>


            {{-- SURPLUS / DEFISIT --}}

            <div class="apb-finance-card">

                <div class="apb-finance-title">

                    <i class='bx bx-calculator'></i>

                    Surplus / Defisit

                </div>


                <div class="apb-finance-value">

                    Rp {{ number_format($summary['surplus'], 0, ',', '.') }}

                </div>

            </div>


        </div>

    </section>


    {{-- =====================================================
         INFORMASI
    ====================================================== --}}

    <section
        class="apb-section"
        style="padding-top:0;"
    >

        <div class="apb-info-card">

            <div class="apb-info-title">

                <i class='bx bx-info-circle'></i>

                Tentang e-APBDesa

            </div>


            <p class="apb-info-text">

                e-APBDesa digunakan sebagai sarana publikasi
                informasi Anggaran Pendapatan dan Belanja Desa
                kepada masyarakat. Informasi yang ditampilkan
                disesuaikan dengan data yang telah ditetapkan
                dan dipublikasikan oleh Pemerintah Desa Sumber Jaya.

            </p>

        </div>

    </section>


</div>

@endsection