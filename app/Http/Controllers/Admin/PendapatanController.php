<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\TahunAnggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PendapatanController extends Controller
{
    public function index(): View
    {
        return view('admin.pendapatan.index', [
            'pendapatan' => Pendapatan::query()
                ->with('tahunAnggaran')
                ->orderByDesc('tahun_anggaran_id')
                ->orderBy('urutan')
                ->orderBy('kode')
                ->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.pendapatan.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        Pendapatan::create($this->validated($request));

        return to_route('admin.pendapatan.index')->with('success', 'Data pendapatan berhasil ditambahkan.');
    }

    public function edit(Pendapatan $pendapatan): View
    {
        return view('admin.pendapatan.edit', $this->formData(['pendapatan' => $pendapatan]));
    }

    public function update(Request $request, Pendapatan $pendapatan): RedirectResponse
    {
        $pendapatan->update($this->validated($request));

        return to_route('admin.pendapatan.index')->with('success', 'Data pendapatan berhasil diperbarui.');
    }

    public function destroy(Pendapatan $pendapatan): RedirectResponse
    {
        $pendapatan->delete();

        return to_route('admin.pendapatan.index')->with('success', 'Data pendapatan berhasil dihapus.');
    }

    public function togglePublication(Pendapatan $pendapatan): RedirectResponse
    {
        $published = $pendapatan->status_publikasi === 'dipublikasikan';
        $pendapatan->update(['status_publikasi' => $published ? 'draft' : 'dipublikasikan']);

        return back()->with('success', $published
            ? 'Publikasi pendapatan dibatalkan.'
            : 'Pendapatan berhasil dipublikasikan.');
    }

    private function formData(array $data = []): array
    {
        return $data + [
            'years' => TahunAnggaran::query()->orderByDesc('tahun')->get(),
        ];
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'tahun_anggaran_id' => ['required', 'integer', 'exists:tahun_anggaran,id'],
            'kode' => ['required', 'string', 'max:50'],
            'kelompok' => ['required', 'string', 'max:255'],
            'uraian' => ['required', 'string', 'max:255'],
            'anggaran' => ['required', 'numeric', 'min:0'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'status_publikasi' => ['required', 'in:draft,dipublikasikan'],
        ]);
    }
}
