@extends('layouts.public')

@section('title', 'Pendapatan Desa')

@section('content')
    <section class="mx-auto max-w-6xl px-6 py-12 sm:px-8">
        <div class="rounded-3xl bg-gradient-to-br from-slate-900 to-blue-800 px-7 py-10 text-white shadow-xl sm:px-10">
            <p class="text-sm font-semibold uppercase tracking-[.18em] text-blue-200">APBDesa {{ $year->tahun }}</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight sm:text-4xl">Pendapatan {{ $desa->nama }}</h1>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-slate-200">Rincian sumber pendapatan yang telah dipublikasikan sebagai bentuk transparansi anggaran desa.</p>
            <div class="mt-7 inline-flex rounded-2xl border border-white/15 bg-white/10 px-5 py-4 backdrop-blur"><div><p class="text-xs font-medium uppercase tracking-wide text-blue-100">Total Pendapatan</p><p class="mt-1 text-2xl font-bold">Rp {{ number_format($summary['income'], 0, ',', '.') }}</p></div></div>
        </div>

        <section class="mt-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-6 py-5"><h2 class="font-bold text-slate-900">Rincian Pendapatan</h2><p class="mt-1 text-sm text-slate-500">Data berikut hanya memuat item yang telah dipublikasikan.</p></div>
            <div class="divide-y divide-slate-100">
                @forelse ($pendapatan as $item)
                    <article class="flex flex-col gap-3 px-6 py-5 sm:flex-row sm:items-center sm:justify-between"><div><span class="inline-flex rounded-md bg-blue-50 px-2 py-1 text-xs font-bold text-blue-700">{{ $item->kode }}</span><h3 class="mt-2 font-semibold text-slate-800">{{ $item->uraian }}</h3><p class="mt-1 text-sm text-slate-500">{{ $item->kelompok }}</p></div><p class="shrink-0 text-lg font-bold text-slate-900">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</p></article>
                @empty
                    <div class="px-6 py-16 text-center"><i class='bx bx-file-blank text-4xl text-slate-300'></i><p class="mt-3 font-semibold text-slate-700">Belum ada pendapatan yang dipublikasikan.</p></div>
                @endforelse
            </div>
            <div class="flex items-center justify-between bg-slate-50 px-6 py-5"><span class="font-semibold text-slate-700">Total Pendapatan</span><span class="text-lg font-bold text-blue-700">Rp {{ number_format($summary['income'], 0, ',', '.') }}</span></div>
        </section>
    </section>
@endsection
