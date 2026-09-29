@extends('layouts.admin')

@section('title', 'Pendapatan')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-blue-600">Publikasi APBDesa</p>
            <h1 class="mt-1 text-3xl font-bold tracking-tight text-slate-900">Pendapatan Desa</h1>
            <p class="mt-2 text-sm text-slate-500">Kelola data anggaran pendapatan yang akan ditampilkan kepada masyarakat.</p>
        </div>
        <a href="{{ route('admin.pendapatan.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i class='bx bx-plus text-lg'></i> Tambah Pendapatan
        </a>
    </div>

    <section class="mt-7 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="font-semibold text-slate-900">Daftar Pendapatan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-[860px] w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-6 py-4">No</th><th class="px-6 py-4">Kode Rekening</th><th class="px-6 py-4">Uraian Pendapatan</th><th class="px-6 py-4">Tahun</th><th class="px-6 py-4 text-right">Anggaran</th><th class="px-6 py-4">Status</th><th class="px-6 py-4 text-right">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pendapatan as $item)
                        <tr class="transition hover:bg-slate-50/80">
                            <td class="px-6 py-4 text-slate-500">{{ $pendapatan->firstItem() + $loop->index }}</td><td class="px-6 py-4 font-semibold text-blue-700">{{ $item->kode }}</td><td class="px-6 py-4 font-semibold text-slate-800">{{ $item->uraian }}</td><td class="px-6 py-4 font-medium text-slate-600">{{ $item->tahunAnggaran->tahun }}</td><td class="px-6 py-4 text-right font-semibold text-slate-800">Rp {{ number_format($item->anggaran, 0, ',', '.') }}</td><td class="px-6 py-4"><span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $item->status_publikasi === 'dipublikasikan' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}">{{ $item->status_publikasi === 'dipublikasikan' ? 'Dipublikasikan' : 'Draft' }}</span></td><td class="px-6 py-4"><div class="flex justify-end gap-2"><a href="{{ route('admin.pendapatan.edit', $item) }}" class="rounded-lg border border-slate-200 p-2 text-slate-600"><i class='bx bx-pencil text-lg'></i></a><form method="POST" action="{{ route('admin.pendapatan.publication', $item) }}">@csrf @method('PATCH')<button class="rounded-lg border border-slate-200 p-2 text-slate-600"><i class='bx bx-show text-lg'></i></button></form><form method="POST" action="{{ route('admin.pendapatan.destroy', $item) }}" onsubmit="return confirm('Hapus data pendapatan ini?')">@csrf @method('DELETE')<button class="rounded-lg border border-slate-200 p-2 text-red-600"><i class='bx bx-trash text-lg'></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-16 text-center"><i class='bx bx-folder-open text-4xl text-slate-300'></i><p class="mt-3 font-semibold text-slate-700">Belum ada data pendapatan</p><p class="mt-1 text-sm text-slate-500">Mulai dengan menambahkan anggaran pendapatan desa.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($pendapatan->hasPages())<div class="border-t border-slate-100 px-6 py-4">{{ $pendapatan->links() }}</div>@endif
    </section>
@endsection
