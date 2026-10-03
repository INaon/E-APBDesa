@extends('layouts.admin')

@section('title', 'Profil Desa')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            Profil Desa
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Kelola informasi dan identitas Desa yang digunakan pada aplikasi.
        </p>
    </div>


    <form
        method="POST"
        action="{{ route('admin.profile.update') }}"
        enctype="multipart/form-data"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- Logo Desa --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Logo Desa
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Logo ini akan digunakan sebagai identitas Desa pada panel administrasi.
                </p>
            </div>


            <div class="p-6">

                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">

                    {{-- Preview --}}
                    <div
                        class="flex h-32 w-32 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"
                    >

                        @if($desa->logo)

                            <img
                                id="logoPreview"
                                src="{{ asset('storage/' . $desa->logo) }}"
                                alt="Logo {{ $desa->nama }}"
                                class="h-full w-full object-contain p-3"
                            >

                        @else

                            <div
                                id="logoPlaceholder"
                                class="flex flex-col items-center justify-center text-slate-400"
                            >
                                <i class="bx bx-image text-4xl"></i>

                                <span class="mt-1 text-xs">
                                    Belum ada logo
                                </span>
                            </div>

                            <img
                                id="logoPreview"
                                src=""
                                alt="Preview Logo"
                                class="hidden h-full w-full object-contain p-3"
                            >

                        @endif

                    </div>


                    {{-- Upload --}}
                    <div class="min-w-0 flex-1">

                        <label
                            for="logo"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Pilih Logo
                        </label>

                        <input
                            id="logo"
                            name="logo"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            class="block w-full rounded-xl border border-slate-300 bg-white text-sm text-slate-700
                                   file:mr-4 file:rounded-lg file:border-0 file:bg-slate-100
                                   file:px-4 file:py-2 file:text-sm file:font-semibold
                                   file:text-slate-700 hover:file:bg-slate-200"
                        >

                        <p class="mt-2 text-xs text-slate-500">
                            Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                        </p>

                        @error('logo')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- Informasi Desa --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Informasi Desa
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Informasi dasar Desa yang ditampilkan pada sistem.
                </p>
            </div>


            <div class="grid gap-5 p-6 md:grid-cols-2">

                {{-- Nama Desa --}}
                <div>
                    <label
                        for="nama"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Nama Desa
                    </label>

                    <input
                        id="nama"
                        name="nama"
                        type="text"
                        value="{{ old('nama', $desa->nama) }}"
                        required
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Kecamatan --}}
                <div>
                    <label
                        for="kecamatan"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Kecamatan
                    </label>

                    <input
                        id="kecamatan"
                        name="kecamatan"
                        type="text"
                        value="{{ old('kecamatan', $desa->kecamatan) }}"
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('kecamatan')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Kabupaten --}}
                <div>
                    <label
                        for="kabupaten"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Kabupaten
                    </label>

                    <input
                        id="kabupaten"
                        name="kabupaten"
                        type="text"
                        value="{{ old('kabupaten', $desa->kabupaten) }}"
                        required
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('kabupaten')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Provinsi --}}
                <div>
                    <label
                        for="provinsi"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Provinsi
                    </label>

                    <input
                        id="provinsi"
                        name="provinsi"
                        type="text"
                        value="{{ old('provinsi', $desa->provinsi) }}"
                        required
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('provinsi')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Website --}}
                <div>
                    <label
                        for="website"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Website
                    </label>

                    <input
                        id="website"
                        name="website"
                        type="url"
                        value="{{ old('website', $desa->website) }}"
                        placeholder="https://..."
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('website')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $desa->email) }}"
                        placeholder="email@desa.go.id"
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>


                {{-- Alamat --}}
                <div class="md:col-span-2">

                    <label
                        for="alamat"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        class="w-full rounded-xl border-slate-300 px-4 py-2.5 text-sm
                               shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    >{{ old('alamat', $desa->alamat) }}</textarea>

                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Tombol --}}
        <div class="flex justify-end">

            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5
                       text-sm font-semibold text-white shadow-sm transition
                       hover:bg-blue-700"
            >
                <i class="bx bx-save text-lg"></i>
                Simpan Profil
            </button>

        </div>

    </form>

</div>


{{-- Preview Logo --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const input = document.getElementById('logo');
        const preview = document.getElementById('logoPreview');
        const placeholder = document.getElementById('logoPlaceholder');

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', function (event) {

            const file = event.target.files[0];

            if (!file) {
                return;
            }

            if (!file.type.startsWith('image/')) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {

                preview.src = e.target.result;
                preview.classList.remove('hidden');

                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            };

            reader.readAsDataURL(file);
        });

    });
</script>

@endsection