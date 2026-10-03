@extends('layouts.admin')

@section('title', isset($item) ? 'Edit Belanja' : 'Tambah Belanja')

@section('content')

<style>
    /* =========================================================
       BELANJA FORM - CLEAN UI
       ========================================================= */

    [data-dropdown-panel][hidden] {
        display: none !important;
    }

    /* Form spacing */
    .belanja-form-grid {
        column-gap: 32px;
        row-gap: 32px;
    }

    @media (min-width: 1024px) {
        .belanja-form-grid {
            column-gap: 40px;
            row-gap: 36px;
        }
    }

    /* Dropdown trigger */
    .belanja-trigger {
        min-height: 52px;
    }

    /* Dropdown popup */
    .belanja-dropdown-panel {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 8px);
        z-index: 100;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow:
            0 20px 45px rgba(15, 23, 42, 0.14),
            0 4px 12px rgba(15, 23, 42, 0.06);
    }

    /* Search wrapper */
    .belanja-search-wrap {
        position: relative;
    }

    /* Search icon */
    .belanja-search-wrap svg {
        position: absolute;
        left: 15px !important;
        top: 50%;
        width: 17px;
        height: 17px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #94a3b8;
        z-index: 2;
    }

    /* Search input */
    .belanja-search-wrap input {
        width: 100%;
        min-height: 44px;
        padding-top: 10px !important;
        padding-right: 14px !important;
        padding-bottom: 10px !important;
        padding-left: 44px !important;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #334155;
        font-size: 14px;
        line-height: 20px;
        outline: none;
        transition: all .15s ease;
    }

    .belanja-search-wrap input::placeholder {
        color: #94a3b8;
    }

    .belanja-search-wrap input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
    }

    /* Search header */
    .belanja-search-header {
        padding: 12px;
        border-bottom: 1px solid #f1f5f9;
        background: #f8fafc;
    }

    /* Dropdown list */
    .belanja-options {
        max-height: 300px;
        overflow-y: auto;
        padding: 6px;
    }

    .belanja-options::-webkit-scrollbar {
        width: 7px;
    }

    .belanja-options::-webkit-scrollbar-track {
        background: #f8fafc;
    }

    .belanja-options::-webkit-scrollbar-thumb {
        border-radius: 999px;
        background: #cbd5e1;
    }

    /* Dropdown option */
    .belanja-option {
        display: block;
        width: 100%;
        padding: 11px 13px;
        border-radius: 11px;
        text-align: left;
        transition: background .15s ease, color .15s ease;
    }

    .belanja-option:hover {
        background: #f8fafc;
    }

    .belanja-option.is-selected {
        background: #eff6ff;
    }

    .belanja-option-code {
        font-size: 14px;
        font-weight: 700;
        line-height: 20px;
        color: #1e293b;
    }

    .belanja-option-name {
        margin-top: 2px;
        font-size: 12px;
        line-height: 18px;
        color: #64748b;
    }

    /* Empty result */
    .belanja-empty {
        padding: 24px 16px;
        text-align: center;
        font-size: 13px;
        color: #64748b;
    }

    /* Preview rekening */
    .rekening-preview {
        margin-top: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #f8fafc;
    }

    /* Prevent dropdowns from being hidden behind neighboring fields */
    [data-dropdown="sub"] {
        z-index: 40;
    }

    [data-dropdown="kegiatan"] {
        z-index: 30;
    }

    [data-dropdown="rekening"] {
        z-index: 20;
    }
</style>

