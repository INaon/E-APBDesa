@extends('layouts.admin')

@section('title', isset($item) ? 'Ubah Dokumen' : 'Unggah Dokumen')

@section('content')

<div class="max-w-4xl space-y-7">

    {{-- HEADER --}}
    <div>

        <div class="flex items-center gap-3">

            <a
                href="{{ route('admin.dokumen.index') }}"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-700"
                title="Kembali"
            >
                <i class="bx bx-arrow-back text-xl"></i>
            </a>

            <div>
                <p class="text-sm font-semibold text-blue-600">
                    Dokumen Publikasi
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    @yield('title')
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ isset($item)
                        ? 'Perbarui informasi dan file dokumen publikasi.'
                        : 'Unggah dokumen untuk dipublikasikan pada aplikasi e-APBDesa.'
                    }}
                </p>
            </div>

        </div>

    </div>


    {{-- FORM --}}
    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ isset($item)
            ? route('admin.dokumen.update', $item)
            : route('admin.dokumen.store') }}"
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >

        @csrf

        @isset($item)
            @method('PUT')
        @endisset


        {{-- FORM CONTENT --}}
        <div class="space-y-6 p-6 sm:p-7">

            {{-- TAHUN ANGGARAN --}}
            <div>

                <label
                    for="tahun_anggaran_id"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Tahun Anggaran
                    <span class="text-red-500">*</span>
                </label>

                <select
                    id="tahun_anggaran_id"
                    name="tahun_anggaran_id"
                    required
                    class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

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
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- KATEGORI --}}
            <div>

                <label
                    for="kategori"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Kategori Dokumen
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="kategori"
                    type="text"
                    name="kategori"
                    value="{{ old('kategori', $item->kategori ?? '') }}"
                    placeholder="Contoh: APBDesa, Peraturan Desa, Laporan, Publikasi"
                    required
                    maxlength="100"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                @error('kategori')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- JUDUL --}}
            <div>

                <label
                    for="judul"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Judul Dokumen
                    <span class="text-red-500">*</span>
                </label>

                <input
                    id="judul"
                    type="text"
                    name="judul"
                    value="{{ old('judul', $item->judul ?? '') }}"
                    placeholder="Masukkan judul dokumen"
                    required
                    maxlength="255"
                    class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >

                @error('judul')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- DESKRIPSI --}}
            <div>

                <label
                    for="deskripsi"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Deskripsi
                    <span class="text-xs font-normal text-slate-400">
                        (Opsional)
                    </span>
                </label>

                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                    placeholder="Tambahkan deskripsi singkat mengenai dokumen..."
                    class="w-full resize-none rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                >{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>

                @error('deskripsi')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- FILE --}}
            <div>

                <label
                    for="file"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    File Dokumen
                    @if(!isset($item))
                        <span class="text-red-500">*</span>
                    @else
                        <span class="text-xs font-normal text-slate-400">
                            (Opsional jika tidak mengganti file)
                        </span>
                    @endif
                </label>

                <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-600">
                                <i class="bx bxs-file-pdf text-2xl"></i>
                            </div>

                            <div>

                                <p class="text-sm font-semibold text-slate-700">
                                    Dokumen PDF
                                </p>

                                <p class="text-xs text-slate-400">
                                    Format PDF, maksimal 10 MB
                                </p>

                            </div>

                        </div>

                        <input
                            id="file"
                            type="file"
                            name="file"
                            accept="application/pdf"
                            @unless(isset($item)) required @endunless
                            class="block w-full text-sm text-slate-500 sm:w-auto file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100"
                        >

                    </div>


                    @isset($item)

                        @if($item->file_path)

                            <div class="mt-4 flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs text-slate-500">

                                <i class="bx bx-file text-blue-600"></i>

                                <span>
                                    File saat ini sudah tersimpan.
                                </span>

                            </div>

                        @endif

                    @endisset

                </div>

                @error('file')
                    <p class="mt-1 text-xs text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- STATUS + TANGGAL --}}
            <div class="grid gap-5 md:grid-cols-2">

                {{-- STATUS --}}
                <div>

                    <label
                        for="status_publikasi"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Status Publikasi
                        <span class="text-red-500">*</span>
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

                    @error('status_publikasi')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- TANGGAL PUBLIKASI --}}
                <div>

                    <label
                        for="tanggal_publikasi"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Tanggal Publikasi
                        <span class="text-xs font-normal text-slate-400">
                            (Opsional)
                        </span>
                    </label>

                    <input
                        id="tanggal_publikasi"
                        type="date"
                        name="tanggal_publikasi"
                        value="{{ old(
                            'tanggal_publikasi',
                            isset($item) && $item->tanggal_publikasi
                                ? $item->tanggal_publikasi->format('Y-m-d')
                                : ''
                        ) }}"
                        class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >

                    @error('tanggal_publikasi')
                        <p class="mt-1 text-xs text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-end">

            <a
                href="{{ route('admin.dokumen.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-100"
            >
                Batal
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
            >
                <i class="bx bx-save text-lg"></i>

                {{ isset($item) ? 'Simpan Perubahan' : 'Simpan Dokumen' }}
            </button>

        </div>

    </form>

</div>

@endsection