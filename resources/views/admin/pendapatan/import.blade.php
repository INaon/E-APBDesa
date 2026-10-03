@extends('layouts.admin')

@section('title', 'Import Pendapatan')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                Import Data Pendapatan
            </h1>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Import banyak data Pendapatan Desa sekaligus menggunakan file Excel.
            </p>
        </div>

        <a
            href="{{ route('admin.pendapatan.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-200
                   bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm
                   transition hover:bg-gray-50 focus:outline-none focus:ring-2
                   focus:ring-blue-500 focus:ring-offset-2
                   dark:border-gray-700 dark:bg-gray-800
                   dark:text-gray-200 dark:hover:bg-gray-700"
        >
            <i class="bx bx-arrow-back text-lg"></i>
            Kembali
        </a>

    </div>


    {{-- Error --}}
    @if ($errors->any())

        <div class="rounded-2xl border border-red-200 bg-red-50 p-5
                    dark:border-red-900/50 dark:bg-red-950/30">

            <div class="flex items-start gap-3">

                <div class="flex h-10 w-10 shrink-0 items-center justify-center
                            rounded-xl bg-red-100 text-red-600
                            dark:bg-red-900/40 dark:text-red-400">

                    <i class="bx bx-error-circle text-xl"></i>

                </div>

                <div class="min-w-0">

                    <h3 class="font-semibold text-red-800 dark:text-red-300">
                        Import tidak dapat diproses
                    </h3>

                    <ul class="mt-2 space-y-1 text-sm text-red-700 dark:text-red-300">

                        @foreach ($errors->all() as $error)

                            <li class="flex gap-2">
                                <span>•</span>
                                <span>{{ $error }}</span>
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- Success --}}
    @if (session('success'))

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5
                    dark:border-emerald-900/50 dark:bg-emerald-950/30">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl
                            bg-emerald-100 text-emerald-600
                            dark:bg-emerald-900/40 dark:text-emerald-400">

                    <i class="bx bx-check-circle text-xl"></i>

                </div>

                <div>

                    <p class="font-semibold text-emerald-800 dark:text-emerald-300">
                        Import berhasil
                    </p>

                    <p class="mt-1 text-sm text-emerald-700 dark:text-emerald-400">
                        {{ session('success') }}
                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- Main Grid --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- FORM IMPORT --}}
        <div class="lg:col-span-2">

            <div class="overflow-hidden rounded-2xl border border-gray-200
                        bg-white shadow-sm
                        dark:border-gray-700 dark:bg-gray-800">


                {{-- Card Header --}}
                <div class="border-b border-gray-100 px-6 py-5
                            dark:border-gray-700">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center
                                    rounded-xl bg-gray-100 text-gray-700
                                    dark:bg-gray-700 dark:text-gray-200">

                            <i class="bx bx-spreadsheet text-2xl"></i>

                        </div>

                        <div>

                            <h3 class="font-semibold text-gray-900 dark:text-white">
                                Upload File Excel
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Gunakan file Excel sesuai template e-APBDesa.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Form --}}
                <form
                    action="{{ route('admin.pendapatan.import') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-6"
                >

                    @csrf

                    <div
                        x-data="{
                            fileName: '',
                            dragging: false,

                            selectFile(event) {
                                const file = event.target.files[0];

                                if (file) {
                                    this.fileName = file.name;
                                }
                            },

                            dropFile(event) {
                                this.dragging = false;

                                const files = event.dataTransfer.files;

                                if (files.length > 0) {
                                    this.$refs.file.files = files;
                                    this.fileName = files[0].name;
                                }
                            }
                        }"
                        class="space-y-5"
                    >


                        {{-- Upload Area --}}
                        <div
                            @dragover.prevent="dragging = true"
                            @dragleave.prevent="dragging = false"
                            @drop.prevent="dropFile($event)"
                            :class="dragging
                                ? 'border-blue-500 bg-blue-50 dark:border-blue-400 dark:bg-blue-950/30'
                                : 'border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-900/40'"
                            class="rounded-2xl border-2 border-dashed p-8 text-center transition"
                        >

                            <input
                                x-ref="file"
                                type="file"
                                name="file"
                                accept=".xlsx,.xls"
                                class="hidden"
                                @change="selectFile($event)"
                            >


                            {{-- Upload Icon --}}
                            <div
                                class="mx-auto flex h-16 w-16 items-center justify-center
                                       rounded-2xl bg-white text-gray-600 shadow-sm
                                       dark:bg-gray-800 dark:text-gray-300"
                            >

                                <i class="bx bx-cloud-upload text-4xl"></i>

                            </div>


                            {{-- Judul Upload --}}
                            <h4 class="mt-4 text-base font-semibold text-slate-900 dark:text-white">
                                Pilih file Excel
                            </h4>


                            {{-- Keterangan Upload --}}
                            <p class="mt-2 text-sm font-medium text-slate-600 dark:text-slate-300">
                                Seret file ke sini atau pilih dari komputer
                            </p>


                            {{-- Pilih File --}}
                            <button
    type="button"
    @click="$refs.file.click()"
    class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl
           px-6 py-3 text-sm font-semibold shadow-sm transition
           focus:outline-none focus:ring-2 focus:ring-blue-500
           focus:ring-offset-2"
    style="
        background-color: #2563eb !important;
        color: #ffffff !important;
        border: 1px solid #2563eb !important;
    "
