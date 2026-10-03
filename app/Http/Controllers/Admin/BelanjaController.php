<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Belanja;
use App\Models\BelanjaRekening;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\SubBidang;
use App\Models\TahunAnggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BelanjaController extends Controller
{
    /**
     * Daftar data belanja.
     */
    public function index(): View
    {
        $items = Belanja::with([
            'tahunAnggaran',
            'bidang',
            'kegiatan.subBidang',
            'belanjaRekening',
        ])
            ->orderByDesc('tahun_anggaran_id')
            ->orderBy('bidang_id')
            ->orderBy('kegiatan_id')
            ->orderBy('belanja_rekening_id')
            ->paginate(15);

        return view('admin.belanja.index', compact('items'));
    }

    /**
     * Form tambah data belanja.
     */
    public function create(): View
    {
        return view('admin.belanja.form', $this->formData());
    }

    /**
     * Form edit data belanja.
     */
    public function edit(Belanja $belanja): View
    {
        $belanja->load([
            'tahunAnggaran',
            'bidang',
            'kegiatan.subBidang',
            'belanjaRekening',
        ]);

        return view('admin.belanja.form', $this->formData([
            'item' => $belanja,
        ]));
    }

    /**
     * Simpan data belanja baru.
     */
    public function store(Request $request): RedirectResponse
    {
        Belanja::create(
            $this->validated($request)
        );

        return to_route('admin.belanja.index')
            ->with(
                'success',
                'Data belanja berhasil ditambahkan.'
            );
    }

    /**
     * Perbarui data belanja.
     */
    public function update(
        Request $request,
        Belanja $belanja
    ): RedirectResponse {
        $belanja->update(
            $this->validated($request, $belanja)
        );

        return to_route('admin.belanja.index')
            ->with(
                'success',
                'Data belanja berhasil diperbarui.'
            );
    }

    /**
     * Hapus satu data belanja.
     */
    public function destroy(
        Belanja $belanja
    ): RedirectResponse {
        $belanja->delete();

        return back()->with(
            'success',
            'Data belanja berhasil dihapus.'
        );
    }

    /**
     * Hapus seluruh data belanja.
     *
     * Yang dihapus hanya data pada tabel belanja.
     * Master Bidang, Sub Bidang, Kegiatan,
     * dan Rekening Belanja tetap aman.
     */
    public function destroyAll(): RedirectResponse
    {
        $jumlah = Belanja::count();

        Belanja::query()->delete();

        return to_route('admin.belanja.index')
            ->with(
                'success',
                "Semua data belanja berhasil dihapus. Total {$jumlah} data."
            );
    }

    /**
     * Ubah status publikasi.
     */
    public function publication(
        Belanja $belanja
    ): RedirectResponse {
        $belanja->update([
            'status_publikasi' =>
                $belanja->status_publikasi === 'dipublikasikan'
                    ? 'draft'
                    : 'dipublikasikan',
        ]);

        return back()->with(
            'success',
            'Status publikasi diperbarui.'
        );
    }

    /**
     * Data master untuk form tambah/edit.
     */
    private function formData(
        array $extra = []
    ): array {
        return array_merge([
            /*
             * Tahun Anggaran
             */
            'years' => TahunAnggaran::query()
                ->orderByDesc('tahun')
                ->get(),

            /*
             * Bidang
             */
            'bidang' => Bidang::query()
                ->orderBy('tahun_anggaran_id')
                ->orderBy('kode')
                ->get(),

            /*
             * Sub Bidang
             */
            'subBidang' => SubBidang::query()
                ->orderBy('tahun_anggaran_id')
                ->orderBy('bidang_id')
                ->orderBy('kode')
                ->get(),

            /*
             * Kegiatan
             */
            'kegiatan' => Kegiatan::query()
                ->orderBy('tahun_anggaran_id')
                ->orderBy('sub_bidang_id')
                ->orderBy('kode')
                ->get(),

            /*
             * Rekening Belanja
             *
             * Hanya rekening detail:
             * 5.1.1.01
             * 5.1.1.02
             * 5.2.1.01
             * dst.
             */
            'rekening' => BelanjaRekening::query()
                ->where('is_active', true)
                ->whereRaw(
                    "kode REGEXP '^[0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+$'"
                )
                ->orderBy('kode')
                ->get(),

        ], $extra);
    }

    /**
     * Validasi dan normalisasi data belanja.
     */
    private function validated(
        Request $request,
        ?Belanja $belanja = null
    ): array {
        /*
         * Validasi dasar.
         */
        $data = $request->validate([
            'tahun_anggaran_id' => [
                'required',
                'exists:tahun_anggaran,id',
            ],

            'bidang_id' => [
                'required',
                'exists:bidang,id',
            ],

            'sub_bidang_id' => [
                'required',
                'exists:sub_bidang,id',
            ],

            'kegiatan_id' => [
                'required',
                'exists:kegiatan,id',
            ],

            'belanja_rekening_id' => [
                'required',
                'exists:belanja_rekenings,id',
            ],

            'anggaran' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status_publikasi' => [
                'required',
                'in:draft,dipublikasikan',
            ],
        ]);

        /*
         * Ambil data master.
         */
        $bidang = Bidang::findOrFail(
            $data['bidang_id']
        );

        $subBidang = SubBidang::findOrFail(
            $data['sub_bidang_id']
        );

        $kegiatan = Kegiatan::findOrFail(
            $data['kegiatan_id']
        );

        $rekening = BelanjaRekening::findOrFail(
            $data['belanja_rekening_id']
        );

        /*
         * =========================================================
         * VALIDASI TAHUN → BIDANG
         * =========================================================
         */
        if (
            (int) $bidang->tahun_anggaran_id
            !== (int) $data['tahun_anggaran_id']
        ) {
            throw ValidationException::withMessages([
                'bidang_id' =>
                    'Bidang tidak sesuai dengan Tahun Anggaran.',
            ]);
        }

        /*
         * =========================================================
         * VALIDASI TAHUN → BIDANG → SUB BIDANG
         * =========================================================
         */
        if (
            (int) $subBidang->tahun_anggaran_id
            !== (int) $data['tahun_anggaran_id']
            ||
            (int) $subBidang->bidang_id
            !== (int) $bidang->id
        ) {
            throw ValidationException::withMessages([
                'sub_bidang_id' =>
                    'Sub Bidang tidak sesuai dengan Bidang/Tahun Anggaran.',
            ]);
        }

        /*
         * =========================================================
         * VALIDASI TAHUN → SUB BIDANG → KEGIATAN
         * =========================================================
         */
        if (
            (int) $kegiatan->tahun_anggaran_id
            !== (int) $data['tahun_anggaran_id']
            ||
            (int) $kegiatan->sub_bidang_id
            !== (int) $subBidang->id
        ) {
            throw ValidationException::withMessages([
                'kegiatan_id' =>
                    'Kegiatan tidak sesuai dengan Sub Bidang/Tahun Anggaran.',
            ]);
        }

        /*
         * =========================================================
         * VALIDASI REKENING DETAIL
         * =========================================================
         *
         * Contoh valid:
         * 5.1.1.01
         * 5.1.2.01
         * 5.2.2.05
         *
         * Tidak menerima:
         * 5
         * 5.1
         * 5.1.1
         */
        if (
            !preg_match(
                '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/',
                $rekening->kode
            )
        ) {
            throw ValidationException::withMessages([
                'belanja_rekening_id' =>
                    'Rekening yang dipilih bukan rekening detail.',
            ]);
        }

        /*
         * =========================================================
         * VALIDASI REKENING AKTIF
         * =========================================================
         */
        if (!$rekening->is_active) {
            throw ValidationException::withMessages([
                'belanja_rekening_id' =>
                    'Rekening yang dipilih sudah tidak aktif.',
            ]);
        }

        /*
         * =========================================================
         * CEK DUPLIKAT
         * =========================================================
         *
         * Satu rekening tidak boleh digunakan dua kali
         * dalam kegiatan yang sama pada tahun yang sama.
         */
        $duplicate = Belanja::query()
            ->where(
                'tahun_anggaran_id',
                $data['tahun_anggaran_id']
            )
            ->where(
                'kegiatan_id',
                $data['kegiatan_id']
            )
            ->where(
                'belanja_rekening_id',
                $data['belanja_rekening_id']
            )
            ->when(
                $belanja,
                fn ($query) =>
                    $query->where(
                        'id',
                        '!=',
                        $belanja->id
                    )
            )
            ->exists();

        if ($duplicate) {
            throw ValidationException::withMessages([
                'belanja_rekening_id' =>
                    'Rekening tersebut sudah digunakan pada kegiatan yang dipilih.',
            ]);
        }

        /*
         * =========================================================
         * ISI OTOMATIS DARI MASTER REKENING
         * =========================================================
         */
        $data['kode'] = $rekening->kode;
        $data['uraian'] = $rekening->uraian;

        /*
         * Urutan tidak lagi diketik oleh pengguna.
         */
        $data['urutan'] = 0;

        return $data;
    }
}