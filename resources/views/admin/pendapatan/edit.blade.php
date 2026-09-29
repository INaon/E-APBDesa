@extends('layouts.admin')

@section('title', 'Ubah Pendapatan')

@section('content')
    <div class="max-w-3xl"><a href="{{ route('admin.pendapatan.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-700 hover:text-blue-800"><i class='bx bx-left-arrow-alt text-lg'></i> Kembali ke Pendapatan</a><h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900">Ubah Pendapatan</h1><p class="mt-2 text-sm text-slate-500">Perbarui informasi dan status publikasi pendapatan desa.</p><form method="POST" action="{{ route('admin.pendapatan.update', $pendapatan) }}" class="mt-7 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">@csrf @method('PUT') @include('admin.pendapatan._form')</form></div>
@endsection
