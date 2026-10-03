@extends('layouts.admin')

@section('title', 'Belanja')

@section('content')

<style>
    .belanja-table {
        table-layout: fixed;
    }

    .belanja-table th {
        white-space: nowrap;
    }

    .belanja-table tbody tr {
        transition: background-color .15s ease;
    }

    .belanja-code {
        font-variant-numeric: tabular-nums;
        letter-spacing: .01em;
    }

    .belanja-description {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        line-height: 1.45;
    }

    .belanja-action {
        transition:
            background-color .15s ease,
            border-color .15s ease,
            color .15s ease,
            transform .15s ease;
    }

    .belanja-action:hover {
        transform: translateY(-1px);
    }

    .belanja-summary-card {
        position: relative;
        overflow: hidden;
    }

    .belanja-summary-card::after {
        content: "";
        position: absolute;
        right: -35px;
        top: -35px;
        width: 100px;
        height: 100px;
        border-radius: 999px;
        background: rgba(59, 130, 246, .05);
        pointer-events: none;
    }

    .belanja-table .col-no {
        width: 48px;
    }

    .belanja-table .col-tahun {
        width: 72px;
    }

    .belanja-table .col-bidang {
        width: 145px;
    }

    .belanja-table .col-sub-bidang {
        width: 170px;
    }

    .belanja-table .col-kegiatan {
        width: 205px;
    }

    .belanja-table .col-rekening {
        width: 185px;
    }

    .belanja-table .col-anggaran {
        width: 135px;
    }

    .belanja-table .col-status {
        width: 125px;
    }

    .belanja-table .col-aksi {
        width: 150px;
    }

    @media (max-width: 1023px) {
        .belanja-table {
            min-width: 1180px;
        }
    }

    @media (min-width: 1024px) {
        .belanja-table {
            min-width: 0;
            width: 100%;
        }
    }
</style>