@php
    $selectedYear = (string) old(
        'tahun_anggaran_id',
        $item->tahun_anggaran_id ?? ''
    );

    $selectedBidang = (string) old(
        'bidang_id',
        $item->bidang_id ?? ''
    );

    $selectedSubBidang = (string) old(
        'sub_bidang_id',
        $item->kegiatan?->sub_bidang_id ?? ''
    );

    $selectedKegiatan = (string) old(
        'kegiatan_id',
        $item->kegiatan_id ?? ''
    );

    $selectedRekening = (string) old(
        'belanja_rekening_id',
        $item->belanja_rekening_id ?? ''
    );

    /*
    |--------------------------------------------------------------------------
    | MASTER SUB BIDANG
    |--------------------------------------------------------------------------
    */

    $subData = $subBidang->map(fn ($x) => [
        'id' => (string) $x->id,
        'year' => (string) $x->tahun_anggaran_id,
        'bidang' => (string) $x->bidang_id,
        'kode' => $x->kode,
        'nama' => $x->nama,
    ])->values();

    /*
    |--------------------------------------------------------------------------
    | MASTER KEGIATAN
    |--------------------------------------------------------------------------
    */

    $kegiatanData = $kegiatan->map(fn ($x) => [
        'id' => (string) $x->id,
        'year' => (string) $x->tahun_anggaran_id,
        'sub' => (string) $x->sub_bidang_id,
        'kode' => $x->kode,
        'nama' => $x->nama,
    ])->values();

    /*
    |--------------------------------------------------------------------------
    | MASTER REKENING BELANJA
    |--------------------------------------------------------------------------
    */

    $rekeningData = $rekening->map(fn ($x) => [
        'id' => (string) $x->id,
        'kode' => $x->kode,
        'uraian' => $x->uraian,
    ])->values();
@endphp

