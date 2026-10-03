<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Models\DokumenPublikasi;
use App\Models\TahunAnggaran;
use App\Services\ApbdesaSummary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function dashboard(ApbdesaSummary $summary): View
    {
        $year = TahunAnggaran::aktif()->first();

        return view('admin.dashboard', [
            'year' => $year,
            'desa' => Desa::first(),
            'summary' => $year
                ? $summary->for($year, false)
                : null,
            'publishedDocuments' => $year
                ? DokumenPublikasi::publik()
                    ->where('tahun_anggaran_id', $year->id)
                    ->count()
                : 0,
        ]);
    }

    public function profile(): View
    {
        return view('admin.profile.edit', [
            'desa' => Desa::firstOrFail(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $desa = Desa::firstOrFail();

        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'kabupaten' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'website' => 'nullable|url',
            'email' => 'nullable|email',

            'logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ], [
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat JPG, JPEG, PNG, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal 2 MB.',
        ]);

        unset($data['logo']);

        /*
        |--------------------------------------------------------------------------
        | Upload Logo
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($desa->logo) {
                Storage::disk('public')->delete($desa->logo);
            }

            // Simpan logo baru
            $data['logo'] = $request->file('logo')
                ->store('profil-desa', 'public');
        }

        $desa->update($data);

        return back()->with(
            'success',
            'Profil desa berhasil diperbarui.'
        );
    }

    public function years(): View
    {
        return view('admin.years.index', [
            'years' => TahunAnggaran::orderByDesc('tahun')->get(),
        ]);
    }

    public function storeYear(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tahun' => 'required|integer|min:2000|max:2100|unique:tahun_anggaran,tahun',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        if ($data['status'] === 'aktif') {
            TahunAnggaran::query()->update([
                'status' => 'nonaktif',
            ]);
        }

        TahunAnggaran::create($data);

        return back()->with(
            'success',
            'Tahun anggaran ditambahkan.'
        );
    }

    public function activate(TahunAnggaran $year): RedirectResponse
    {
        TahunAnggaran::query()->update([
            'status' => 'nonaktif',
        ]);

        $year->update([
            'status' => 'aktif',
        ]);

        return back()->with(
            'success',
            'Tahun anggaran aktif diperbarui.'
        );
    }
}