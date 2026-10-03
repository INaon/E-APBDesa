@extends('layouts.admin')

@section('title', 'Pembiayaan')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-800">
                Pembiayaan
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Kelola data pembiayaan APBDesa berdasarkan Tahun Anggaran.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            {{-- HAPUS SEMUA --}}
            @if($items->total() > 0)
                <form
                    method="POST"
                    action="{{ route('admin.pembiayaan.destroyAll') }}"
                    onsubmit="return confirm(
                        'PERINGATAN!\n\n' +
                        'Apakah Anda yakin ingin menghapus SEMUA data pembiayaan?\n\n' +
                        'Semua data pembiayaan akan dihapus dan tidak dapat dikembalikan.\n\n' +
                        'Klik OK untuk melanjutkan.'
                    )"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50"
                    >
                        <i class="bx bx-trash text-lg"></i>
                        Hapus Semua
                    </button>
                </form>
            @endif

            {{-- TAMBAH --}}
            <a
                href="{{ route('admin.pembiayaan.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800"
            >
                <i class="bx bx-plus text-lg"></i>
                Tambah Pembiayaan
            </a>

        </div>
    </div>


    {{-- TABLE --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] table-fixed">

                <colgroup>
                    <col style="width: 55px;">
                    <col style="width: 90px;">
                    <col style="width: 135px;">
                    <col style="width: 110px;">
                    <col style="width: 290px;">
                    <col style="width: 150px;">
                    <col style="width: 125px;">
                    <col style="width: 155px;">
                </colgroup>

                <thead class="border-b border-slate-200 bg-slate-50">

                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">

                        <th class="px-4 py-3">
                            No
                        </th>

                        <th class="px-4 py-3">
                            Tahun
                        </th>

                        <th class="px-4 py-3">
                            Jenis
                        </th>

                        <th class="px-4 py-3">
                            Kode
                        </th>

                        <th class="px-4 py-3">
                            Uraian
                        </th>

                        <th class="px-4 py-3 text-right">
                            Anggaran
                        </th>

                        <th class="px-4 py-3">
                            Status
                        </th>

                        <th class="px-4 py-3 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($items as $item)

                        <tr class="transition hover:bg-slate-50">

                            {{-- NO --}}
                            <td class="px-4 py-3 text-sm text-slate-500">
                                {{ $items->firstItem() + $loop->index }}
                            </td>


                            {{-- TAHUN --}}
                            <td class="px-4 py-3">

                                <span class="text-sm font-semibold text-slate-700">
                                    {{ $item->tahunAnggaran?->tahun ?? '-' }}
                                </span>

                            </td>


                            {{-- JENIS --}}
                            <td class="px-4 py-3">

                                @if($item->jenis === 'penerimaan')

                                    <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        Penerimaan
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-orange-50 px-2.5 py-1 text-xs font-semibold text-orange-700">
                                        Pengeluaran
                                    </span>

                                @endif

                            </td>


                            {{-- KODE --}}
                            <td class="px-4 py-3">

                                <span class="font-mono text-sm font-semibold text-slate-700">
                                    {{ $item->kode ?: '-' }}
                                </span>

                            </td>


                            {{-- URAIAN --}}
                            <td class="px-4 py-3">

                                <div
                                    class="line-clamp-2 text-sm font-medium text-slate-700"
                                    title="{{ $item->uraian }}"
                                >
                                    {{ $item->uraian }}
                                </div>

                            </td>


                            {{-- ANGGARAN --}}
                            <td class="px-4 py-3 text-right">

                                <span class="text-sm font-semibold text-slate-700">
                                    Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                                </span>

                            </td>


                            {{-- STATUS --}}
                            <td class="px-4 py-3">

                                @if($item->status_publikasi === 'dipublikasikan')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Dipublikasikan
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Draft
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}
                            <td class="px-4 py-3">

                                <div class="flex items-center justify-center gap-1.5">

                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin.pembiayaan.edit', $item) }}"
                                        title="Ubah"
                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                    >
                                        <i class="bx bx-edit text-lg"></i>
                                    </a>


                                    {{-- PUBLIKASI --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.pembiayaan.publication', $item) }}"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            title="{{ $item->status_publikasi === 'dipublikasikan' ? 'Tarik ke Draft' : 'Publikasikan' }}"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600"
                                        >
                                            <i class="bx {{ $item->status_publikasi === 'dipublikasikan' ? 'bx-hide' : 'bx-globe' }} text-lg"></i>
                                        </button>

                                    </form>


                                    {{-- HAPUS --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.pembiayaan.destroy', $item) }}"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pembiayaan ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Hapus"
                                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                        >
                                            <i class="bx bx-trash text-lg"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="px-6 py-16 text-center"
                            >

                                <div class="flex flex-col items-center justify-center">

                                    <div class="mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i class="bx bx-wallet text-3xl"></i>
                                    </div>

                                    <p class="text-sm font-semibold text-slate-700">
                                        Belum ada pembiayaan
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Silakan tambahkan data pembiayaan terlebih dahulu.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        @if($items->hasPages())

            <div class="border-t border-slate-100 px-4 py-4">
                {{ $items->links() }}
            </div>

        @endif

    </div>

</div>

@endsection