>
    <i
        class="bx bx-folder-open text-lg"
        style="color: #ffffff !important;"
    ></i>

    <span style="color: #ffffff !important;">
        Pilih File
    </span>
</button>


                            {{-- File Terpilih --}}
                            <div
                                x-show="fileName"
                                x-cloak
                                class="mx-auto mt-5 max-w-md rounded-xl border
                                       border-gray-200 bg-white px-4 py-3 text-left
                                       dark:border-gray-700 dark:bg-gray-800"
                            >

                                <div class="flex items-center gap-3">

                                    <div
                                        class="flex h-9 w-9 shrink-0 items-center
                                               justify-center rounded-lg bg-gray-100
                                               text-gray-600 dark:bg-gray-700
                                               dark:text-gray-300"
                                    >

                                        <i class="bx bxs-file text-lg"></i>

                                    </div>


                                    <div class="min-w-0 flex-1">

                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            File yang dipilih
                                        </p>

                                        <p
                                            class="truncate text-sm font-semibold
                                                   text-gray-900 dark:text-white"
                                            x-text="fileName"
                                        ></p>

                                    </div>


                                    <i
                                        class="bx bx-check-circle text-xl
                                               text-emerald-500"
                                    ></i>

                                </div>

                            </div>


                            {{-- Format File --}}
                            <p class="mt-5 text-xs text-slate-500 dark:text-slate-400">
                                Format: XLSX atau XLS • Maksimal 5 MB
                            </p>

                        </div>


                        {{-- Informasi --}}
                        <div
                            class="rounded-2xl border border-gray-200 bg-gray-50 p-5
                                   dark:border-gray-700 dark:bg-gray-900/40"
                        >

                            <div class="flex items-start gap-3">

                                <i
                                    class="bx bx-info-circle mt-0.5 text-xl
                                           text-gray-500 dark:text-gray-400"
                                ></i>


                                <div class="text-sm text-gray-600 dark:text-gray-300">

                                    <p
                                        class="font-semibold text-gray-800
                                               dark:text-gray-200"
                                    >
                                        Perhatian
                                    </p>


                                    <ul class="mt-2 space-y-1.5">

                                        <li>
                                            • Gunakan template resmi e-APBDesa.
                                        </li>

                                        <li>
                                            • Kode rekening harus berasal dari master rekening Pendapatan.
                                        </li>

                                        <li>
                                            • Uraian rekening akan diisi otomatis berdasarkan kode rekening.
                                        </li>

                                        <li>
                                            • Tahun Anggaran harus sudah tersedia di aplikasi.
                                        </li>

                                        <li>
                                            • Jika terdapat data yang tidak valid, seluruh proses import dibatalkan.
                                        </li>

                                    </ul>

                                </div>

                            </div>

                        </div>


                        {{-- Tombol --}}
                        <div
                            class="flex flex-col-reverse gap-3 border-t
                                   border-gray-100 pt-5 sm:flex-row
                                   sm:items-center sm:justify-end
                                   dark:border-gray-700"
                        >

                            {{-- Batal --}}
                            <a
                                href="{{ route('admin.pendapatan.index') }}"
                                class="inline-flex items-center justify-center gap-2
                                       rounded-xl border border-slate-200 bg-white
                                       px-5 py-3 text-sm font-semibold
                                       text-slate-700 shadow-sm transition
                                       hover:border-slate-300 hover:bg-slate-50
                                       focus:outline-none focus:ring-2
                                       focus:ring-slate-300 focus:ring-offset-2
                                       dark:border-gray-600 dark:bg-gray-800
                                       dark:text-gray-200 dark:hover:bg-gray-700"
                            >

                                <i class="bx bx-x text-lg"></i>

                                Batal

                            </a>


                            {{-- Import Pendapatan --}}
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2
                                       rounded-xl bg-blue-700 px-6 py-3
                                       text-sm font-semibold text-white
                                       shadow-sm transition hover:bg-blue-800
                                       focus:outline-none focus:ring-2
                                       focus:ring-blue-500 focus:ring-offset-2
                                       dark:focus:ring-offset-gray-800"
                            >

                                <i class="bx bx-import text-lg"></i>

                                Import Pendapatan

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- SIDEBAR --}}
        <div class="space-y-6">


            {{-- Download Template --}}
            <div
                class="overflow-hidden rounded-2xl border border-gray-200
                       bg-white shadow-sm dark:border-gray-700
                       dark:bg-gray-800"
            >

                <div class="p-6">

                    <div
                        class="flex h-12 w-12 items-center justify-center
                               rounded-xl bg-gray-100 text-gray-700
                               dark:bg-gray-700 dark:text-gray-200"
                    >

                        <i class="bx bx-download text-2xl"></i>

                    </div>


                    <h3 class="mt-4 font-semibold text-gray-900 dark:text-white">
                        Belum punya template?
                    </h3>


                    <p
                        class="mt-2 text-sm leading-6 text-gray-500
                               dark:text-gray-400"
                    >

                        Download template Excel resmi e-APBDesa yang sudah dilengkapi
                        petunjuk dan referensi rekening Pendapatan.

                    </p>


                    <a
                        href="{{ route('admin.pendapatan.template') }}"
                        class="mt-5 inline-flex w-full items-center justify-center
                               gap-2 rounded-xl border border-gray-200
                               bg-white px-4 py-2.5 text-sm font-semibold
                               text-gray-700 shadow-sm transition
                               hover:bg-gray-50 focus:outline-none
                               focus:ring-2 focus:ring-blue-500
                               focus:ring-offset-2 dark:border-gray-700
                               dark:bg-gray-700 dark:text-gray-100
                               dark:hover:bg-gray-600"
                    >

                        <i class="bx bx-file text-lg"></i>

                        Download Template Excel

                    </a>

                </div>

            </div>


            {{-- Struktur Data --}}
            <div
                class="overflow-hidden rounded-2xl border border-gray-200
                       bg-white shadow-sm dark:border-gray-700
                       dark:bg-gray-800"
            >

                <div
                    class="border-b border-gray-100 px-6 py-5
                           dark:border-gray-700"
                >

                    <h3 class="font-semibold text-gray-900 dark:text-white">
                        Struktur Import
                    </h3>

                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Kolom yang tersedia dalam template.
                    </p>

                </div>


                <div class="divide-y divide-gray-100 dark:divide-gray-700">


                    {{-- Tahun --}}
                    <div class="flex items-center gap-3 px-6 py-4">

                        <span
                            class="flex h-8 w-8 items-center justify-center
                                   rounded-lg bg-gray-100 text-xs font-bold
                                   text-gray-600 dark:bg-gray-700
                                   dark:text-gray-300"
                        >
                            01
                        </span>

                        <div>

                            <p
                                class="text-sm font-semibold text-gray-800
                                       dark:text-gray-200"
                            >
                                Tahun Anggaran
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Tahun data Pendapatan
                            </p>

                        </div>

                    </div>


                    {{-- Rekening --}}
                    <div class="flex items-center gap-3 px-6 py-4">

                        <span
                            class="flex h-8 w-8 items-center justify-center
                                   rounded-lg bg-gray-100 text-xs font-bold
                                   text-gray-600 dark:bg-gray-700
                                   dark:text-gray-300"
                        >
                            02
                        </span>

                        <div>

                            <p
                                class="text-sm font-semibold text-gray-800
                                       dark:text-gray-200"
                            >
                                Kode Rekening
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Kode master SiskeuDes
                            </p>

                        </div>

                    </div>


                    {{-- Anggaran --}}
                    <div class="flex items-center gap-3 px-6 py-4">

                        <span
                            class="flex h-8 w-8 items-center justify-center
                                   rounded-lg bg-gray-100 text-xs font-bold
                                   text-gray-600 dark:bg-gray-700
                                   dark:text-gray-300"
                        >
                            03
                        </span>

                        <div>

                            <p
                                class="text-sm font-semibold text-gray-800
                                       dark:text-gray-200"
                            >
                                Anggaran
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Nilai anggaran Pendapatan
                            </p>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="flex items-center gap-3 px-6 py-4">

                        <span
                            class="flex h-8 w-8 items-center justify-center
                                   rounded-lg bg-gray-100 text-xs font-bold
                                   text-gray-600 dark:bg-gray-700
                                   dark:text-gray-300"
                        >
                            04
                        </span>

                        <div>

                            <p
                                class="text-sm font-semibold text-gray-800
                                       dark:text-gray-200"
                            >
                                Status Publikasi
                            </p>

                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                draft / dipublikasikan
                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>

@endsection