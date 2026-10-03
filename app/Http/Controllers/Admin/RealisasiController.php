<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Belanja;
use App\Models\Pembiayaan;
use App\Models\Pendapatan;
use App\Models\RealisasiBelanja;
use App\Models\RealisasiPembiayaan;
use App\Models\RealisasiPendapatan;
use App\Models\TahunAnggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RealisasiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        return view('admin.realisasi.index', [

            'income' => RealisasiPendapatan::with([
                'pendapatan.tahunAnggaran',
                'pendapatan.pendapatanRekening',
            ])
                ->latest('tanggal')
                ->get(),

            'expense' => RealisasiBelanja::with([
                'belanja.tahunAnggaran',
                'belanja.bidang',
                'belanja.kegiatan.subBidang',
                'belanja.belanjaRekening',
            ])
                ->latest('tanggal')
                ->get(),

            'financing' => RealisasiPembiayaan::with([
                'pembiayaan.tahunAnggaran',
                'pembiayaan.pembiayaanRekening',
            ])
                ->latest('tanggal')
                ->get(),

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view(
            'admin.realisasi.form',
            $this->formData()
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request
    ): RedirectResponse {

        $data = $this->validated($request);

        $this->validateItemYear($data);

        $model = $this->model(
            $data['jenis']
        );

        $model::create(
            $this->payload($data)
        );

        return to_route(
            'admin.realisasi.index'
        )->with(
            'success',
            'Data realisasi berhasil ditambahkan.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        string $jenis,
        int $id
    ): View {

        $model = $this->model($jenis);

        $realisasi = $model::findOrFail($id);

        return view(
            'admin.realisasi.edit',
            array_merge(
                $this->formData(),
                [
                    'realisasi' => $realisasi,
                    'jenis' => $jenis,
                ]
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        string $jenis,
        int $id,
        Request $request
    ): RedirectResponse {

        /*
         * Pastikan jenis dari URL adalah jenis
         * yang dikirim dari form.
         */
        $request->merge([
            'jenis' => $jenis,
        ]);

        $data = $this->validated($request);

        $this->validateItemYear($data);

        $model = $this->model($jenis);

        $realisasi = $model::findOrFail($id);

        $realisasi->update(
            $this->payload($data)
        );

        return to_route(
            'admin.realisasi.index'
        )->with(
            'success',
            'Data realisasi berhasil diperbarui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        string $jenis,
        int $id
    ): RedirectResponse {

        $model = $this->model($jenis);

        $model::findOrFail($id)->delete();

        return back()->with(
            'success',
            'Data realisasi berhasil dihapus.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLICATION / DRAFT
    |--------------------------------------------------------------------------
    */

    public function publication(
        string $jenis,
        int $id
    ): RedirectResponse {

        $model = $this->model($jenis);

        $realisasi = $model::findOrFail($id);

        $realisasi->update([
            'status_publikasi' =>
                $realisasi->status_publikasi === 'dipublikasikan'
                    ? 'draft'
                    : 'dipublikasikan',
        ]);

        return back()->with(
            'success',
            'Status publikasi diperbarui.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORM DATA
    |--------------------------------------------------------------------------
    */

    private function formData(): array
    {
        return [

            /*
             * Tahun Anggaran
             */
            'years' => TahunAnggaran::query()
                ->orderByDesc('tahun')
                ->get(),


            /*
             * Pendapatan
             */
            'pendapatan' => Pendapatan::query()
                ->with([
                    'tahunAnggaran',
                    'pendapatanRekening',
                ])
                ->orderBy('tahun_anggaran_id')
                ->orderBy('kode')
                ->get(),


            /*
             * Belanja
             */
            'belanja' => Belanja::query()
                ->with([
                    'tahunAnggaran',
                    'bidang',
                    'kegiatan.subBidang',
                    'belanjaRekening',
                ])
                ->orderBy('tahun_anggaran_id')
                ->orderBy('kode')
                ->get(),


            /*
             * Pembiayaan
             */
            'pembiayaan' => Pembiayaan::query()
                ->with([
                    'tahunAnggaran',
                    'pembiayaanRekening',
                ])
                ->orderBy('tahun_anggaran_id')
                ->orderBy('kode')
                ->get(),

        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    private function validated(
        Request $request
    ): array {

        return $request->validate([

            'jenis' => [
                'required',
                'in:pendapatan,belanja,pembiayaan',
            ],

            'tahun_anggaran_id' => [
                'required',
                'exists:tahun_anggaran,id',
            ],

            'item_id' => [
                'required',
                'integer',
            ],

            'bulan' => [
                'required',
                'integer',
                'between:1,12',
            ],

            'tanggal' => [
                'required',
                'date',
            ],

            'nilai' => [
                'required',
                'numeric',
                'min:0',
            ],

            'keterangan' => [
                'nullable',
                'string',
            ],

            'status_publikasi' => [
                'required',
                'in:draft,dipublikasikan',
            ],

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI TAHUN REKENING
    |--------------------------------------------------------------------------
    */

    private function validateItemYear(
        array $data
    ): void {

        $type = $data['jenis'];

        $model = match ($type) {

            'pendapatan' => Pendapatan::class,

            'belanja' => Belanja::class,

            'pembiayaan' => Pembiayaan::class,

            default => abort(404),
        };

        $item = $model::findOrFail(
            $data['item_id']
        );

        if (
            (int) $item->tahun_anggaran_id !==
            (int) $data['tahun_anggaran_id']
        ) {

            abort(
                422,
                'Rekening yang dipilih tidak sesuai dengan Tahun Anggaran.'
            );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | PAYLOAD
    |--------------------------------------------------------------------------
    */

    private function payload(
        array $data
    ): array {

        $type = $data['jenis'];

        unset($data['jenis']);

        $data[$type . '_id'] =
            $data['item_id'];

        unset($data['item_id']);

        return $data;
    }


    /*
    |--------------------------------------------------------------------------
    | MODEL REALISASI
    |--------------------------------------------------------------------------
    */

    private function model(
        string $type
    ): string {

        return match ($type) {

            'pendapatan' =>
                RealisasiPendapatan::class,

            'belanja' =>
                RealisasiBelanja::class,

            'pembiayaan' =>
                RealisasiPembiayaan::class,

            default =>
                abort(404),

        };
    }
}