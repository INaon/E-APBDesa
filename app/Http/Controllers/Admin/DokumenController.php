<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenPublikasi;
use App\Models\TahunAnggaran;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DokumenController extends Controller
{
    /**
     * Menampilkan daftar dokumen.
     */
    public function index(): View
    {
        $items = DokumenPublikasi::with('tahunAnggaran')
            ->latest()
            ->paginate(12);

        return view('admin.dokumen.index', [
            'items' => $items,
        ]);
    }

    /**
     * Form tambah dokumen.
     */
    public function create(): View
    {
        $years = TahunAnggaran::query()
            ->orderByDesc('tahun')
            ->get();

        return view('admin.dokumen.form', [
            'years' => $years,
        ]);
    }

    /**
     * Simpan dokumen baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request, true);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request
                ->file('file')
                ->store('dokumen-publikasi', 'public');
        }

        DokumenPublikasi::create($data);

        return to_route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Form edit dokumen.
     */
    public function edit(
        DokumenPublikasi $dokumen
    ): View {
        $years = TahunAnggaran::query()
            ->orderByDesc('tahun')
            ->get();

        return view('admin.dokumen.form', [
            'item' => $dokumen,
            'years' => $years,
        ]);
    }

    /**
     * Update dokumen.
     */
    public function update(
        Request $request,
        DokumenPublikasi $dokumen
    ): RedirectResponse {
        $data = $this->validateData($request, false);

        /*
        |--------------------------------------------------------------------------
        | Jika upload file baru
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('file')) {

            /*
            |--------------------------------------------------------------------------
            | Hapus file lama jika file_path tersedia
            |--------------------------------------------------------------------------
            */

            if (
                !empty($dokumen->file_path)
            ) {
                Storage::disk('public')
                    ->delete($dokumen->file_path);
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan file baru
            |--------------------------------------------------------------------------
            */

            $data['file_path'] = $request
                ->file('file')
                ->store('dokumen-publikasi', 'public');
        }

        $dokumen->update($data);

        return to_route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Hapus dokumen.
     */
    public function destroy(
        DokumenPublikasi $dokumen
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Hapus file PDF jika ada
        |--------------------------------------------------------------------------
        */

        if (
            !empty($dokumen->file_path)
        ) {
            Storage::disk('public')
                ->delete($dokumen->file_path);
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus data dari database
        |--------------------------------------------------------------------------
        */

        $dokumen->delete();

        return to_route('admin.dokumen.index')
            ->with(
                'success',
                'Dokumen berhasil dihapus.'
            );
    }

    /**
     * Ubah status publikasi.
     */
    public function publication(
        DokumenPublikasi $dokumen
    ): RedirectResponse {

        $newStatus =
            $dokumen->status_publikasi === 'dipublikasikan'
                ? 'draft'
                : 'dipublikasikan';

        $dokumen->update([
            'status_publikasi' => $newStatus,
            'tanggal_publikasi' =>
                $newStatus === 'dipublikasikan'
                    ? now()
                    : null,
        ]);

        return back()
            ->with(
                'success',
                'Status publikasi dokumen berhasil diperbarui.'
            );
    }

    /**
     * Validasi data dokumen.
     */
    private function validateData(
        Request $request,
        bool $required
    ): array {
        return $request->validate([

            'tahun_anggaran_id' => [
                'required',
                'exists:tahun_anggaran,id',
            ],

            'kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'judul' => [
                'required',
                'string',
                'max:255',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],

            'file' => [
                $required
                    ? 'required'
                    : 'nullable',

                'file',
                'mimes:pdf',
                'max:10240',
            ],

            'status_publikasi' => [
                'required',
                'in:draft,dipublikasikan',
            ],

            'tanggal_publikasi' => [
                'nullable',
                'date',
            ],

        ]);
    }
}