<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Belanja;
use App\Models\BelanjaRekening;
use App\Models\Bidang;
use App\Models\Kegiatan;
use App\Models\SubBidang;
use App\Models\TahunAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BelanjaImportController extends Controller
{
    public function form()
    {
        return view('admin.belanja.import', [
            'years' => TahunAnggaran::orderByDesc('tahun')->get(),
        ]);
    }

    public function template()
    {
        $years = TahunAnggaran::orderBy('tahun')->get(['tahun']);

        $bidang = Bidang::orderBy('kode')
            ->get(['kode', 'nama', 'tahun_anggaran_id']);

        $subBidang = SubBidang::orderBy('kode')
            ->get(['kode', 'nama', 'bidang_id', 'tahun_anggaran_id']);

        $kegiatan = Kegiatan::orderBy('kode')
            ->get(['kode', 'nama', 'sub_bidang_id', 'tahun_anggaran_id']);

        $rekening = BelanjaRekening::query()
            ->where('is_active', true)
            ->whereRaw("kode REGEXP '^[0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+$'")
            ->orderBy('kode')
            ->get(['kode', 'uraian']);

        $spreadsheet = new Spreadsheet();

        /*
        |--------------------------------------------------------------------------
        | Sheet utama
        |--------------------------------------------------------------------------
        */

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Import Belanja');

        $headers = [
            'Tahun Anggaran',
            'Kode Bidang',
            'Kode Sub Bidang',
            'Kode Kegiatan',
            'Kode Rekening',
            'Anggaran',
            'Status Publikasi',
        ];

        foreach ($headers as $i => $header) {
            $sheet->setCellValue(
                chr(65 + $i) . '1',
                $header
            );
        }

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->freezePane('A2');

        foreach ([
            'A' => 18,
            'B' => 18,
            'C' => 20,
            'D' => 20,
            'E' => 22,
            'F' => 20,
            'G' => 22,
        ] as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        /*
        |--------------------------------------------------------------------------
        | Sheet Referensi
        |--------------------------------------------------------------------------
        */

        $ref = $spreadsheet->createSheet();
        $ref->setTitle('Referensi');

        $ref->fromArray([
            [
                'Tahun Anggaran',
                'Kode Bidang',
                'Nama Bidang',
                'Kode Sub Bidang',
                'Nama Sub Bidang',
                'Kode Kegiatan',
                'Nama Kegiatan',
                'Kode Rekening',
                'Uraian Rekening',
                'Status Publikasi',
            ],
        ], null, 'A1');

        $refRow = 2;

        foreach ($years as $year) {
            $yearBidangs = $bidang->where(
                'tahun_anggaran_id',
                $year->id
            );

            foreach ($yearBidangs as $b) {
                $yearSubBidangs = $subBidang->where(
                    'tahun_anggaran_id',
                    $year->id
                )->where(
                    'bidang_id',
                    $b->id
                );

                foreach ($yearSubBidangs as $sb) {
                    $yearKegiatan = $kegiatan->where(
                        'tahun_anggaran_id',
                        $year->id
                    )->where(
                        'sub_bidang_id',
                        $sb->id
                    );

                    foreach ($yearKegiatan as $k) {
                        $ref->setCellValueExplicit(
                            "A{$refRow}",
                            (string) $year->tahun,
                            DataType::TYPE_STRING
                        );

                        $ref->setCellValueExplicit(
                            "B{$refRow}",
                            (string) $b->kode,
                            DataType::TYPE_STRING
                        );

                        $ref->setCellValue(
                            "C{$refRow}",
                            $b->nama
                        );

                        $ref->setCellValueExplicit(
                            "D{$refRow}",
                            (string) $sb->kode,
                            DataType::TYPE_STRING
                        );

                        $ref->setCellValue(
                            "E{$refRow}",
                            $sb->nama
                        );

                        $ref->setCellValueExplicit(
                            "F{$refRow}",
                            (string) $k->kode,
                            DataType::TYPE_STRING
                        );

                        $ref->setCellValue(
                            "G{$refRow}",
                            $k->nama
                        );

                        $refRow++;
                    }
                }
            }
        }

        $ref->getStyle('A1:J1')->getFont()->setBold(true);

        foreach ([
            'A' => 18,
            'B' => 18,
            'C' => 55,
            'D' => 20,
            'E' => 55,
            'F' => 22,
            'G' => 65,
            'H' => 22,
            'I' => 65,
            'J' => 22,
        ] as $column => $width) {
            $ref->getColumnDimension($column)->setWidth($width);
        }

        /*
        |--------------------------------------------------------------------------
        | Sheet Dropdown
        |--------------------------------------------------------------------------
        | Semua kolom dibuat sebagai dropdown langsung.
        | Hubungan Tahun -> Bidang -> Sub Bidang -> Kegiatan tetap
        | diperiksa oleh server saat import.
        |
        | Cara ini sengaja dipakai agar tombol dropdown Excel selalu
        | muncul dan tidak tergantung fungsi INDIRECT().
        |--------------------------------------------------------------------------
        */

        $dropdown = $spreadsheet->createSheet();
        $dropdown->setTitle('Dropdown');

        $dropdown->setCellValue('A1', 'Tahun Anggaran');
        $dropdown->setCellValue('B1', 'Kode Bidang');
        $dropdown->setCellValue('C1', 'Kode Sub Bidang');
        $dropdown->setCellValue('D1', 'Kode Kegiatan');
        $dropdown->setCellValue('E1', 'Kode Rekening');
        $dropdown->setCellValue('F1', 'Status Publikasi');

        foreach ($years->values() as $i => $item) {
            $dropdown->setCellValueExplicit(
                'A' . ($i + 2),
                (string) $item->tahun,
                DataType::TYPE_STRING
            );
        }

        $bidangCodes = $bidang
            ->pluck('kode')
            ->unique()
            ->sort()
            ->values();

        foreach ($bidangCodes as $i => $kode) {
            $dropdown->setCellValueExplicit(
                'B' . ($i + 2),
                (string) $kode,
                DataType::TYPE_STRING
            );
        }

        $subBidangCodes = $subBidang
            ->pluck('kode')
            ->unique()
            ->sort()
            ->values();

        foreach ($subBidangCodes as $i => $kode) {
            $dropdown->setCellValueExplicit(
                'C' . ($i + 2),
                (string) $kode,
                DataType::TYPE_STRING
            );
        }

        $kegiatanCodes = $kegiatan
            ->pluck('kode')
            ->unique()
            ->sort()
            ->values();

        foreach ($kegiatanCodes as $i => $kode) {
            $dropdown->setCellValueExplicit(
                'D' . ($i + 2),
                (string) $kode,
                DataType::TYPE_STRING
            );
        }

        foreach ($rekening->values() as $i => $item) {
            $dropdown->setCellValueExplicit(
                'E' . ($i + 2),
                (string) $item->kode,
                DataType::TYPE_STRING
            );
        }

        $dropdown->setCellValue('F2', 'draft');
        $dropdown->setCellValue('F3', 'dipublikasikan');

        /*
        |--------------------------------------------------------------------------
        | Named Range
        |--------------------------------------------------------------------------
        */

        if ($years->isNotEmpty()) {
            $spreadsheet->addNamedRange(
                new NamedRange(
                    'TahunAnggaranBelanja',
                    $dropdown,
                    '$A$2:$A$' . ($years->count() + 1)
                )
            );
        }

        if ($bidangCodes->isNotEmpty()) {
            $spreadsheet->addNamedRange(
                new NamedRange(
                    'KodeBidangBelanja',
                    $dropdown,
                    '$B$2:$B$' . ($bidangCodes->count() + 1)
                )
            );
        }

        if ($subBidangCodes->isNotEmpty()) {
            $spreadsheet->addNamedRange(
                new NamedRange(
                    'KodeSubBidangBelanja',
                    $dropdown,
                    '$C$2:$C$' . ($subBidangCodes->count() + 1)
                )
            );
        }

        if ($kegiatanCodes->isNotEmpty()) {
            $spreadsheet->addNamedRange(
                new NamedRange(
                    'KodeKegiatanBelanja',
                    $dropdown,
                    '$D$2:$D$' . ($kegiatanCodes->count() + 1)
                )
            );
        }

        if ($rekening->isNotEmpty()) {
            $spreadsheet->addNamedRange(
                new NamedRange(
                    'KodeRekeningBelanja',
                    $dropdown,
                    '$E$2:$E$' . ($rekening->count() + 1)
                )
            );
        }

        $spreadsheet->addNamedRange(
            new NamedRange(
                'StatusPublikasiBelanja',
                $dropdown,
                '$F$2:$F$3'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Dropdown pada 500 baris
        |--------------------------------------------------------------------------
        */

        for ($row = 2; $row <= 501; $row++) {
            $this->addListValidation(
                $sheet,
                "A{$row}",
                '=TahunAnggaranBelanja'
            );

            $this->addListValidation(
                $sheet,
                "B{$row}",
                '=KodeBidangBelanja'
            );

            $this->addListValidation(
                $sheet,
                "C{$row}",
                '=KodeSubBidangBelanja'
            );

            $this->addListValidation(
                $sheet,
                "D{$row}",
                '=KodeKegiatanBelanja'
            );

            $this->addListValidation(
                $sheet,
                "E{$row}",
                '=KodeRekeningBelanja'
            );

            $this->addListValidation(
                $sheet,
                "G{$row}",
                '=StatusPublikasiBelanja'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Sembunyikan sheet Dropdown
        |--------------------------------------------------------------------------
        */

        $dropdown->setSheetState(
            \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN
        );

        /*
        |--------------------------------------------------------------------------
        | Sheet Petunjuk
        |--------------------------------------------------------------------------
        */

        $guide = $spreadsheet->createSheet();
        $guide->setTitle('Petunjuk');

        $guide->fromArray([
            ['PETUNJUK IMPORT BELANJA e-APBDesa'],
            [''],
            ['Kolom', 'Keterangan'],
            [
                'Tahun Anggaran',
                'Pilih tahun yang tersedia di aplikasi.',
            ],
            [
                'Kode Bidang',
                'Pilih kode Bidang dari dropdown.',
            ],
            [
                'Kode Sub Bidang',
                'Pilih kode Sub Bidang dari dropdown. Server akan memeriksa kesesuaiannya dengan Bidang.',
            ],
            [
                'Kode Kegiatan',
                'Pilih kode Kegiatan dari dropdown. Server akan memeriksa kesesuaiannya dengan Sub Bidang.',
            ],
            [
                'Kode Rekening',
                'Hanya rekening detail, misalnya 5.1.1.01.',
            ],
            [
                'Anggaran',
                'Isi angka anggaran tanpa simbol Rp.',
            ],
            [
                'Status Publikasi',
                'Pilih draft atau dipublikasikan.',
            ],
            [''],
            [
                'PENTING',
                'Kode Bidang, Sub Bidang, dan Kegiatan memiliki dropdown masing-masing.',
            ],
            [
                '',
                'Saat import, sistem tetap memvalidasi hubungan Tahun → Bidang → Sub Bidang → Kegiatan.',
            ],
        ], null, 'A1');

        $guide->getStyle('A1')
            ->getFont()
            ->setBold(true);

        $guide->getStyle('A3:B3')
            ->getFont()
            ->setBold(true);

        $guide->getColumnDimension('A')->setWidth(24);
        $guide->getColumnDimension('B')->setWidth(90);

        $guide->getStyle('A1:B20')
            ->getAlignment()
            ->setWrapText(true);

        /*
        |--------------------------------------------------------------------------
        | Simpan File
        |--------------------------------------------------------------------------
        */

        $writer = new Xlsx($spreadsheet);

        $filename = 'template-import-belanja-e-APBDesa.xlsx';

        $directory = storage_path('app');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        $writer->save($path);

        return response()
            ->download($path, $filename)
            ->deleteFileAfterSend(true);
    }

    private function addListValidation($sheet, string $cell, string $formula): void
    {
        $validation = $sheet->getCell($cell)->getDataValidation();
        $validation->setType(DataValidation::TYPE_LIST);
        $validation->setErrorStyle(DataValidation::STYLE_STOP);
        $validation->setAllowBlank(true);
        $validation->setShowInputMessage(true);
        $validation->setShowErrorMessage(true);
        $validation->setShowDropDown(true);
        $validation->setFormula1($formula);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls', 'max:10240'],
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $sheet = $spreadsheet->getSheetByName('Import Belanja') ?? $spreadsheet->getActiveSheet();

        $rows = $sheet->toArray(null, true, true, true);
        $dataRows = [];

        foreach ($rows as $rowNumber => $row) {
            if ($rowNumber === 1) {
                continue;
            }

            $values = [
                'tahun' => trim((string) ($row['A'] ?? '')),
                'bidang' => trim((string) ($row['B'] ?? '')),
                'sub_bidang' => trim((string) ($row['C'] ?? '')),
                'kegiatan' => trim((string) ($row['D'] ?? '')),
                'rekening' => trim((string) ($row['E'] ?? '')),
                'anggaran' => $row['F'] ?? null,
                'status' => trim((string) ($row['G'] ?? '')),
            ];

            $empty = $values['tahun'] === ''
                && $values['bidang'] === ''
                && $values['sub_bidang'] === ''
                && $values['kegiatan'] === ''
                && $values['rekening'] === ''
                && ($values['anggaran'] === null || $values['anggaran'] === '')
                && $values['status'] === '';

            if ($empty) {
                continue;
            }

            $values['_row'] = $rowNumber;
            $dataRows[] = $values;
        }

        if (!$dataRows) {
            return back()->withErrors(['file' => 'Tidak ada data yang dapat diimport.']);
        }

        $years = TahunAnggaran::get()->keyBy(fn ($item) => (string) $item->tahun);
        $bidangs = Bidang::get()->groupBy(fn ($item) => $item->tahun_anggaran_id . '|' . $item->kode);
        $subBidangs = SubBidang::get()->groupBy(fn ($item) => $item->tahun_anggaran_id . '|' . $item->bidang_id . '|' . $item->kode);
        $kegiatans = Kegiatan::get()->groupBy(fn ($item) => $item->tahun_anggaran_id . '|' . $item->sub_bidang_id . '|' . $item->kode);
        $rekenings = BelanjaRekening::where('is_active', true)->get()->keyBy('kode');

        $seen = [];
        $errors = [];
        $validRows = [];

        foreach ($dataRows as $row) {
            $n = $row['_row'];

            $year = $years->get($row['tahun']);
            if (!$year) {
                $errors[] = "Baris {$n}: Tahun Anggaran '{$row['tahun']}' tidak ditemukan.";
                continue;
            }

            $bidang = $bidangs->get($year->id . '|' . $row['bidang'])?->first();
            if (!$bidang) {
                $errors[] = "Baris {$n}: Bidang '{$row['bidang']}' tidak ditemukan untuk tahun {$row['tahun']}.";
                continue;
            }

            $subBidang = $subBidangs->get($year->id . '|' . $bidang->id . '|' . $row['sub_bidang'])?->first();
            if (!$subBidang) {
                $errors[] = "Baris {$n}: Sub Bidang '{$row['sub_bidang']}' tidak sesuai dengan Bidang '{$row['bidang']}'.";
                continue;
            }

            $kegiatan = $kegiatans->get($year->id . '|' . $subBidang->id . '|' . $row['kegiatan'])?->first();
            if (!$kegiatan) {
                $errors[] = "Baris {$n}: Kegiatan '{$row['kegiatan']}' tidak sesuai dengan Sub Bidang '{$row['sub_bidang']}'.";
                continue;
            }

            if (!preg_match('/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/', $row['rekening'])) {
                $errors[] = "Baris {$n}: Kode Rekening '{$row['rekening']}' bukan rekening detail.";
                continue;
            }

            $rekening = $rekenings->get($row['rekening']);
            if (!$rekening) {
                $errors[] = "Baris {$n}: Rekening '{$row['rekening']}' tidak ditemukan.";
                continue;
            }

            if (!is_numeric($row['anggaran']) || (float) $row['anggaran'] < 0) {
                $errors[] = "Baris {$n}: Anggaran harus berupa angka >= 0.";
                continue;
            }

            if (!in_array($row['status'], ['draft', 'dipublikasikan'], true)) {
                $errors[] = "Baris {$n}: Status Publikasi harus draft atau dipublikasikan.";
                continue;
            }

            $key = $year->id . '|' . $kegiatan->id . '|' . $rekening->id;
            if (isset($seen[$key])) {
                $errors[] = "Baris {$n}: Data duplikat dengan baris {$seen[$key]}.";
                continue;
            }

            $exists = Belanja::where('tahun_anggaran_id', $year->id)
                ->where('kegiatan_id', $kegiatan->id)
                ->where('belanja_rekening_id', $rekening->id)
                ->exists();

            if ($exists) {
                $errors[] = "Baris {$n}: Rekening '{$rekening->kode}' sudah digunakan pada kegiatan tersebut.";
                continue;
            }

            $seen[$key] = $n;

            $validRows[] = [
                'tahun_anggaran_id' => $year->id,
                'bidang_id' => $bidang->id,
                'kegiatan_id' => $kegiatan->id,
                'belanja_rekening_id' => $rekening->id,
                'kode' => $rekening->kode,
                'uraian' => $rekening->uraian,
                'anggaran' => (float) $row['anggaran'],
                'urutan' => 0,
                'status_publikasi' => $row['status'],
            ];
        }

        if ($errors) {
            throw ValidationException::withMessages([
                'file' => $errors,
            ]);
        }

        DB::transaction(function () use ($validRows) {
            foreach ($validRows as $data) {
                Belanja::create($data);
            }
        });

        return to_route('admin.belanja.index')
            ->with('success', count($validRows) . ' data belanja berhasil diimport.');
    }
}
