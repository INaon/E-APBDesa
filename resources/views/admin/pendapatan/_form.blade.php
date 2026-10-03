@php
    $selectedRekeningId = old(
        'pendapatan_rekening_id',
        $pendapatan->pendapatan_rekening_id ?? ''
    );

    $selectedRekening = $rekenings->firstWhere(
        'id',
        (int) $selectedRekeningId
    );

    $selectedRekeningLabel = $selectedRekening
        ? $selectedRekening->kode . ' — ' . $selectedRekening->uraian
        : '';

    $oldAnggaran = old(
        'anggaran',
        $pendapatan->anggaran ?? ''
    );
@endphp


<div
    class="grid gap-5 md:grid-cols-2"
    x-data="{
        search: '',
        open: false,
        selected: '{{ $selectedRekeningId }}',
        selectedLabel: @js($selectedRekeningLabel)
    }"
>
    {{-- =========================================================
         TAHUN ANGGARAN
    ========================================================== --}}
    <label class="block">
        <span class="mb-2 block text-sm font-semibold text-slate-700">
            Tahun Anggaran
        </span>

        <select
            name="tahun_anggaran_id"
            required
            class="w-full rounded-xl border-slate-300 bg-white
                   text-sm shadow-sm
                   focus:border-blue-500 focus:ring-blue-500"
        >
            @foreach ($years as $year)
                <option
                    value="{{ $year->id }}"
                    @selected(
                        old(
                            'tahun_anggaran_id',
                            $pendapatan->tahun_anggaran_id ?? ''
                        ) == $year->id
                    )
                >
                    {{ $year->tahun }}
                    {{ $year->status === 'aktif' ? ' · Aktif' : '' }}
                </option>
            @endforeach
        </select>

        @error('tahun_anggaran_id')
            <p class="mt-1 text-xs text-red-600">
                {{ $message }}
            </p>
        @enderror
    </label>


    {{-- =========================================================
         REKENING PENDAPATAN
    ========================================================== --}}
    <div
        class="relative md:col-span-2"
        @click.outside="open = false"
    >
        <span class="mb-2 block text-sm font-semibold text-slate-700">
            Rekening Pendapatan
        </span>

        {{-- Nilai yang dikirim ke Laravel --}}
        <input
            type="hidden"
            name="pendapatan_rekening_id"
            x-model="selected"
        >

        {{-- Tombol Dropdown --}}
        <button
            type="button"
            @click="open = !open"
            class="flex w-full items-center justify-between
                   rounded-xl border border-slate-300
                   bg-white px-4 py-3
                   text-left text-sm shadow-sm transition
                   hover:border-blue-400
                   focus:border-blue-500
                   focus:outline-none
                   focus:ring-2 focus:ring-blue-500/20"
        >
            <div class="flex min-w-0 items-center gap-3">

                <div
                    class="flex h-9 w-9 shrink-0 items-center
                           justify-center rounded-lg bg-blue-50
                           text-blue-600"
                >
                    <i class="bx bx-book-open text-lg"></i>
                </div>

                <span
                    class="truncate"
                    :class="selectedLabel
                        ? 'font-semibold text-slate-800'
                        : 'text-slate-400'"
                    x-text="selectedLabel || 'Pilih rekening pendapatan...'"
                ></span>
            </div>

            <i
                class="bx bx-chevron-down ml-3 shrink-0 text-xl
                       text-slate-400 transition-transform"
                :class="{ 'rotate-180': open }"
            ></i>
        </button>


        {{-- Panel Dropdown --}}
        <div
            x-cloak
            x-show="open"
            x-transition
            class="absolute left-0 right-0 z-50 mt-2
                   overflow-hidden rounded-2xl
                   border border-slate-200
                   bg-white shadow-2xl"
        >

            {{-- =================================================
                 PENCARIAN REKENING
            ================================================== --}}
            <div class="border-b border-slate-100 bg-slate-50 p-3">
                <div class="relative">

                    <i
                        class="bx bx-search pointer-events-none
                               absolute left-4 top-1/2
                               -translate-y-1/2 text-lg
                               text-slate-400"
                    ></i>

                    <input
                        type="search"
                        x-model="search"
                        @click.stop
                        placeholder="Cari kode atau uraian rekening..."
                        class="w-full rounded-xl
                               border-slate-200 bg-white
                               py-2.5 pl-12 pr-3
                               text-sm shadow-sm
                               focus:border-blue-500
                               focus:ring-blue-500"
                    >

                </div>
            </div>


            {{-- =================================================
                 DAFTAR REKENING
            ================================================== --}}
            <div class="max-h-72 overflow-y-auto p-2">

                @foreach ($rekenings as $rekening)
                    @php
                        $searchText = strtolower(
                            $rekening->kode . ' ' . $rekening->uraian
                        );
                    @endphp

                    <button
                        type="button"
                        x-show="@js($searchText).includes(search.toLowerCase())"
                        @click="
                            selected = '{{ $rekening->id }}';
                            selectedLabel = @js(
                                $rekening->kode . ' — ' . $rekening->uraian
                            );
                            search = '';
                            open = false;
                        "
                        class="flex w-full items-center gap-3
                               rounded-xl px-3 py-2.5
                               text-left text-sm transition
                               hover:bg-blue-50"
                        :class="
                            selected == '{{ $rekening->id }}'
                                ? 'bg-blue-50 text-blue-700'
                                : 'text-slate-700'
                        "
                    >

                        {{-- Kode Rekening --}}
                        <span
                            class="shrink-0 rounded-lg
                                   bg-slate-100 px-2.5 py-1.5
                                   font-mono text-xs font-semibold
                                   text-slate-600"
                        >
                            {{ $rekening->kode }}
                        </span>

                        {{-- Uraian Rekening --}}
                        <span
                            class="min-w-0 flex-1 leading-5"
                        >
                            {{ $rekening->uraian }}
                        </span>

                        {{-- Tanda Terpilih --}}
                        <i
                            x-show="selected == '{{ $rekening->id }}'"
                            class="bx bx-check shrink-0
                                   text-xl text-blue-600"
                        ></i>

                    </button>
                @endforeach

            </div>
        </div>


        {{-- Keterangan --}}
        <p class="mt-2 text-xs text-slate-500">
            <i class="bx bx-info-circle mr-1"></i>
            Hanya rekening detail yang dapat dipilih.
            Kode, uraian, dan kelompok mengikuti master rekening SiskeuDes.
        </p>

        @error('pendapatan_rekening_id')
            <p class="mt-1 text-xs text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>


    {{-- =========================================================
         ANGGARAN
    ========================================================== --}}
    <div
        class="block"
        x-data="{
            raw: '{{ $oldAnggaran }}',

            formatRupiah(value) {
                if (value === null || value === undefined) {
                    return '';
                }

                let number = String(value).replace(/\D/g, '');

                if (!number) {
                    return '';
                }

                return new Intl.NumberFormat('id-ID').format(number);
            }
        }"
    >
        <span class="mb-2 block text-sm font-semibold text-slate-700">
            Anggaran (Rp)
        </span>

        {{-- Nilai angka asli yang dikirim ke Laravel --}}
        <input
            type="hidden"
            name="anggaran"
            x-model="raw"
        >

        <div class="relative">

            {{-- Prefix Rupiah --}}
            <span
                class="pointer-events-none absolute left-4 top-1/2
                       -translate-y-1/2
                       text-sm font-semibold text-slate-500"
            >
                Rp
            </span>

            {{-- Input Tampilan Rupiah --}}
            <input
                type="text"
                inputmode="numeric"
                autocomplete="off"
                :value="formatRupiah(raw)"
                @input="
                    raw = $event.target.value.replace(/\D/g, '');
                    $event.target.value = formatRupiah(raw);
                "
                placeholder="0"
                required
                class="w-full rounded-xl
                       border-slate-300
                       bg-white
                       py-3 pl-12 pr-4
                       text-sm font-semibold
                       text-slate-800
                       shadow-sm
                       focus:border-blue-500
                       focus:ring-blue-500"
            >

        </div>

        <p class="mt-1.5 text-xs text-slate-400">
            Masukkan nilai anggaran tanpa titik atau koma.
        </p>

        @error('anggaran')
            <p class="mt-1 text-xs text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>


    {{-- =========================================================
         STATUS PUBLIKASI
    ========================================================== --}}
    <label class="block">
        <span class="mb-2 block text-sm font-semibold text-slate-700">
            Status Publikasi
        </span>

        <select
            name="status_publikasi"
            required
            class="w-full rounded-xl
                   border-slate-300
                   bg-white
                   py-3
                   text-sm shadow-sm
                   focus:border-blue-500
                   focus:ring-blue-500"
        >
            <option
                value="draft"
                @selected(
                    old(
                        'status_publikasi',
                        $pendapatan->status_publikasi ?? 'draft'
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
                        $pendapatan->status_publikasi ?? ''
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
    </label>

</div>


{{-- =============================================================
     TOMBOL AKSI
============================================================== --}}
<div
    class="mt-7 flex flex-wrap justify-end gap-3
           border-t border-slate-100 pt-5"
>
    <a
        href="{{ route('admin.pendapatan.index') }}"
        class="rounded-xl border border-slate-200
               px-4 py-2.5
               text-sm font-semibold text-slate-600
               transition hover:bg-slate-50"
    >
        <i class="bx bx-arrow-back mr-1"></i>
        Batal
    </a>

    <button
        type="submit"
        class="rounded-xl bg-blue-700
               px-5 py-2.5
               text-sm font-semibold text-white
               shadow-sm transition
               hover:bg-blue-800
               focus:outline-none
               focus:ring-2 focus:ring-blue-500
               focus:ring-offset-2"
    >
        <i class="bx bx-save mr-1"></i>
        Simpan Pendapatan
    </button>
</div>