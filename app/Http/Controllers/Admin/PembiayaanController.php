<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembiayaan;
use App\Models\PembiayaanRekening;
use App\Models\TahunAnggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PembiayaanController extends Controller
{
    public function index(): View
    {
        $items = Pembiayaan::with([
            'tahunAnggaran',
            'pembiayaanRekening',
        ])
            ->orderByDesc('tahun_anggaran_id')
            ->orderBy('jenis')
            ->orderBy('kode')
            ->paginate(12);

        return view(
            'admin.pembiayaan.index',
            compact('items')
        );
    }


    public function create(): View
    {
        $years = TahunAnggaran::query()
            ->orderByDesc('tahun')
            ->get();

        $rekening = PembiayaanRekening::query()
            ->where('is_active', true)
            ->where('level', 4)
            ->orderBy('kode')
            ->get();

        return view(
            'admin.pembiayaan.form',
            compact(
                'years',
                'rekening'
            )
        );
    }


    public function edit(
        Pembiayaan $pembiayaan
    ): View {
        $pembiayaan->load([
            'tahunAnggaran',
            'pembiayaanRekening',
        ]);

        $years = TahunAnggaran::query()
            ->orderByDesc('tahun')
            ->get();

        $rekening = PembiayaanRekening::query()
            ->where('is_active', true)
            ->where('level', 4)
            ->orderBy('kode')
            ->get();

        return view(
            'admin.pembiayaan.form',
            [
                'item' => $pembiayaan,
                'years' => $years,
                'rekening' => $rekening,
            ]
        );
    }


    public function store(
        Request $request
    ): RedirectResponse {
        Pembiayaan::create(
            $this->validated($request)
        );

        return to_route(
            'admin.pembiayaan.index'
        )->with(
            'success',
            'Data pembiayaan berhasil ditambahkan.'
        );
    }


    public function update(
        Request $request,
        Pembiayaan $pembiayaan
    ): RedirectResponse {
        $pembiayaan->update(
            $this->validated(
                $request,
                $pembiayaan
            )
        );

        return to_route(
            'admin.pembiayaan.index'
        )->with(
            'success',
            'Data pembiayaan berhasil diperbarui.'
        );
    }


    public function destroy(
        Pembiayaan $pembiayaan
    ): RedirectResponse {
        $pembiayaan->delete();

        return back()->with(
            'success',
            'Data pembiayaan berhasil dihapus.'
        );
    }


    public function destroyAll(): RedirectResponse
    {
        $jumlah = Pembiayaan::count();

        Pembiayaan::query()->delete();

        return to_route(
            'admin.pembiayaan.index'
        )->with(
            'success',
            "Semua data pembiayaan berhasil dihapus. Total {$jumlah} data."
        );
    }


    public function publication(
        Pembiayaan $pembiayaan
    ): RedirectResponse {
        $pembiayaan->update([
            'status_publikasi' =>
                $pembiayaan->status_publikasi === 'dipublikasikan'
                    ? 'draft'
                    : 'dipublikasikan',
        ]);

        return back()->with(
            'success',
            'Status publikasi diperbarui.'
        );
    }


    private function validated(
        Request $request,
        ?Pembiayaan $pembiayaan = null
    ): array {
        $data = $request->validate([
            'tahun_anggaran_id' => [
                'required',
                'exists:tahun_anggaran,id',
            ],

            'pembiayaan_rekening_id' => [
                'required',
                'exists:pembiayaan_rekenings,id',
            ],

            'anggaran' => [
                'required',
                'numeric',
                'min:0',
            ],

            'urutan' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status_publikasi' => [
                'required',
                'in:draft,dipublikasikan',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil rekening master Siskeudes
        |--------------------------------------------------------------------------
        */

        $rekening = PembiayaanRekening::query()
            ->where('is_active', true)
            ->where('level', 4)
            ->findOrFail(
                $data['pembiayaan_rekening_id']
            );


        /*
        |--------------------------------------------------------------------------
        | Cegah rekening yang sama digunakan
        | dua kali dalam Tahun Anggaran yang sama
        |--------------------------------------------------------------------------
        */

        $duplicate = Pembiayaan::query()
            ->where(
                'tahun_anggaran_id',
                $data['tahun_anggaran_id']
            )
            ->where(
                'pembiayaan_rekening_id',
                $data['pembiayaan_rekening_id']
            )
            ->when(
                $pembiayaan,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $pembiayaan->id
                )
            )
            ->exists();


        if ($duplicate) {
            throw ValidationException::withMessages([
                'pembiayaan_rekening_id' =>
                    'Rekening pembiayaan tersebut sudah digunakan pada Tahun Anggaran yang dipilih.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | Kode, uraian dan jenis otomatis
        | dari master Siskeudes
        |--------------------------------------------------------------------------
        */

        $data['kode'] = $rekening->kode;

        $data['uraian'] = $rekening->uraian;

        $data['jenis'] = $rekening->jenis;

        $data['urutan'] = $data['urutan'] ?? 0;


        return $data;
    }
}