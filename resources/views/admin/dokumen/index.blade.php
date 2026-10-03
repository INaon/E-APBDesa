@extends('layouts.admin')

@section('title', 'Dokumen Publikasi')

@section('content')

<div class="space-y-7">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <p class="text-sm font-semibold text-blue-600">
                Publikasi APBDesa
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Dokumen Publikasi
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola dokumen yang digunakan untuk transparansi dan publikasi APBDesa.
            </p>

        </div>


        <a
            href="{{ route('admin.dokumen.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
        >
            <i class="bx bx-upload text-lg"></i>
            Unggah Dokumen
        </a>

    </div>


    {{-- RINGKASAN --}}
    @php
        $totalDokumen = $items->total();

        $jumlahPublikasi = $items->getCollection()
            ->where('status_publikasi', 'dipublikasikan')
            ->count();

        $jumlahDraft = $items->getCollection()
            ->where('status_publikasi', 'draft')
            ->count();
    @endphp


    <div class="grid gap-4 sm:grid-cols-3">

        {{-- TOTAL --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Dokumen
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ $totalDokumen }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="bx bx-file text-xl"></i>
                </div>

            </div>

        </div>


        {{-- PUBLIKASI --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Dipublikasikan
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ $jumlahPublikasi }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i class="bx bx-check-circle text-xl"></i>
                </div>

            </div>

        </div>


        {{-- DRAFT --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Draft
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ $jumlahDraft }}
                    </p>

                </div>

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                    <i class="bx bx-file text-xl"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- DATA DOKUMEN --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- SECTION HEADER --}}
        <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                    <i class="bx bx-folder-open text-xl"></i>
                </div>

                <div>

                    <h2 class="font-bold text-slate-900">
                        Daftar Dokumen
                    </h2>

                    <p class="text-xs text-slate-500">
                        Dokumen publikasi APBDesa
                    </p>

                </div>

            </div>

        </div>


        @if ($items->count())

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full min-w-[1000px] text-sm">

                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">

                        <tr>

                            <th class="w-14 px-5 py-3 text-left">
                                No
                            </th>

                            <th class="min-w-[280px] px-4 py-3 text-left">
                                Dokumen
                            </th>

                            <th class="w-44 px-4 py-3 text-left">
                                Kategori
                            </th>

                            <th class="w-28 px-4 py-3 text-left">
                                Tahun
                            </th>

                            <th class="w-36 px-4 py-3 text-center">
                                Status
                            </th>

                            <th class="w-40 px-4 py-3 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @foreach ($items as $index => $item)

                            <tr class="transition hover:bg-slate-50">

                                {{-- NO --}}
                                <td class="px-5 py-4 font-medium text-slate-500">

                                    {{ $items->firstItem() + $index }}

                                </td>


                                {{-- DOKUMEN --}}
                                <td class="px-4 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                                            <i class="bx bxs-file-pdf text-xl"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <div class="font-semibold text-slate-800">
                                                {{ $item->judul }}
                                            </div>

                                            @if ($item->deskripsi)

                                                <div class="mt-1 max-w-xl truncate text-xs text-slate-400">
                                                    {{ $item->deskripsi }}
                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- KATEGORI --}}
                                <td class="px-4 py-4">

                                    <span class="inline-flex rounded-lg bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        {{ $item->kategori }}
                                    </span>

                                </td>


                                {{-- TAHUN --}}
                                <td class="px-4 py-4 text-slate-600">

                                    {{ $item->tahunAnggaran?->tahun ?? '-' }}

                                </td>


                                {{-- STATUS --}}
                                <td class="px-4 py-4 text-center">

                                    @if ($item->status_publikasi === 'dipublikasikan')

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

                                        {{-- LIHAT PDF --}}
                                        <a
                                            href="{{ asset('storage/' . $item->file_path) }}"
                                            target="_blank"
                                            title="Lihat Dokumen"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                        >
                                            <i class="bx bx-show text-lg"></i>
                                        </a>


                                        {{-- EDIT --}}
                                        <a
                                            href="{{ route('admin.dokumen.edit', $item) }}"
                                            title="Edit"
                                            class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600"
                                        >
                                            <i class="bx bx-edit text-lg"></i>
                                        </a>


                                        {{-- PUBLIKASI / JADIKAN DRAFT --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.dokumen.publication', $item) }}"
                                        >

                                            @csrf
                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                title="{{ $item->status_publikasi === 'dipublikasikan' ? 'Jadikan Draft' : 'Publikasikan' }}"
                                                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                            >

                                                @if ($item->status_publikasi === 'dipublikasikan')

                                                    <i class="bx bx-file text-lg"></i>

                                                @else

                                                    <i class="bx bx-globe text-lg"></i>

                                                @endif

                                            </button>

                                        </form>


                                        {{-- HAPUS --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.dokumen.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus dokumen ini?')"
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


            {{-- PAGINATION --}}
            @if ($items->hasPages())

                <div class="border-t border-slate-200 px-5 py-4">

                    {{ $items->links() }}

                </div>

            @endif


        @else

            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center px-6 py-16 text-center">

                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <i class="bx bx-folder-open text-3xl"></i>
                </div>

                <h3 class="mt-5 font-semibold text-slate-700">
                    Belum ada dokumen
                </h3>

                <p class="mt-1 max-w-md text-sm text-slate-400">
                    Belum terdapat dokumen publikasi. Silakan unggah dokumen terlebih dahulu.
                </p>

                
            </div>

        @endif

    </section>

</div>

@endsection