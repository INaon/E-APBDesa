@extends('layouts.public')

@section('title', 'Pembiayaan Desa')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA PEMBIAYAAN
    |--------------------------------------------------------------------------
    | Hanya rekening yang mempunyai anggaran > 0 yang ditampilkan.
    */

    $penerimaan = $items
        ->where('jenis', 'penerimaan')
        ->filter(fn ($item) => (float) $item->anggaran > 0);

    $pengeluaran = $items
        ->where('jenis', 'pengeluaran')
        ->filter(fn ($item) => (float) $item->anggaran > 0);

    $totalPenerimaan = $penerimaan->sum('anggaran');
    $totalPengeluaran = $pengeluaran->sum('anggaran');

    $pembiayaanNetto = $totalPenerimaan - $totalPengeluaran;
@endphp


<section class="mx-auto max-w-6xl px-6 py-10 sm:px-8">

    {{-- =====================================================
         HERO
    ====================================================== --}}

    <div
        class="overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-blue-950 to-blue-800 px-7 py-9 text-white shadow-xl sm:px-10"
    >

        <p
            class="text-[11px] font-bold uppercase tracking-[.16em] text-blue-200"
        >
            APBDesa {{ $year->tahun }}
        </p>

        <h1
            class="mt-2 text-3xl font-extrabold tracking-tight sm:text-4xl"
        >
            Pembiayaan Desa
        </h1>

        <p
            class="mt-3 max-w-2xl text-[13px] leading-6 text-slate-200"
        >
            Penerimaan dan pengeluaran pembiayaan yang telah
            dipublikasikan sebagai bagian dari transparansi APBDesa.
        </p>

    </div>


    {{-- =====================================================
         PEMBIAYAAN
    ====================================================== --}}

    <div class="mt-7 grid gap-5 md:grid-cols-2">


        {{-- =================================================
             PENERIMAAN PEMBIAYAAN
        ================================================== --}}

        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >

            <div
                class="border-b border-slate-100 bg-slate-50 px-6 py-5"
            >

                <div class="flex items-center gap-3">

                    <span
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 text-blue-700"
                    >
                        <i class='bx bx-down-arrow-circle text-[20px]'></i>
                    </span>

                    <div>

                        <h2
                            class="text-[15px] font-extrabold text-slate-800"
                        >
                            Penerimaan Pembiayaan
                        </h2>

                        <p
                            class="mt-0.5 text-[11px] text-slate-500"
                        >
                            Rekening penerimaan pembiayaan
                        </p>

                    </div>

                </div>

            </div>


            <div class="divide-y divide-slate-100">

                @forelse($penerimaan as $item)

                    <div
                        class="flex flex-col gap-2 px-6 py-4 transition-colors duration-200 hover:bg-slate-50/70 sm:flex-row sm:items-center sm:justify-between sm:gap-5"
                    >

                        <div class="min-w-0">

                            <div class="flex items-start gap-3">

                                <span
                                    class="w-[75px] shrink-0 text-[12px] font-semibold leading-5 text-blue-700"
                                >
                                    {{ rtrim($item->kode ?? '', '.') }}
                                </span>

                                <span
                                    class="text-[14px] font-medium leading-5 text-slate-700"
                                >
                                    {{ $item->uraian }}
                                </span>

                            </div>

                        </div>

                        <div
                            class="shrink-0 text-left sm:text-right"
                        >

                            <span
                                class="text-[14px] font-extrabold text-slate-900"
                            >
                                Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                @empty

                    <div
                        class="px-6 py-10 text-center"
                    >

                        <i
                            class='bx bx-file-blank text-3xl text-slate-300'
                        ></i>

                        <p
                            class="mt-2 text-[12px] text-slate-500"
                        >
                            Belum ada penerimaan pembiayaan.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- TOTAL PENERIMAAN --}}

            <div
                class="flex items-center justify-between border-t-2 border-slate-200 bg-slate-100 px-6 py-4"
            >

                <span
                    class="text-[13px] font-extrabold text-slate-800"
                >
                    Jumlah Penerimaan
                </span>

                <span
                    class="text-[15px] font-extrabold text-blue-700"
                >
                    Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}
                </span>

            </div>

        </section>


        {{-- =================================================
             PENGELUARAN PEMBIAYAAN
        ================================================== --}}

        <section
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
        >

            <div
                class="border-b border-slate-100 bg-slate-50 px-6 py-5"
            >

                <div class="flex items-center gap-3">

                    <span
                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-rose-100 text-rose-600"
                    >
                        <i class='bx bx-up-arrow-circle text-[20px]'></i>
                    </span>

                    <div>

                        <h2
                            class="text-[15px] font-extrabold text-slate-800"
                        >
                            Pengeluaran Pembiayaan
                        </h2>

                        <p
                            class="mt-0.5 text-[11px] text-slate-500"
                        >
                            Rekening pengeluaran pembiayaan
                        </p>

                    </div>

                </div>

            </div>


            <div class="divide-y divide-slate-100">

                @forelse($pengeluaran as $item)

                    <div
                        class="flex flex-col gap-2 px-6 py-4 transition-colors duration-200 hover:bg-slate-50/70 sm:flex-row sm:items-center sm:justify-between sm:gap-5"
                    >

                        <div class="min-w-0">

                            <div class="flex items-start gap-3">

                                <span
                                    class="w-[75px] shrink-0 text-[12px] font-semibold leading-5 text-blue-700"
                                >
                                    {{ rtrim($item->kode ?? '', '.') }}
                                </span>

                                <span
                                    class="text-[14px] font-medium leading-5 text-slate-700"
                                >
                                    {{ $item->uraian }}
                                </span>

                            </div>

                        </div>

                        <div
                            class="shrink-0 text-left sm:text-right"
                        >

                            <span
                                class="text-[14px] font-extrabold text-slate-900"
                            >
                                Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                            </span>

                        </div>

                    </div>

                @empty

                    <div
                        class="px-6 py-10 text-center"
                    >

                        <i
                            class='bx bx-file-blank text-3xl text-slate-300'
                        ></i>

                        <p
                            class="mt-2 text-[12px] text-slate-500"
                        >
                            Belum ada pengeluaran pembiayaan.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- TOTAL PENGELUARAN --}}

            <div
                class="flex items-center justify-between border-t-2 border-slate-200 bg-slate-100 px-6 py-4"
            >

                <span
                    class="text-[13px] font-extrabold text-slate-800"
                >
                    Jumlah Pengeluaran
                </span>

                <span
                    class="text-[15px] font-extrabold text-rose-600"
                >
                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                </span>

            </div>

        </section>

    </div>


    {{-- =====================================================
         PEMBIAYAAN NETTO
    ====================================================== --}}

    <div
        class="mt-5 flex flex-col gap-3 rounded-2xl bg-blue-900 px-6 py-5 text-white shadow-lg sm:flex-row sm:items-center sm:justify-between"
    >

        <div>

             <div
                class="mt-1 text-[15px] font-extrabold"
            >
                Pembiayaan Netto
            </div>

        </div>

        <div
            class="text-[21px] font-extrabold tracking-tight"
        >
            Rp {{ number_format($pembiayaanNetto, 0, ',', '.') }}
        </div>

    </div>


    {{-- =================================================
         PENJELASAN PEMBIAYAAN DESA
    ================================================== --}}

    <div class="mt-5 px-2 sm:px-6">

        <div class="flex items-start gap-3">

            <div
                class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600"
            >
                <i class='bx bx-info-circle text-[16px]'></i>
            </div>

            <div class="min-w-0">

                <h3
                    class="text-[12px] font-bold text-slate-700"
                >
                    Pengertian Pembiayaan Desa
                </h3>

                <p
                    class="mt-1 text-[12px] leading-6 text-slate-500"
                >
                    Pembiayaan adalah semua penerimaan yang perlu dibayar kembali
                    dan/atau pengeluaran yang akan di diterima kembali, baik pada
                    Tahun Anggaran yang bersangkutan maupun Tahun Anggaran berikutnya.
                </p>

            </div>

        </div>

    </div>


</section>

@endsection