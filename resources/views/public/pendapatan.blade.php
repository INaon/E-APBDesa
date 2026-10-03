@extends('layouts.public')

@section('title', 'Pendapatan Desa')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | KELOMPOK PENDAPATAN
    |--------------------------------------------------------------------------
    | 4.1 = Pendapatan Asli Desa
    | 4.2 = Pendapatan Transfer
    | 4.3 = Pendapatan Lain-lain
    |
    | Hanya rekening yang mempunyai anggaran > 0 yang ditampilkan.
    |--------------------------------------------------------------------------
    */

    $kelompokPendapatan = [
        '4.1' => 'Pendapatan Asli Desa',
        '4.2' => 'Pendapatan Transfer',
        '4.3' => 'Pendapatan Lain-lain',
    ];

    $pendapatanKelompok = [];

    foreach ($kelompokPendapatan as $kode => $nama) {

        $pendapatanKelompok[$kode] = $pendapatan->filter(function ($item) use ($kode) {

            $itemKode = trim((string) $item->kode);

            return str_starts_with($itemKode, $kode . '.')
                && (float) $item->anggaran > 0;

        });

    }
@endphp


<section class="mx-auto max-w-6xl px-6 py-10 sm:px-8">

    {{-- =====================================================
         HERO
    ====================================================== --}}
    <div
        class="overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-blue-800 px-7 py-9 text-white shadow-xl sm:px-10"
    >

        <p class="text-[11px] font-bold uppercase tracking-[.16em] text-blue-200">
            APBDesa {{ $year->tahun }}
        </p>

        <h1 class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl">
            Pendapatan {{ $desa->nama }}
        </h1>

        <p class="mt-3 max-w-2xl text-[13px] leading-6 text-slate-200">
            Rincian sumber pendapatan yang telah dipublikasikan
            sebagai bentuk transparansi anggaran desa.
        </p>


        {{-- TOTAL PENDAPATAN --}}
        <div
            class="mt-6 inline-flex rounded-2xl border border-white/15 bg-white/10 px-5 py-4 backdrop-blur"
        >

            <div>

                <p
                    class="text-[10px] font-bold uppercase tracking-[.12em] text-blue-100"
                >
                    Total Pendapatan
                </p>

                <p class="mt-1 text-2xl font-extrabold tracking-tight">
                    Rp {{ number_format($summary['income'], 0, ',', '.') }}
                </p>

            </div>

        </div>

    </div>


    {{-- =====================================================
         RINCIAN PENDAPATAN
    ====================================================== --}}
    <section
        class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        {{-- HEADER --}}
        <div class="border-b border-slate-100 px-6 py-5">

            <h2 class="text-[16px] font-extrabold text-slate-900">
                Rincian Pendapatan
            </h2>

            <p class="mt-1 text-[12px] leading-5 text-slate-500">
                Data berikut hanya memuat rekening pendapatan yang telah dipublikasikan.
            </p>

        </div>


        {{-- =================================================
             KELOMPOK PENDAPATAN
        ================================================== --}}
        <div>

            @foreach ($pendapatanKelompok as $kodeKelompok => $items)

                @if ($items->isNotEmpty())

                    {{-- =================================================
                         JUDUL KELOMPOK
                    ================================================== --}}
                    <div
                        class="border-b border-slate-200 bg-slate-50 px-6 py-4"
                    >

                        <div class="flex items-center gap-3">

                            {{-- KODE KELOMPOK --}}
                            <span
                                class="inline-flex h-8 min-w-[48px] items-center justify-center rounded-lg bg-blue-100 px-2 text-[12px] font-extrabold text-blue-700"
                            >
                                {{ $kodeKelompok }}
                            </span>


                            {{-- NAMA KELOMPOK --}}
                            <h3
                                class="text-[15px] font-extrabold text-slate-800"
                            >
                                {{ $kelompokPendapatan[$kodeKelompok] }}
                            </h3>

                        </div>

                    </div>


                    {{-- =================================================
                         REKENING PENDAPATAN
                    ================================================== --}}
                    <div class="divide-y divide-slate-100">

                        @foreach ($items as $item)

                            <article
                                class="grid grid-cols-1 gap-3 px-6 py-4 transition-colors duration-200 hover:bg-slate-50/70 sm:grid-cols-[minmax(0,1fr)_230px] sm:items-center sm:gap-8"
                            >

                                {{-- =====================================
                                     KODE + URAIAN
                                ====================================== --}}
                                <div class="min-w-0">

                                    <div
                                        class="flex min-w-0 items-center gap-3"
                                    >

                                        {{-- KODE REKENING --}}
                                        <div
                                            class="w-[82px] shrink-0 text-[12px] font-semibold leading-5 tracking-tight text-blue-700"
                                        >
                                            {{ $item->kode }}
                                        </div>


                                        {{-- URAIAN REKENING --}}
                                        <h4
                                            class="min-w-0 text-[14px] font-medium leading-5 text-slate-700"
                                        >
                                            {{ $item->uraian }}
                                        </h4>

                                    </div>

                                </div>


                                {{-- =====================================
                                     ANGGARAN
                                ====================================== --}}
                                <div
                                    class="sm:min-w-[230px] sm:text-right"
                                >

                                    <p
                                        class="text-[15px] font-extrabold leading-5 tracking-tight text-slate-900"
                                    >
                                        Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                    </p>

                                </div>

                            </article>

                        @endforeach

                    </div>

                @endif

            @endforeach

        </div>


        {{-- =================================================
             TOTAL PENDAPATAN
        ================================================== --}}
        <div
            class="flex flex-col gap-2 border-t-2 border-slate-200 bg-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between"
        >

            <span
                class="text-[14px] font-extrabold text-slate-800"
            >
                Total Pendapatan
            </span>


            <span
                class="text-[17px] font-extrabold tracking-tight text-blue-700"
            >
                Rp {{ number_format($summary['income'], 0, ',', '.') }}
            </span>

                </div>


        {{-- =================================================
             PENJELASAN PENDAPATAN DESA
        ================================================== --}}
        <div
            class="border-t border-slate-200 bg-white px-6 py-5"
        >

            <div class="flex items-start gap-3">

                <div
                    class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
                >
                    <i class='bx bx-info-circle text-[17px]'></i>
                </div>

                <div>

                    <h3
                        class="text-[12px] font-bold text-slate-700"
                    >
                        Pengertian Pendapatan Desa
                    </h3>

                    <p
                        class="mt-1 text-[12px] leading-6 text-slate-500"
                    >
                        Pendapatan Desa adalah semua penerimaan uang melalui
                        Rekening Kas Desa yang merupakan hak Desa dalam
                        1 (satu) Tahun Anggaran yang tidak perlu dibayar
                        kembali oleh Desa.
                    </p>

                </div>

            </div>

        </div>


    </section>

</section>

@endsection