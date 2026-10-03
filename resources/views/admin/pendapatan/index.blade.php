@extends('layouts.admin')

@section('title', 'Pendapatan')

@section('content')

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>
            <p class="text-sm font-medium text-blue-600">
                Publikasi APBDesa
            </p>

            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">
                Pendapatan Desa
            </h1>

            <p class="mt-2 text-sm text-slate-500">
                Kelola data anggaran pendapatan yang akan ditampilkan kepada masyarakat.
            </p>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex flex-wrap items-center gap-2">

            {{-- Download Template --}}
            <a
                href="{{ route('admin.pendapatan.template') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                <i class='bx bx-download text-lg'></i>
                Download Template
            </a>

            {{-- Import Excel --}}
            <a
                href="{{ route('admin.pendapatan.import.form') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                <i class='bx bx-import text-lg'></i>
                Import Excel
            </a>

            {{-- Tambah Pendapatan --}}
            <a
                href="{{ route('admin.pendapatan.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                <i class='bx bx-plus text-lg'></i>
                Tambah Pendapatan
            </a>

        </div>

    </div>

    {{-- Daftar Pendapatan --}}
    <section class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-semibold text-slate-900">
                Daftar Pendapatan
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-[860px] w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">

                    <tr>

                        <th class="px-6 py-4">
                            No
                        </th>

                        <th class="px-6 py-4">
                            Kode Rekening
                        </th>

                        <th class="px-6 py-4">
                            Uraian Pendapatan
                        </th>

                        <th class="px-6 py-4">
                            Tahun
                        </th>

                        <th class="px-6 py-4 text-right">
                            Anggaran
                        </th>

                        <th class="px-6 py-4">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($pendapatan as $item)

                        <tr class="transition hover:bg-slate-50/80">

                            {{-- No --}}
                            <td class="px-6 py-4 text-slate-500">
                                {{ $pendapatan->firstItem() + $loop->index }}
                            </td>

                            {{-- Kode --}}
                            <td class="px-6 py-4 font-semibold text-blue-700">
                                {{ $item->kode }}
                            </td>

                            {{-- Uraian --}}
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $item->uraian }}
                            </td>

                            {{-- Tahun --}}
                            <td class="px-6 py-4 font-medium text-slate-600">
                                {{ $item->tahunAnggaran->tahun }}
                            </td>

                            {{-- Anggaran --}}
                            <td class="px-6 py-4 text-right font-semibold text-slate-800">
                                Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">

                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item->status_publikasi === 'dipublikasikan'
                                        ? 'bg-emerald-50 text-emerald-700'
                                        : 'bg-amber-50 text-amber-700' }}"
                                >
                                    {{ $item->status_publikasi === 'dipublikasikan'
                                        ? 'Dipublikasikan'
                                        : 'Draft' }}
                                </span>

                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('admin.pendapatan.edit', $item) }}"
                                        class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700"
                                        aria-label="Ubah {{ $item->uraian }}"
                                        title="Ubah"
                                    >
                                        <i class='bx bx-pencil text-lg'></i>
                                    </a>

                                    {{-- Publikasi --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.pendapatan.publication', $item) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700"
                                            aria-label="{{ $item->status_publikasi === 'dipublikasikan'
                                                ? 'Batalkan publikasi'
                                                : 'Publikasikan' }} {{ $item->uraian }}"
                                            title="{{ $item->status_publikasi === 'dipublikasikan'
                                                ? 'Batalkan Publikasi'
                                                : 'Publikasikan' }}"
                                        >

                                            <i
                                                class='bx {{ $item->status_publikasi === 'dipublikasikan'
                                                    ? 'bx-hide'
                                                    : 'bx-show' }} text-lg'
                                            ></i>

                                        </button>

                                    </form>

                                    {{-- Hapus --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.pendapatan.destroy', $item) }}"
                                        onsubmit="return confirm('Hapus data pendapatan ini?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-700"
                                            aria-label="Hapus {{ $item->uraian }}"
                                            title="Hapus"
                                        >

                                            <i class='bx bx-trash text-lg'></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-16 text-center"
                            >

                                <i class='bx bx-folder-open text-4xl text-slate-300'></i>

                                <p class="mt-3 font-semibold text-slate-700">
                                    Belum ada data pendapatan
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Mulai dengan menambahkan anggaran pendapatan desa.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pagination --}}
        @if ($pendapatan->hasPages())

            <div class="border-t border-slate-100 px-6 py-4">

                {{ $pendapatan->links() }}

            </div>

        @endif

    </section>

@endsection