<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\PendapatanRekening;
use App\Models\TahunAnggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PendapatanController extends Controller
{
    public function index(): View
    {
        return view('admin.pendapatan.index', [
            'pendapatan' => Pendapatan::query()
                ->with(['tahunAnggaran', 'pendapatanRekening'])
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
        $pendapatan->update($this->validated($request, $pendapatan));

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
            'rekenings' => PendapatanRekening::query()->detail()->with('parent.parent')->orderBy('kode')->get(),
        ];
    }

    private function validated(Request $request, ?Pendapatan $pendapatan = null): array
    {
        $data = $request->validate([
            'tahun_anggaran_id' => ['required', 'integer', 'exists:tahun_anggaran,id'],
            'pendapatan_rekening_id' => ['required', 'integer', 'exists:pendapatan_rekenings,id', Rule::unique('pendapatan', 'pendapatan_rekening_id')->where(fn ($query) => $query->where('tahun_anggaran_id', $request->input('tahun_anggaran_id')))->ignore($pendapatan?->id)],
            'anggaran' => ['required', 'numeric', 'min:0'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'status_publikasi' => ['required', 'in:draft,dipublikasikan'],
        ]);
        $rekening = PendapatanRekening::query()->detail()->find($data['pendapatan_rekening_id']);
        if (! $rekening) {
            throw ValidationException::withMessages(['pendapatan_rekening_id' => 'Pilih rekening pendapatan detail yang valid.']);
        }
        $data['kode'] = $rekening->kode;
        $data['uraian'] = $rekening->uraian;
        $data['kelompok'] = match (explode('.', $rekening->kode)[1] ?? null) { '1' => 'Pendapatan Asli Desa', '2' => 'Pendapatan Transfer', '3' => 'Pendapatan Lain-lain' };
        return $data;
    }
}