<div class="space-y-5">

    {{-- =====================================================
         HEADER
         ====================================================== --}}

    <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

        <div class="min-w-0">

            <div class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">
                Publikasi APBDesa
            </div>

            <h1 class="mt-1 text-2xl font-semibold text-slate-900">
                Belanja
            </h1>

            <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-500">
                Kelola anggaran belanja berdasarkan struktur master SiskeuDes:
                Bidang, Sub Bidang, Kegiatan, dan Rekening Belanja.
            </p>

        </div>


        {{-- =================================================
             ACTION BUTTON
             ================================================== --}}

        <div class="flex shrink-0 flex-wrap items-center gap-2">

            {{-- HAPUS SEMUA --}}

            @if($items->total() > 0)

                <form method="POST"
                      action="{{ route('admin.belanja.destroyAll') }}"
                      onsubmit="return confirm('PERINGATAN!\\n\\nApakah Anda yakin ingin menghapus SEMUA data belanja?\\n\\nSemua data belanja akan dihapus dan tidak dapat dikembalikan.\\n\\nKlik OK untuk melanjutkan.')">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-red-200 bg-red-50 px-3.5 text-sm font-semibold text-red-600 shadow-sm transition hover:border-red-300 hover:bg-red-100">

                        <svg class="h-4 w-4 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 6h18"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 6V4h8v2"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M19 6l-1 14H6L5 6"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M10 11v5"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M14 11v5"/>

                        </svg>

                        Hapus Semua

                    </button>

                </form>

            @endif


            {{-- IMPORT EXCEL --}}

            <a href="{{ route('admin.belanja.import.form') }}"
               class="inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl border border-blue-200 bg-blue-50 px-3.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-100">

                <svg class="h-4 w-4 shrink-0"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 3v12"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M7 10l5 5 5-5"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 21h14"/>

                </svg>

                Import Excel

            </a>


            {{-- TAMBAH BELANJA --}}

            <a href="{{ route('admin.belanja.create') }}"
               class="inline-flex h-10 items-center justify-center gap-2 whitespace-nowrap rounded-xl bg-blue-600 px-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                <svg class="h-4 w-4 shrink-0"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          d="M12 5v14"/>

                    <path stroke-linecap="round"
                          d="M5 12h14"/>

                </svg>

                Tambah Belanja

            </a>

        </div>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
         ====================================================== --}}

    @if(session('success'))

        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">

            <svg class="mt-0.5 h-5 w-5 shrink-0"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.8">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12l2 2 4-4"/>

                <circle cx="12"
                        cy="12"
                        r="9"/>

            </svg>

            <div>
                {{ session('success') }}
            </div>

        </div>

    @endif


    {{-- =====================================================
         SUMMARY
         ====================================================== --}}

    @if($items->count())

        <div class="grid gap-4 sm:grid-cols-2">

            {{-- JUMLAH DATA --}}

            <div class="belanja-summary-card rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex items-center justify-between gap-4">

                    <div>

                        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Jumlah Data
                        </div>

                        <div class="mt-1.5 text-2xl font-bold text-slate-900">
                            {{ number_format($items->total(), 0, ',', '.') }}
                        </div>

                        <div class="mt-0.5 text-xs text-slate-500">
                            Total data belanja
                        </div>

                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 6h13"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 12h13"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M8 18h13"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 6h.01"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 12h.01"/>

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 18h.01"/>

                        </svg>

                    </div>

                </div>

            </div>


            {{-- TOTAL ANGGARAN --}}

            <div class="belanja-summary-card rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="flex items-center justify-between gap-4">

                    <div class="min-w-0">

                        <div class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                            Total Anggaran
                        </div>

                        <div class="mt-1.5 truncate text-2xl font-bold text-slate-900">
                            Rp {{ number_format($items->sum(fn($item) => (float) $item->anggaran), 0, ',', '.') }}
                        </div>

                        <div class="mt-0.5 text-xs text-slate-500">
                            Total pada halaman aktif
                        </div>

                    </div>

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <rect x="3"
                                  y="5"
                                  width="18"
                                  height="14"
                                  rx="2"/>

                            <path stroke-linecap="round"
                                  d="M3 10h18"/>

                            <path stroke-linecap="round"
                                  d="M7 15h3"/>

                        </svg>

                    </div>

                </div>

            </div>

        </div>

    @endif


    {{-- =====================================================
         TABLE
         ====================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- TABLE HEADER --}}

        <div class="flex flex-col gap-2 border-b border-slate-100 px-4 py-3.5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h2 class="text-base font-semibold text-slate-900">
                    Daftar Belanja
                </h2>

                <p class="mt-0.5 text-xs text-slate-500">
                    Data anggaran belanja yang tersimpan dalam aplikasi.
                </p>

            </div>

            <div class="shrink-0 text-xs text-slate-400">
                {{ $items->count() }} data pada halaman ini
            </div>

        </div>


        {{-- =================================================
             TABLE
             ================================================== --}}

        <div class="overflow-x-auto">

            <table class="belanja-table w-full text-left text-sm">

                <colgroup>
                    <col class="col-no">
                    <col class="col-tahun">
                    <col class="col-bidang">
                    <col class="col-sub-bidang">
                    <col class="col-kegiatan">
                    <col class="col-rekening">
                    <col class="col-anggaran">
                    <col class="col-status">
                    <col class="col-aksi">
                </colgroup>

                <thead class="border-b border-slate-200 bg-slate-50">

                    <tr>

                        <th class="px-2.5 py-3 text-center text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            No
                        </th>

                        <th class="px-2.5 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Tahun
                        </th>

                        <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Bidang
                        </th>

                        <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Sub Bidang
                        </th>

                        <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Kegiatan
                        </th>

                        <th class="px-3 py-3 text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Rekening Belanja
                        </th>

                        <th class="px-3 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Anggaran
                        </th>

                        <th class="px-2 py-3 text-center text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-2.5 py-3 text-right text-[11px] font-semibold uppercase tracking-wide text-slate-500">
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                @forelse($items as $item)

                    <tr class="hover:bg-slate-50/80">

                        {{-- NO --}}

                        <td class="px-2.5 py-3.5 text-center align-top text-xs font-medium text-slate-400">

                            {{ $items->firstItem() + $loop->index }}

                        </td>


                        {{-- TAHUN --}}

                        <td class="px-2.5 py-3.5 align-top">

                            <span class="inline-flex rounded-lg bg-slate-100 px-2 py-1 text-[11px] font-bold text-slate-700">

                                {{ $item->tahunAnggaran?->tahun ?? '-' }}

                            </span>

                        </td>


                        {{-- BIDANG --}}

                        <td class="px-3 py-3.5 align-top">

                            <div class="belanja-code text-xs font-bold text-slate-800">
                                {{ $item->bidang?->kode ?? '-' }}
                            </div>

                            <div class="belanja-description mt-1 text-[11px] text-slate-500"
                                 title="{{ $item->bidang?->nama ?? '-' }}">

                                {{ $item->bidang?->nama ?? '-' }}

                            </div>

                        </td>


                        {{-- SUB BIDANG --}}

                        <td class="px-3 py-3.5 align-top">

                            <div class="belanja-code text-xs font-bold text-slate-800">
                                {{ $item->kegiatan?->subBidang?->kode ?? '-' }}
                            </div>

                            <div class="belanja-description mt-1 text-[11px] text-slate-500"
                                 title="{{ $item->kegiatan?->subBidang?->nama ?? '-' }}">

                                {{ $item->kegiatan?->subBidang?->nama ?? '-' }}

                            </div>

                        </td>


                        {{-- KEGIATAN --}}

                        <td class="px-3 py-3.5 align-top">

                            <div class="belanja-code text-xs font-bold text-slate-800">
                                {{ $item->kegiatan?->kode ?? '-' }}
                            </div>

                            <div class="belanja-description mt-1 text-[11px] text-slate-500"
                                 title="{{ $item->kegiatan?->nama ?? '-' }}">

                                {{ $item->kegiatan?->nama ?? '-' }}

                            </div>

                        </td>


                        {{-- REKENING --}}

                        <td class="px-3 py-3.5 align-top">

                            <div class="belanja-code text-xs font-bold text-blue-700">
                                {{ $item->kode }}
                            </div>

                            <div class="belanja-description mt-1 text-[11px] text-slate-500"
                                 title="{{ $item->uraian }}">

                                {{ $item->uraian }}

                            </div>

                        </td>


                        {{-- ANGGARAN --}}

                        <td class="px-3 py-3.5 text-right align-top">

                            <div class="whitespace-nowrap text-xs font-bold text-slate-900">

                                Rp {{ number_format((float) $item->anggaran, 0, ',', '.') }}

                            </div>

                        </td>


                        {{-- STATUS --}}

                        <td class="px-2 py-3.5 text-center align-top">

                            <form method="POST"
                                  action="{{ route('admin.belanja.publication', $item) }}">

                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        title="Klik untuk mengubah status publikasi"
                                        class="inline-flex max-w-full items-center justify-center gap-1.5 rounded-full px-2.5 py-1.5 text-[10px] font-semibold transition hover:opacity-80
                                        {{ $item->status_publikasi === 'dipublikasikan'
                                            ? 'bg-emerald-100 text-emerald-700'
                                            : 'bg-slate-100 text-slate-600' }}">

                                    <span class="h-1.5 w-1.5 shrink-0 rounded-full
                                        {{ $item->status_publikasi === 'dipublikasikan'
                                            ? 'bg-emerald-500'
                                            : 'bg-slate-400' }}">
                                    </span>

                                    <span class="truncate">
                                        {{ $item->status_publikasi === 'dipublikasikan'
                                            ? 'Dipublikasikan'
                                            : 'Draft' }}
                                    </span>

                                </button>

                            </form>

                        </td>


                        {{-- AKSI --}}

                        <td class="px-2.5 py-3.5 align-top">

                            <div class="flex items-center justify-end gap-1.5">

                                {{-- EDIT --}}

                                <a href="{{ route('admin.belanja.edit', $item) }}"
                                   title="Edit data"
                                   class="belanja-action inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">

                                    <svg class="h-3.5 w-3.5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 20h9"/>

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M16.5 3.5a2.12 2.12 0 013 3L8 18l-4 1 1-4L16.5 3.5z"/>

                                    </svg>

                                </a>


                                {{-- HAPUS --}}

                                <form method="POST"
                                      action="{{ route('admin.belanja.destroy', $item) }}"
                                      onsubmit="return confirm('Hapus data belanja ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            title="Hapus data"
                                            class="belanja-action inline-flex h-8 w-8 items-center justify-center rounded-lg border border-red-200 bg-white text-red-600 hover:bg-red-50">

                                        <svg class="h-3.5 w-3.5"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M3 6h18"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M8 6V4h8v2"/>

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M19 6l-1 14H6L5 6"/>

                                        </svg>

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>


                @empty

                    {{-- =================================================
                         EMPTY STATE
                         ================================================== --}}

                    <tr>

                        <td colspan="9"
                            class="px-6 py-16 text-center">

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                <svg class="h-7 w-7"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.6">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M7 3h7l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M14 3v5h5"/>

                                </svg>

                            </div>

                            <h3 class="mt-4 text-sm font-semibold text-slate-800">
                                Belum ada data belanja
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Tambahkan data secara manual atau gunakan Import Excel.
                            </p>

                            <div class="mt-5 flex flex-wrap justify-center gap-2">

                                <a href="{{ route('admin.belanja.import.form') }}"
                                   class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 hover:bg-blue-100">

                                    Import Excel

                                </a>

                                <a href="{{ route('admin.belanja.create') }}"
                                   class="rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">

                                    Tambah Belanja

                                </a>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             PAGINATION
             ================================================== --}}

        @if($items->hasPages())

            <div class="border-t border-slate-100 px-4 py-4">

                {{ $items->links() }}

            </div>

        @endif

    </div>

</div>

@endsection