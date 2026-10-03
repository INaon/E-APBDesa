@extends('layouts.admin')

@section('title', 'Edit Realisasi')

@section('content')

<div class="max-w-5xl">

    {{-- HEADER --}}
    <div class="mb-7">

        <div class="flex items-center gap-3">

            <a
                href="{{ route('admin.realisasi.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-700"
                title="Kembali"
            >
                <i class="bx bx-arrow-back text-xl"></i>
            </a>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Edit Realisasi
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Perbarui data realisasi anggaran Desa.
                </p>
            </div>

        </div>

    </div>


    {{-- FORM --}}
    <form
        x-data="realisasiEditForm()"
        method="POST"
        action="{{ route('admin.realisasi.update', [$jenis, $realisasi->id]) }}"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        @csrf
        @method('PUT')


        {{-- ERROR VALIDATION --}}
        @if ($errors->any())

            <div class="m-6 rounded-xl border border-red-200 bg-red-50 p-4">

                <div class="flex gap-3">

                    <i class="bx bx-error-circle mt-0.5 text-xl text-red-600"></i>

                    <div>

                        <p class="font-semibold text-red-800">
                            Data belum dapat diperbarui.
                        </p>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- FORM BODY --}}
        <div class="p-6">

            <div class="grid gap-6 md:grid-cols-2">


                {{-- JENIS REALISASI --}}
                <div>

                    <label
                        for="jenis"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Jenis Realisasi
                    </label>

                    <div class="relative">

                        <i class="bx bx-category absolute left-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                        <select
                            id="jenis"
                            name="jenis"
                            x-model="jenis"
                            disabled
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-slate-100 py-3 pl-10 pr-10 text-sm font-medium text-slate-600 outline-none"
                        >

                            <option value="pendapatan">
                                Pendapatan
                            </option>

                            <option value="belanja">
                                Belanja
                            </option>

                            <option value="pembiayaan">
                                Pembiayaan
                            </option>

                        </select>

                        <i class="bx bx-lock-alt pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                    </div>

                    {{-- Karena select disabled tidak ikut terkirim --}}
                    <input
                        type="hidden"
                        name="jenis"
                        value="{{ $jenis }}"
                    >

                </div>


                {{-- TAHUN ANGGARAN --}}
                <div>

                    <label
                        for="tahun_anggaran_id"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Tahun Anggaran
                    </label>

                    <div class="relative">

                        <i class="bx bx-calendar absolute left-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                        <select
                            id="tahun_anggaran_id"
                            name="tahun_anggaran_id"
                            x-model="tahun"
                            @change="item = ''"
                            required
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-10 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                            @foreach ($years as $year)

                                <option
                                    value="{{ $year->id }}"
                                    {{ (int) $year->id === (int) $realisasi->{$jenis}->tahun_anggaran_id ? 'selected' : '' }}
                                >
                                    {{ $year->tahun }}
                                </option>

                            @endforeach

                        </select>

                        <i class="bx bx-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                    </div>

                </div>


                {{-- REKENING --}}
                <div class="md:col-span-2">

                    <label
                        for="item_id"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Rekening
                    </label>

                    <div class="relative">

                        <i class="bx bx-list-ul absolute left-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                        <select
                            id="item_id"
                            name="item_id"
                            x-model="item"
                            required
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-10 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                            <option value="">
                                Pilih rekening
                            </option>


                            {{-- PENDAPATAN --}}
                            <template x-if="jenis === 'pendapatan'">

                                <optgroup label="Pendapatan">

                                    @foreach ($pendapatan as $row)

                                        <template x-if="String({{ $row->tahun_anggaran_id }}) === String(tahun)">

                                            <option
                                                value="{{ $row->id }}"
                                            >
                                                {{ $row->kode }}
                                                — {{ $row->uraian }}
                                            </option>

                                        </template>

                                    @endforeach

                                </optgroup>

                            </template>


                            {{-- BELANJA --}}
                            <template x-if="jenis === 'belanja'">

                                <optgroup label="Belanja">

                                    @foreach ($belanja as $row)

                                        <template x-if="String({{ $row->tahun_anggaran_id }}) === String(tahun)">

                                            <option
                                                value="{{ $row->id }}"
                                            >
                                                {{ $row->kode }}
                                                — {{ $row->uraian }}
                                            </option>

                                        </template>

                                    @endforeach

                                </optgroup>

                            </template>


                            {{-- PEMBIAYAAN --}}
                            <template x-if="jenis === 'pembiayaan'">

                                <optgroup label="Pembiayaan">

                                    @foreach ($pembiayaan as $row)

                                        <template x-if="String({{ $row->tahun_anggaran_id }}) === String(tahun)">

                                            <option
                                                value="{{ $row->id }}"
                                            >
                                                {{ $row->kode }}
                                                — {{ $row->uraian }}
                                            </option>

                                        </template>

                                    @endforeach

                                </optgroup>

                            </template>

                        </select>

                        <i class="bx bx-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                    </div>

                    <p class="mt-2 text-xs text-slate-400">
                        Rekening mengikuti Tahun Anggaran yang dipilih.
                    </p>

                </div>


                {{-- BULAN --}}
                <div>

                    <label
                        for="bulan"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Bulan
                    </label>

                    <div class="relative">

                        <i class="bx bx-calendar-event absolute left-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                        <select
                            id="bulan"
                            name="bulan"
                            required
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-10 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                            <option value="">
                                Pilih bulan
                            </option>

                            @php
                                $bulanList = [
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
                                ];
                            @endphp

                            @foreach ($bulanList as $nomor => $nama)

                                <option
                                    value="{{ $nomor }}"
                                    {{ (int) old('bulan', $realisasi->bulan) === $nomor ? 'selected' : '' }}
                                >
                                    {{ $nama }}
                                </option>

                            @endforeach

                        </select>

                        <i class="bx bx-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                    </div>

                </div>


                {{-- TANGGAL --}}
                <div>

                    <label
                        for="tanggal"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Tanggal Realisasi
                    </label>

                    <div class="relative">

                        <i class="bx bx-calendar absolute left-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                        <input
                            id="tanggal"
                            type="date"
                            name="tanggal"
                            value="{{ old('tanggal', optional($realisasi->tanggal)->format('Y-m-d')) }}"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-4 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                    </div>

                </div>


                {{-- NILAI --}}
                <div class="md:col-span-2">

                    <label
                        for="nilai"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Nilai Realisasi
                    </label>

                    <div class="relative">

                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">
                            Rp
                        </span>

                        <input
                            id="nilai"
                            type="number"
                            name="nilai"
                            value="{{ old('nilai', $realisasi->nilai) }}"
                            min="0"
                            step="0.01"
                            required
                            placeholder="0"
                            class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                    </div>

                </div>


                {{-- KETERANGAN --}}
                <div class="md:col-span-2">

                    <label
                        for="keterangan"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Keterangan
                        <span class="font-normal text-slate-400">
                            (opsional)
                        </span>
                    </label>

                    <textarea
                        id="keterangan"
                        name="keterangan"
                        rows="4"
                        placeholder="Tambahkan keterangan jika diperlukan..."
                        class="w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >{{ old('keterangan', $realisasi->keterangan) }}</textarea>

                </div>


                {{-- STATUS --}}
                <div class="md:col-span-2">

                    <label
                        for="status_publikasi"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Status Publikasi
                    </label>

                    <div class="relative">

                        <i class="bx bx-globe absolute left-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                        <select
                            id="status_publikasi"
                            name="status_publikasi"
                            required
                            class="w-full appearance-none rounded-xl border border-slate-300 bg-white py-3 pl-10 pr-10 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >

                            <option
                                value="draft"
                                {{ old('status_publikasi', $realisasi->status_publikasi) === 'draft' ? 'selected' : '' }}
                            >
                                Draft
                            </option>

                            <option
                                value="dipublikasikan"
                                {{ old('status_publikasi', $realisasi->status_publikasi) === 'dipublikasikan' ? 'selected' : '' }}
                            >
                                Dipublikasikan
                            </option>

                        </select>

                        <i class="bx bx-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-lg text-slate-400"></i>

                    </div>

                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-end">

            <a
                href="{{ route('admin.realisasi.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
            >
                <i class="bx bx-x text-lg"></i>
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
            >
                <i class="bx bx-save text-lg"></i>
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>


<script>
    function realisasiEditForm() {
        return {
            jenis: @json($jenis),

            tahun: @json(
                old(
                    'tahun_anggaran_id',
                    $realisasi->{$jenis}->tahun_anggaran_id
                )
            ),

            item: @json(
                old(
                    'item_id',
                    $realisasi->{$jenis . '_id'}
                )
            ),
        };
    }
</script>

@endsection