@extends('layouts.admin')

@section('title', 'Realisasi')

@section('content')

<div class="space-y-7">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="text-sm font-semibold text-blue-600">
                Publikasi APBDesa
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Realisasi Anggaran
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola realisasi pendapatan, belanja, dan pembiayaan Desa.
            </p>
        </div>

        <a
            href="{{ route('admin.realisasi.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
        >
            <i class="bx bx-plus text-lg"></i>
            Tambah Realisasi
        </a>

    </div>


    {{-- RINGKASAN --}}
    @php
        $totalIncome = $income->sum('nilai');
        $totalExpense = $expense->sum('nilai');
        $totalFinancing = $financing->sum('nilai');
        $grandTotal = $totalIncome + $totalExpense + $totalFinancing;
    @endphp

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- PENDAPATAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Realisasi Pendapatan
                    </p>

                    <p class="mt-2 text-xl font-bold text-slate-900">
                        Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="bx bx-down-arrow-circle text-xl"></i>
                </div>

            </div>

        </div>


        {{-- BELANJA --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Realisasi Belanja
                    </p>

                    <p class="mt-2 text-xl font-bold text-slate-900">
                        Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <i class="bx bx-up-arrow-circle text-xl"></i>
                </div>

            </div>

        </div>


        {{-- PEMBIAYAAN --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Realisasi Pembiayaan
                    </p>

                    <p class="mt-2 text-xl font-bold text-slate-900">
                        Rp {{ number_format($totalFinancing, 0, ',', '.') }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i class="bx bx-transfer text-xl"></i>
                </div>

            </div>

        </div>


        {{-- TOTAL --}}
        <div class="rounded-2xl border border-slate-200 bg-slate-900 p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-400">
                        Total Realisasi
                    </p>

                    <p class="mt-2 text-xl font-bold text-white">
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-white">
                    <i class="bx bx-calculator text-xl"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- DATA REALISASI --}}
    <div class="space-y-6">

        @foreach([
            'pendapatan' => [
                'items' => $income,
                'label' => 'Pendapatan',
                'icon' => 'bx-down-arrow-circle',
            ],

            'belanja' => [
                'items' => $expense,
                'label' => 'Belanja',
                'icon' => 'bx-up-arrow-circle',
            ],

            'pembiayaan' => [
                'items' => $financing,
                'label' => 'Pembiayaan',
                'icon' => 'bx-transfer',
            ],
        ] as $type => $section)

            @php
                $items = $section['items'];
                $total = $items->sum('nilai');
            @endphp


            <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- SECTION HEADER --}}
                <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                            <i class="bx {{ $section['icon'] }} text-xl"></i>
                        </div>

                        <div>

                            <h2 class="font-bold text-slate-900">
                                Realisasi {{ $section['label'] }}
                            </h2>

                            <p class="text-xs text-slate-500">
                                {{ $items->count() }} data realisasi
                            </p>

                        </div>

                    </div>


                    <div class="text-left sm:text-right">

                        <p class="text-xs font-medium text-slate-500">
                            Total
                        </p>

                        <p class="text-base font-bold text-slate-900">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </p>

                    </div>

                </div>


                @if ($items->count())

                    {{-- TABLE --}}
                    <div class="overflow-x-auto">

                        <table class="w-full min-w-[1050px] text-sm">

                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">

                                <tr>

                                    <th class="w-14 px-5 py-3 text-left">
                                        No
                                    </th>

                                    <th class="w-28 px-4 py-3 text-left">
                                        Tahun
                                    </th>

                                    <th class="w-36 px-4 py-3 text-left">
                                        Kode
                                    </th>

                                    <th class="px-4 py-3 text-left">
                                        Rekening / Uraian
                                    </th>

                                    <th class="w-36 px-4 py-3 text-left">
                                        Tanggal
                                    </th>

                                    <th class="w-44 px-4 py-3 text-right">
                                        Nilai
                                    </th>

                                    <th class="w-32 px-4 py-3 text-center">
                                        Status
                                    </th>

                                    <th class="w-36 px-4 py-3 text-center">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @foreach ($items as $index => $row)

                                    @php
                                        $master = $row->$type;

                                        $kode = $master?->kode ?? '-';
                                        $uraian = $master?->uraian ?? '-';

                                        if ($type === 'pendapatan' && $master?->pendapatanRekening) {
                                            $kode = $master->pendapatanRekening->kode;
                                            $uraian = $master->pendapatanRekening->uraian;
                                        }

                                        if ($type === 'belanja' && $master?->belanjaRekening) {
                                            $kode = $master->belanjaRekening->kode;
                                            $uraian = $master->belanjaRekening->uraian;
                                        }

                                        if ($type === 'pembiayaan' && $master?->pembiayaanRekening) {
                                            $kode = rtrim($master->pembiayaanRekening->kode, '.');
                                            $uraian = $master->pembiayaanRekening->uraian;
                                        }
                                    @endphp


                                    <tr class="transition hover:bg-slate-50">

                                        {{-- NO --}}
                                        <td class="px-5 py-4 font-medium text-slate-500">
                                            {{ $index + 1 }}
                                        </td>


                                        {{-- TAHUN --}}
                                        <td class="px-4 py-4 text-slate-600">
                                            {{ $master?->tahunAnggaran?->tahun ?? '-' }}
                                        </td>


                                        {{-- KODE --}}
                                        <td class="px-4 py-4">

                                            <span class="font-mono text-xs font-semibold text-slate-600">
                                                {{ $kode }}
                                            </span>

                                        </td>


                                        {{-- URAIAN --}}
                                        <td class="px-4 py-4">

                                            <div class="font-medium text-slate-800">
                                                {{ $uraian }}
                                            </div>

                                            @if ($row->keterangan)

                                                <div class="mt-1 max-w-md truncate text-xs text-slate-400">
                                                    {{ $row->keterangan }}
                                                </div>

                                            @endif

                                        </td>


                                        {{-- TANGGAL --}}
                                        <td class="px-4 py-4 text-slate-600">
                                            {{ $row->tanggal?->format('d/m/Y') ?? '-' }}
                                        </td>


                                        {{-- NILAI --}}
                                        <td class="px-4 py-4 text-right">

                                            <span class="font-semibold text-slate-800">
                                                Rp {{ number_format($row->nilai, 0, ',', '.') }}
                                            </span>

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-4 py-4 text-center">

                                            @if ($row->status_publikasi === 'dipublikasikan')

                                                <span class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                                    <i class="bx bx-check-circle"></i>
                                                    Publikasi
                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                                    <i class="bx bx-file"></i>
                                                    Draft
                                                </span>

                                            @endif

                                        </td>


                                        {{-- AKSI --}}
                                        <td class="px-4 py-4">

                                            <div class="flex items-center justify-center gap-2">

                                                {{-- EDIT --}}
                                                <a
                                                    href="{{ route('admin.realisasi.edit', [$type, $row->id]) }}"
                                                    title="Edit"
                                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600"
                                                >
                                                    <i class="bx bx-edit text-lg"></i>
                                                </a>


                                                {{-- PUBLIKASI / JADIKAN DRAFT --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.realisasi.publication', [$type, $row->id]) }}"
                                                >

                                                    @csrf
                                                    @method('PATCH')

                                                    <button
                                                        type="submit"
                                                        title="{{ $row->status_publikasi === 'dipublikasikan' ? 'Jadikan Draft' : 'Publikasikan' }}"
                                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                                    >

                                                        @if ($row->status_publikasi === 'dipublikasikan')

                                                            {{-- SUDAH DIPUBLIKASIKAN --}}
                                                            <i class="bx bx-file text-lg"></i>

                                                        @else

                                                            {{-- MASIH DRAFT --}}
                                                            <i class="bx bx-globe text-lg"></i>

                                                        @endif

                                                    </button>

                                                </form>


                                                {{-- HAPUS --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.realisasi.destroy', [$type, $row->id]) }}"
                                                    onsubmit="return confirm('Hapus data realisasi ini?')"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        title="Hapus"
                                                        class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                                    >

                                                        <i class="bx bx-trash text-lg"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    {{-- EMPTY --}}
                    <div class="flex flex-col items-center justify-center px-6 py-14 text-center">

                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <i class="bx bx-bar-chart-alt-2 text-2xl"></i>
                        </div>

                        <h3 class="mt-4 font-semibold text-slate-700">
                            Belum ada realisasi
                        </h3>

                        <p class="mt-1 text-sm text-slate-400">
                            Belum terdapat data realisasi {{ strtolower($section['label']) }}.
                        </p>

                    </div>

                @endif

            </section>

        @endforeach

    </div>

</div>

@endsection