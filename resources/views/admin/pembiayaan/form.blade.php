@extends('layouts.admin')

@section('title', isset($item) ? 'Ubah Pembiayaan' : 'Tambah Pembiayaan')

@section('content')

<div class="mx-auto max-w-5xl">

    {{-- HEADER --}}
    <div class="mb-7 flex items-center gap-4">

        <a
            href="{{ route('admin.pembiayaan.index') }}"
            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900"
            title="Kembali"
        >
            <i class="bx bx-arrow-back text-xl"></i>
        </a>

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                @yield('title')
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                {{ isset($item)
                    ? 'Perbarui data pembiayaan APBDesa.'
                    : 'Tambahkan data pembiayaan APBDesa.'
                }}
            </p>
        </div>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        action="{{ isset($item)
            ? route('admin.pembiayaan.update', $item)
            : route('admin.pembiayaan.store')
        }}"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        @csrf

        @isset($item)
            @method('PUT')
        @endisset


        {{-- FORM CONTENT --}}
        <div class="p-6 sm:p-8">

            <div class="grid gap-x-6 gap-y-5 md:grid-cols-2">


                {{-- TAHUN ANGGARAN --}}
                <div>

                    <label
                        for="tahun_anggaran_id"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Tahun Anggaran
                    </label>

                    <select
                        id="tahun_anggaran_id"
                        name="tahun_anggaran_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Pilih Tahun Anggaran
                        </option>

                        @foreach($years as $year)

                            <option
                                value="{{ $year->id }}"
                                @selected(
                                    old(
                                        'tahun_anggaran_id',
                                        $item->tahun_anggaran_id ?? ''
                                    ) == $year->id
                                )
                            >
                                {{ $year->tahun }}
                            </option>

                        @endforeach

                    </select>

                    @error('tahun_anggaran_id')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- REKENING PEMBIAYAAN --}}
                <div>

                    <label
                        for="pembiayaan_rekening_id"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Rekening Pembiayaan
                    </label>

                    @php
                        $selectedRekening = old(
                            'pembiayaan_rekening_id',
                            $item->pembiayaan_rekening_id ?? ''
                        );
                    @endphp

                    <select
                        id="pembiayaan_rekening_id"
                        name="pembiayaan_rekening_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option value="">
                            Pilih Rekening Pembiayaan
                        </option>


                        <optgroup label="Penerimaan Pembiayaan">

                            @foreach($rekening->where('jenis', 'penerimaan') as $rek)

                                <option
                                    value="{{ $rek->id }}"
                                    data-kode="{{ $rek->kode }}"
                                    data-uraian="{{ $rek->uraian }}"
                                    data-jenis="{{ $rek->jenis }}"
                                    @selected($selectedRekening == $rek->id)
                                >
                                    {{ rtrim($rek->kode, '.') }}
                                    — {{ $rek->uraian }}
                                </option>

                            @endforeach

                        </optgroup>


                        <optgroup label="Pengeluaran Pembiayaan">

                            @foreach($rekening->where('jenis', 'pengeluaran') as $rek)

                                <option
                                    value="{{ $rek->id }}"
                                    data-kode="{{ $rek->kode }}"
                                    data-uraian="{{ $rek->uraian }}"
                                    data-jenis="{{ $rek->jenis }}"
                                    @selected($selectedRekening == $rek->id)
                                >
                                    {{ rtrim($rek->kode, '.') }}
                                    — {{ $rek->uraian }}
                                </option>

                            @endforeach

                        </optgroup>

                    </select>

                    @error('pembiayaan_rekening_id')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- JENIS --}}
                <div>

                    <label
                        for="jenis_display"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Jenis Pembiayaan
                    </label>

                    <input
                        id="jenis_display"
                        type="text"
                        readonly
                        placeholder="Otomatis dari rekening"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-medium text-slate-700 outline-none"
                    >

                    <p class="mt-1 text-xs text-slate-400">
                        Otomatis berdasarkan rekening Siskeudes.
                    </p>

                </div>


                {{-- KODE --}}
                <div>

                    <label
                        for="kode_display"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Kode Rekening
                    </label>

                    <input
                        id="kode_display"
                        type="text"
                        readonly
                        placeholder="Otomatis dari rekening"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 font-mono text-sm font-semibold text-slate-700 outline-none"
                    >

                    <p class="mt-1 text-xs text-slate-400">
                        Mengikuti kode rekening Siskeudes.
                    </p>

                </div>


                {{-- URAIAN --}}
                <div class="md:col-span-2">

                    <label
                        for="uraian_display"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Uraian Pembiayaan
                    </label>

                    <textarea
                        id="uraian_display"
                        rows="2"
                        readonly
                        placeholder="Otomatis dari rekening"
                        class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none"
                    ></textarea>

                    <p class="mt-1 text-xs text-slate-400">
                        Uraian mengikuti master rekening Siskeudes dan tidak dapat diubah.
                    </p>

                </div>


                {{-- ANGGARAN --}}
                <div>

                    <label
                        for="anggaran"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Anggaran
                    </label>

                    <div class="relative">

                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-slate-500">
                            Rp
                        </span>

                        <input
                            id="anggaran"
                            type="number"
                            name="anggaran"
                            value="{{ old('anggaran', $item->anggaran ?? '') }}"
                            min="0"
                            step="0.01"
                            placeholder="0"
                            required
                            class="w-full rounded-xl border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                    </div>

                    @error('anggaran')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- STATUS --}}
                <div>

                    <label
                        for="status_publikasi"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Status Publikasi
                    </label>

                    <select
                        id="status_publikasi"
                        name="status_publikasi"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                        <option
                            value="draft"
                            @selected(
                                old(
                                    'status_publikasi',
                                    $item->status_publikasi ?? 'draft'
                                ) === 'draft'
                            )
                        >
                            Draft
                        </option>

                        <option
                            value="dipublikasikan"
                            @selected(
                                old(
                                    'status_publikasi',
                                    $item->status_publikasi ?? ''
                                ) === 'dipublikasikan'
                            )
                        >
                            Dipublikasikan
                        </option>

                    </select>

                    <p class="mt-1 text-xs text-slate-400">
                        Data tampil di publik jika dipublikasikan.
                    </p>

                    @error('status_publikasi')
                        <p class="mt-1.5 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="flex items-center justify-end gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:px-8">

            <a
                href="{{ route('admin.pembiayaan.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
            >
                <i class="bx bx-save text-lg"></i>

                {{ isset($item)
                    ? 'Simpan Perubahan'
                    : 'Simpan Pembiayaan'
                }}
            </button>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const rekeningSelect =
        document.getElementById('pembiayaan_rekening_id');

    const jenisDisplay =
        document.getElementById('jenis_display');

    const kodeDisplay =
        document.getElementById('kode_display');

    const uraianDisplay =
        document.getElementById('uraian_display');


    function updateRekeningInfo() {

        const option =
            rekeningSelect.options[
                rekeningSelect.selectedIndex
            ];

        if (!option || !option.value) {

            jenisDisplay.value = '';
            kodeDisplay.value = '';
            uraianDisplay.value = '';

            return;
        }

        const jenis =
            option.dataset.jenis || '';

        const kode =
            option.dataset.kode || '';

        const uraian =
            option.dataset.uraian || '';


        jenisDisplay.value =
            jenis === 'penerimaan'
                ? 'Penerimaan Pembiayaan'
                : 'Pengeluaran Pembiayaan';

        kodeDisplay.value =
            kode.replace(/\.$/, '');

        uraianDisplay.value =
            uraian;
    }


    rekeningSelect.addEventListener(
        'change',
        updateRekeningInfo
    );


    updateRekeningInfo();

});
</script>

@endsection