<div class="space-y-6">

    {{-- =========================================================
         HEADER
         ========================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">
                Administrasi
            </div>

            <h1 class="mt-1 text-2xl font-semibold text-slate-900">
                {{ isset($item) ? 'Edit Belanja' : 'Tambah Belanja' }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Pilih struktur kegiatan dan rekening dari master SiskeuDes.
            </p>
        </div>

        <a href="{{ route('admin.belanja.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            Kembali
        </a>

    </div>


    {{-- =========================================================
         VALIDATION ERROR
         ========================================================= --}}

    @if ($errors->any())

        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <ul class="list-disc space-y-1 pl-5">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- =========================================================
         FORM
         ========================================================= --}}

    <form method="POST"
          action="{{ isset($item)
                ? route('admin.belanja.update', $item)
                : route('admin.belanja.store') }}"
          class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:p-7">

        @csrf

        @if(isset($item))
            @method('PUT')
        @endif


        <div class="belanja-form-grid grid md:grid-cols-2">


            {{-- =================================================
                 TAHUN ANGGARAN
                 ================================================= --}}

            <div>

                <label for="tahun_anggaran_id"
                       class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Tahun Anggaran

                </label>

                <select id="tahun_anggaran_id"
                        name="tahun_anggaran_id"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                    <option value="">
                        Pilih Tahun Anggaran
                    </option>

                    @foreach($years as $y)

                        <option value="{{ $y->id }}"
                            @selected((string) $y->id === $selectedYear)>

                            {{ $y->tahun }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =================================================
                 BIDANG
                 ================================================= --}}

            <div>

                <label for="bidang_id"
                       class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Bidang

                </label>

                <select id="bidang_id"
                        name="bidang_id"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                    <option value="">
                        Pilih Bidang
                    </option>

                    @foreach($bidang as $b)

                        <option value="{{ $b->id }}"
                                data-year="{{ $b->tahun_anggaran_id }}"
                                @selected((string) $b->id === $selectedBidang)>

                            {{ $b->kode }} — {{ $b->nama }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- =================================================
                 SUB BIDANG
                 ================================================= --}}

            <div class="relative" data-dropdown="sub">

                <label class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Sub Bidang

                </label>

                <input type="hidden"
                       name="sub_bidang_id"
                       id="sub_bidang_id"
                       value="{{ $selectedSubBidang }}">


                {{-- Trigger --}}

                <button type="button"
                        data-dropdown-button
                        class="belanja-trigger flex w-full items-center justify-between rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-left shadow-sm transition hover:border-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                    <span data-selected-label
                          class="truncate pr-3 text-sm text-slate-400">

                        Pilih Sub Bidang

                    </span>

                    <svg class="h-4 w-4 shrink-0 text-slate-400"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z"
                              clip-rule="evenodd"/>

                    </svg>

                </button>


                {{-- Dropdown --}}

                <div data-dropdown-panel
                     hidden
                     class="belanja-dropdown-panel">

                    <div class="belanja-search-header">

                        <div class="belanja-search-wrap">

                            <svg viewBox="0 0 20 20"
                                 fill="currentColor">

                                <path fill-rule="evenodd"
                                      d="M8.5 3a5.5 5.5 0 1 0 3.447 9.785l3.634 3.634a.75.75 0 1 0 1.06-1.06l-3.634-3.634A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                                      clip-rule="evenodd"/>

                            </svg>

                            <input type="text"
                                   data-search
                                   placeholder="Cari kode atau nama Sub Bidang...">

                        </div>

                    </div>


                    <div data-options
                         class="belanja-options">
                    </div>


                    <div data-empty
                         class="belanja-empty hidden">

                        Sub Bidang tidak ditemukan.

                    </div>

                </div>

            </div>


            {{-- =================================================
                 KEGIATAN
                 ================================================= --}}

            <div class="relative" data-dropdown="kegiatan">

                <label class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Kegiatan

                </label>

                <input type="hidden"
                       name="kegiatan_id"
                       id="kegiatan_id"
                       value="{{ $selectedKegiatan }}">


                {{-- Trigger --}}

                <button type="button"
                        data-dropdown-button
                        class="belanja-trigger flex w-full items-center justify-between rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-left shadow-sm transition hover:border-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                    <span data-selected-label
                          class="truncate pr-3 text-sm text-slate-400">

                        Pilih Kegiatan

                    </span>

                    <svg class="h-4 w-4 shrink-0 text-slate-400"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z"
                              clip-rule="evenodd"/>

                    </svg>

                </button>


                {{-- Dropdown --}}

                <div data-dropdown-panel
                     hidden
                     class="belanja-dropdown-panel">

                    <div class="belanja-search-header">

                        <div class="belanja-search-wrap">

                            <svg viewBox="0 0 20 20"
                                 fill="currentColor">

                                <path fill-rule="evenodd"
                                      d="M8.5 3a5.5 5.5 0 1 0 3.447 9.785l3.634 3.634a.75.75 0 1 0 1.06-1.06l-3.634-3.634A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                                      clip-rule="evenodd"/>

                            </svg>

                            <input type="text"
                                   data-search
                                   placeholder="Cari kode atau nama Kegiatan...">

                        </div>

                    </div>


                    <div data-options
                         class="belanja-options">
                    </div>


                    <div data-empty
                         class="belanja-empty hidden">

                        Kegiatan tidak ditemukan.

                    </div>

                </div>

            </div>


            {{-- =================================================
                 REKENING BELANJA
                 ================================================= --}}

            <div class="relative md:col-span-2"
                 data-dropdown="rekening">

                <label class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Rekening Belanja

                </label>

                <input type="hidden"
                       name="belanja_rekening_id"
                       id="belanja_rekening_id"
                       value="{{ $selectedRekening }}">


                {{-- Trigger --}}

                <button type="button"
                        data-dropdown-button
                        class="belanja-trigger flex w-full items-center justify-between rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-left shadow-sm transition hover:border-slate-400 focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                    <span data-selected-label
                          class="truncate pr-3 text-sm text-slate-400">

                        Pilih Rekening Belanja

                    </span>

                    <svg class="h-4 w-4 shrink-0 text-slate-400"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0l-4.25-4.51a.75.75 0 0 1 .02-1.06Z"
                              clip-rule="evenodd"/>

                    </svg>

                </button>


                {{-- Dropdown --}}

                <div data-dropdown-panel
                     hidden
                     class="belanja-dropdown-panel">

                    <div class="belanja-search-header">

                        <div class="belanja-search-wrap">

                            <svg viewBox="0 0 20 20"
                                 fill="currentColor">

                                <path fill-rule="evenodd"
                                      d="M8.5 3a5.5 5.5 0 1 0 3.447 9.785l3.634 3.634a.75.75 0 1 1-1.06 1.06l-3.634-3.634A5.5 5.5 0 0 0 8.5 3ZM4.5 8.5a4 4 0 1 1 8 0 4 4 0 0 1-8 0Z"
                                      clip-rule="evenodd"/>

                            </svg>

                            <input type="text"
                                   data-search
                                   placeholder="Cari kode atau nama rekening...">

                        </div>

                    </div>


                    <div data-options
                         class="belanja-options">
                    </div>


                    <div data-empty
                         class="belanja-empty hidden">

                        Rekening tidak ditemukan.

                    </div>

                </div>


                {{-- Rekening Preview --}}

                <div class="rekening-preview grid gap-4 p-4 sm:grid-cols-2">

                    <div>

                        <div class="text-xs font-medium text-slate-500">
                            Kode Rekening
                        </div>

                        <div id="rekening_kode"
                             class="mt-1.5 font-semibold text-slate-800">

                            -

                        </div>

                    </div>


                    <div>

                        <div class="text-xs font-medium text-slate-500">
                            Uraian Rekening
                        </div>

                        <div id="rekening_uraian"
                             class="mt-1.5 font-semibold text-slate-800">

                            -

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 ANGGARAN
                 ================================================= --}}

            <div>

                <label for="anggaran"
                       class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Anggaran

                </label>

                <input type="number"
                       id="anggaran"
                       name="anggaran"
                       min="0"
                       step="0.01"
                       required
                       value="{{ old('anggaran', $item->anggaran ?? '') }}"
                       class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

            </div>


            {{-- =================================================
                 STATUS
                 ================================================= --}}

            <div>

                <label for="status_publikasi"
                       class="mb-2.5 block text-sm font-semibold text-slate-700">

                    Status Publikasi

                </label>

                <select id="status_publikasi"
                        name="status_publikasi"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3.5 text-sm shadow-sm outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-50">

                    <option value="draft"
                        @selected(old('status_publikasi', $item->status_publikasi ?? 'draft') === 'draft')>

                        Draft

                    </option>

                    <option value="dipublikasikan"
                        @selected(old('status_publikasi', $item->status_publikasi ?? '') === 'dipublikasikan')>

                        Dipublikasikan

                    </option>

                </select>

            </div>

        </div>


        {{-- =====================================================
             ACTION
             ===================================================== --}}

        <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end">

            <a href="{{ route('admin.belanja.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                Batal

            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                {{ isset($item) ? 'Simpan Perubahan' : 'Simpan Belanja' }}

            </button>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const tahun = document.getElementById('tahun_anggaran_id');
    const bidang = document.getElementById('bidang_id');

    const subId = document.getElementById('sub_bidang_id');
    const kegiatanId = document.getElementById('kegiatan_id');
    const rekeningId = document.getElementById('belanja_rekening_id');


    /* =========================================================
       DATA MASTER
       ========================================================= */

    const subData = @json($subData);
    const kegiatanData = @json($kegiatanData);
    const rekeningData = @json($rekeningData);


    /* =========================================================
       SEARCH STATE
       ========================================================= */

    const state = {
        subSearch: '',
        kegiatanSearch: '',
        rekeningSearch: ''
    };


    /* =========================================================
       DROPDOWNS
       ========================================================= */

    const dropdowns = {
        sub: document.querySelector('[data-dropdown="sub"]'),
        kegiatan: document.querySelector('[data-dropdown="kegiatan"]'),
        rekening: document.querySelector('[data-dropdown="rekening"]')
    };


    /* =========================================================
       CLOSE DROPDOWNS
       ========================================================= */

    function closeAll(except = null) {

        Object.entries(dropdowns).forEach(([key, root]) => {

            if (!root) {
                return;
            }

            if (key !== except) {

                const panel = root.querySelector('[data-dropdown-panel]');

                if (panel) {
                    panel.hidden = true;
                }

            }

        });

    }


    /* =========================================================
       DROPDOWN ENGINE
       ========================================================= */

    function setupDropdown(
        key,
        getItems,
        getId,
        setId,
        onSelect = null
    ) {

        const root = dropdowns[key];

        const trigger = root.querySelector('[data-dropdown-button]');
        const panel = root.querySelector('[data-dropdown-panel]');
        const search = root.querySelector('[data-search]');
        const options = root.querySelector('[data-options]');
        const empty = root.querySelector('[data-empty]');
        const label = root.querySelector('[data-selected-label]');


        /* -----------------------------------------------------
           GET ALL ITEMS WITHOUT SEARCH
           ----------------------------------------------------- */

        function getAllItems() {
            return getItems(true);
        }


        /* -----------------------------------------------------
           UPDATE LABEL
           ----------------------------------------------------- */

        function updateLabel() {

            const selected = String(getId() || '');

            const item = getAllItems().find(
                item => String(item.id) === selected
            );


            if (item) {

                label.textContent =
                    `${item.kode} — ${item.nama ?? item.uraian}`;

                label.classList.remove('text-slate-400');
                label.classList.add('text-slate-800');

            } else {

                if (key === 'sub') {
                    label.textContent = 'Pilih Sub Bidang';
                }

                if (key === 'kegiatan') {
                    label.textContent = 'Pilih Kegiatan';
                }

                if (key === 'rekening') {
                    label.textContent = 'Pilih Rekening Belanja';
                }

                label.classList.remove('text-slate-800');
                label.classList.add('text-slate-400');

            }

        }


        /* -----------------------------------------------------
           RENDER ITEMS
           ----------------------------------------------------- */

        function render() {

            const items = getItems();

            const selected = String(getId() || '');

            options.innerHTML = '';


            items.forEach(item => {

                const option = document.createElement('button');

                option.type = 'button';

                option.className =
                    'belanja-option';

                if (String(item.id) === selected) {

                    option.classList.add('is-selected');

                }


                const code = document.createElement('div');

                code.className =
                    'belanja-option-code';

                code.textContent = item.kode;


                const name = document.createElement('div');

                name.className =
                    'belanja-option-name';

                name.textContent =
                    item.nama ?? item.uraian;


                option.appendChild(code);
                option.appendChild(name);


                option.addEventListener('click', () => {

                    setId(String(item.id));

                    search.value = '';

                    state[key + 'Search'] = '';

                    panel.hidden = true;

                    updateLabel();


                    if (onSelect) {

                        onSelect(item);

                    }

                });


                options.appendChild(option);

            });


            empty.classList.toggle(
                'hidden',
                items.length !== 0
            );

        }


        /* -----------------------------------------------------
           OPEN / CLOSE
           ----------------------------------------------------- */

        trigger.addEventListener('click', event => {

            event.stopPropagation();

            const willOpen = panel.hidden;

            closeAll(key);

            panel.hidden = !willOpen;


            if (willOpen) {

                render();

                setTimeout(() => {

                    search.focus();

                }, 50);

            }

        });


        /* -----------------------------------------------------
           SEARCH
           ----------------------------------------------------- */

        search.addEventListener('input', () => {

            state[key + 'Search'] =
                search.value;

            render();

        });


        return {
            render,
            updateLabel
        };

    }


    /* =========================================================
       FILTER SUB BIDANG
       ========================================================= */

    function subItems(ignoreSearch = false) {

        const q = ignoreSearch
            ? ''
            : state.subSearch.toLowerCase().trim();


        return subData

            .filter(item =>
                item.year === String(tahun.value)
            )

            .filter(item =>
                item.bidang === String(bidang.value)
            )

            .filter(item =>
                !q ||
                `${item.kode} ${item.nama}`
                    .toLowerCase()
                    .includes(q)
            );

    }


    /* =========================================================
       FILTER KEGIATAN
       ========================================================= */

    function kegiatanItems(ignoreSearch = false) {

        const q = ignoreSearch
            ? ''
            : state.kegiatanSearch.toLowerCase().trim();


        return kegiatanData

            .filter(item =>
                item.year === String(tahun.value)
            )

            .filter(item =>
                item.sub === String(subId.value)
            )

            .filter(item =>
                !q ||
                `${item.kode} ${item.nama}`
                    .toLowerCase()
                    .includes(q)
            );

    }


    /* =========================================================
       FILTER REKENING
       ========================================================= */

    function rekeningItems(ignoreSearch = false) {

        const q = ignoreSearch
            ? ''
            : state.rekeningSearch.toLowerCase().trim();


        return rekeningData

            .filter(item =>
                !q ||
                `${item.kode} ${item.uraian}`
                    .toLowerCase()
                    .includes(q)
            );

    }


    /* =========================================================
       INITIALIZE DROPDOWNS
       ========================================================= */

    const subDropdown = setupDropdown(
        'sub',
        subItems,
        () => subId.value,
        value => {
            subId.value = value;
        },
        () => {

            kegiatanId.value = '';

            kegiatanDropdown.updateLabel();

            kegiatanDropdown.render();

        }
    );


    const kegiatanDropdown = setupDropdown(
        'kegiatan',
        kegiatanItems,
        () => kegiatanId.value,
        value => {
            kegiatanId.value = value;
        }
    );


    const rekeningDropdown = setupDropdown(
        'rekening',
        rekeningItems,
        () => rekeningId.value,
        value => {
            rekeningId.value = value;
        },
        updateRekeningPreview
    );


    /* =========================================================
       REKENING PREVIEW
       ========================================================= */

    function updateRekeningPreview() {

        const item = rekeningData.find(
            item =>
                String(item.id) ===
                String(rekeningId.value)
        );


        document.getElementById(
            'rekening_kode'
        ).textContent =
            item?.kode || '-';


        document.getElementById(
            'rekening_uraian'
        ).textContent =
            item?.uraian || '-';

    }


    /* =========================================================
       CLEAR SUB BIDANG + KEGIATAN
       ========================================================= */

    function clearSubAndKegiatan() {

        subId.value = '';

        kegiatanId.value = '';


        state.subSearch = '';

        state.kegiatanSearch = '';


        dropdowns.sub.querySelector(
            '[data-search]'
        ).value = '';


        dropdowns.kegiatan.querySelector(
            '[data-search]'
        ).value = '';


        subDropdown.updateLabel();

        kegiatanDropdown.updateLabel();

        subDropdown.render();

        kegiatanDropdown.render();

    }


    /* =========================================================
       YEAR CHANGE
       ========================================================= */

    tahun.addEventListener('change', () => {

        const year = String(tahun.value);


        [...bidang.options].forEach(
            (option, index) => {

                option.hidden =
                    index !== 0 &&
                    option.dataset.year !== year;

            }
        );


        const currentBidangValid =
            [...bidang.options].some(
                option =>
                    option.value &&
                    option.dataset.year === year &&
                    option.value === bidang.value
            );


        if (!currentBidangValid) {

            bidang.value = '';

        }


        clearSubAndKegiatan();

    });


    /* =========================================================
       BIDANG CHANGE
       ========================================================= */

    bidang.addEventListener('change', () => {

        clearSubAndKegiatan();

        closeAll();

    });


    /* =========================================================
       INITIAL YEAR FILTER
       ========================================================= */

    const initialYear =
        String(tahun.value);


    [...bidang.options].forEach(
        (option, index) => {

            option.hidden =
                index !== 0 &&
                option.dataset.year !== initialYear;

        }
    );


    /* =========================================================
       INITIAL DISPLAY
       ========================================================= */

    subDropdown.updateLabel();

    kegiatanDropdown.updateLabel();

    rekeningDropdown.updateLabel();

    subDropdown.render();

    kegiatanDropdown.render();

    rekeningDropdown.render();

    updateRekeningPreview();


    /* =========================================================
       CLICK OUTSIDE
       ========================================================= */

    document.addEventListener('click', event => {

        if (!event.target.closest('[data-dropdown]')) {

            closeAll();

        }

    });

});
</script>

@endsection