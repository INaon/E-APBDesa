<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendapatan;
use App\Models\PendapatanRekening;
use App\Models\TahunAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\NamedRange;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PendapatanImportController extends Controller
{
    /**
     * Halaman import Excel.
     */
    public function form()
    {
        return view('admin.pendapatan.import');
    }

    /**
     * Download template Excel.
     */
    public function template()
    {
        $spreadsheet = new Spreadsheet();

        /*
        |--------------------------------------------------------------------------
        | SHEET 1 - IMPORT PENDAPATAN
        |--------------------------------------------------------------------------
        */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Import Pendapatan');

        $headers = [
            'Tahun Anggaran',
            'Kode Rekening',
            'Anggaran',
            'Status Publikasi',
        ];

        foreach ($headers as $index => $header) {
            $column = $this->columnLetter($index + 1);

            $sheet->setCellValue(
                $column . '1',
                $header
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Contoh Baris
        |--------------------------------------------------------------------------
        */
        $sheet->setCellValue('A2', '');
        $sheet->setCellValue('B2', '');
        $sheet->setCellValue('C2', '');
        $sheet->setCellValue('D2', 'draft');

        /*
        |--------------------------------------------------------------------------
        | SHEET 2 - PETUNJUK
        |--------------------------------------------------------------------------
        */
        $guide = $spreadsheet->createSheet();
        $guide->setTitle('Petunjuk');

        $instructions = [
            ['PETUNJUK IMPORT PENDAPATAN e-APBDesa'],
            [''],
            ['1. Tahun Anggaran'],
            ['Isi dengan tahun anggaran yang sudah tersedia di aplikasi.'],
            [''],
            ['2. Kode Rekening'],
            ['Pilih kode rekening dari dropdown yang tersedia.'],
            ['Kode rekening berasal dari master rekening Pendapatan SiskeuDes.'],
            ['Gunakan rekening detail, contoh: 4.2.1.01.'],
            ['Kode kelompok seperti 4.2.1 tidak digunakan untuk input anggaran.'],
            ['Uraian rekening tidak perlu diisi.'],
            ['Uraian akan diambil otomatis oleh sistem.'],
            [''],
            ['3. Anggaran'],
            ['Isi dengan nilai anggaran dalam angka.'],
            ['Contoh: 150000000'],
            [''],
            ['4. Status Publikasi'],
            ['Pilih draft atau dipublikasikan dari dropdown.'],
            [''],
            ['5. Validasi'],
            ['Jika terdapat satu baris yang tidak valid, seluruh data tidak akan disimpan.'],
        ];

        foreach ($instructions as $rowIndex => $data) {
            $guide->setCellValue(
                'A' . ($rowIndex + 1),
                $data[0] ?? ''
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SHEET 3 - REFERENSI REKENING
        |--------------------------------------------------------------------------
        */
        $reference = $spreadsheet->createSheet();
        $reference->setTitle('Referensi Rekening');

        $reference->setCellValue(
            'A1',
            'Kode Rekening'
        );

        $reference->setCellValue(
            'B1',
            'Uraian Pendapatan'
        );

        /*
        |--------------------------------------------------------------------------
        | AMBIL REKENING DETAIL SISKEUDES
        |--------------------------------------------------------------------------
        |
        | Hanya mengambil kode detail seperti:
        |
        | 4.1.1.01
        | 4.1.1.99
        | 4.1.2.01
        | 4.2.1.01
        | 4.2.2.01
        | 4.3.1.01
        |
        | Tidak mengambil kode kelompok:
        |
        | 4.1.1
        | 4.1.2
        | 4.2.1
        |
        */
        $rekenings = PendapatanRekening::query()
            ->where('is_active', true)
            ->whereRaw(
                "kode REGEXP '^[0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+$'"
            )
            ->orderBy('kode')
            ->get([
                'id',
                'kode',
                'uraian',
            ]);

        /*
        |--------------------------------------------------------------------------
        | ISI REFERENSI REKENING
        |--------------------------------------------------------------------------
        */
        $referenceRow = 2;

        foreach ($rekenings as $rekening) {

            $reference->setCellValue(
                'A' . $referenceRow,
                $rekening->kode
            );

            $reference->setCellValue(
                'B' . $referenceRow,
                $rekening->uraian
            );

            $referenceRow++;
        }

        /*
        |--------------------------------------------------------------------------
        | RANGE REKENING
        |--------------------------------------------------------------------------
        */
        $lastReferenceRow = $referenceRow - 1;

        /*
        |--------------------------------------------------------------------------
        | NAMED RANGE
        |--------------------------------------------------------------------------
        */
        if ($rekenings->count() > 0) {

            $accountRange =
                '$A$2:$A$' . $lastReferenceRow;

            $spreadsheet->addNamedRange(
                new NamedRange(
                    'KodeRekeningPendapatan',
                    $reference,
                    $accountRange
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN STATUS PUBLIKASI
        |--------------------------------------------------------------------------
        */
        $statusValidation = new DataValidation();

        $statusValidation->setType(
            DataValidation::TYPE_LIST
        );

        $statusValidation->setErrorStyle(
            DataValidation::STYLE_STOP
        );

        $statusValidation->setAllowBlank(false);

        $statusValidation->setShowInputMessage(true);

        $statusValidation->setShowErrorMessage(true);

        /*
        |--------------------------------------------------------------------------
        | SESUAI HASIL TES EXCEL USER
        |--------------------------------------------------------------------------
        |
        | TRUE digunakan karena pada Excel yang digunakan,
        | nilai TRUE menampilkan dropdown.
        |
        */
        $statusValidation->setShowDropDown(true);

        $statusValidation->setErrorTitle(
            'Status tidak valid'
        );

        $statusValidation->setError(
            'Silakan pilih status dari dropdown.'
        );

        $statusValidation->setPromptTitle(
            'Status Publikasi'
        );

        $statusValidation->setPrompt(
            'Pilih draft atau dipublikasikan.'
        );

        $statusValidation->setFormula1(
            '"draft,dipublikasikan"'
        );

        /*
        |--------------------------------------------------------------------------
        | PASANG DROPDOWN STATUS KE D2:D501
        |--------------------------------------------------------------------------
        */
        for ($row = 2; $row <= 501; $row++) {

            $validation = clone $statusValidation;

            $sheet
                ->getCell('D' . $row)
                ->setDataValidation($validation);
        }

        /*
        |--------------------------------------------------------------------------
        | DROPDOWN KODE REKENING
        |--------------------------------------------------------------------------
        */
        if ($rekenings->count() > 0) {

            $accountValidation = new DataValidation();

            $accountValidation->setType(
                DataValidation::TYPE_LIST
            );

            $accountValidation->setErrorStyle(
                DataValidation::STYLE_STOP
            );

            $accountValidation->setAllowBlank(false);

            $accountValidation->setShowInputMessage(true);

            $accountValidation->setShowErrorMessage(true);

            /*
            |--------------------------------------------------------------------------
            | SESUAI HASIL TES EXCEL USER
            |--------------------------------------------------------------------------
            */
            $accountValidation->setShowDropDown(true);

            $accountValidation->setErrorTitle(
                'Kode rekening tidak valid'
            );

            $accountValidation->setError(
                'Silakan pilih kode rekening dari dropdown.'
            );

            $accountValidation->setPromptTitle(
                'Kode Rekening'
            );

            $accountValidation->setPrompt(
                'Pilih rekening detail Pendapatan.'
            );

            /*
            |--------------------------------------------------------------------------
            | GUNAKAN NAMED RANGE
            |--------------------------------------------------------------------------
            */
            $accountValidation->setFormula1(
                '=KodeRekeningPendapatan'
            );

            /*
            |--------------------------------------------------------------------------
            | PASANG DROPDOWN KE B2:B501
            |--------------------------------------------------------------------------
            */
            for ($row = 2; $row <= 501; $row++) {

                $validation = clone $accountValidation;

                $sheet
                    ->getCell('B' . $row)
                    ->setDataValidation($validation);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | FORMAT KOLOM
        |--------------------------------------------------------------------------
        */
        foreach (['A', 'B', 'C', 'D'] as $column) {

            $sheet
                ->getColumnDimension($column)
                ->setAutoSize(true);
        }

        $reference
            ->getColumnDimension('A')
            ->setAutoSize(true);

        $reference
            ->getColumnDimension('B')
            ->setAutoSize(true);

        $guide
            ->getColumnDimension('A')
            ->setWidth(100);

        /*
        |--------------------------------------------------------------------------
        | FORMAT ANGGARAN
        |--------------------------------------------------------------------------
        */
        $sheet
            ->getStyle('C2:C501')
            ->getNumberFormat()
            ->setFormatCode('#,##0');

        /*
        |--------------------------------------------------------------------------
        | FREEZE PANE
        |--------------------------------------------------------------------------
        */
        $sheet->freezePane('A2');

        $reference->freezePane('A2');

        /*
        |--------------------------------------------------------------------------
        | HEADER STYLE
        |--------------------------------------------------------------------------
        */
        $sheet
            ->getStyle('A1:D1')
            ->getFont()
            ->setBold(true);

        $reference
            ->getStyle('A1:B1')
            ->getFont()
            ->setBold(true);

        $guide
            ->getStyle('A1')
            ->getFont()
            ->setBold(true);

        /*
        |--------------------------------------------------------------------------
        | AUTO FILTER
        |--------------------------------------------------------------------------
        */
        $sheet->setAutoFilter('A1:D1');

        if ($rekenings->count() > 0) {

            $reference->setAutoFilter(
                'A1:B' . $lastReferenceRow
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD
        |--------------------------------------------------------------------------
        */
        $writer = new Xlsx($spreadsheet);

        $filename =
            'Template_Import_Pendapatan_e-APBDesa.xlsx';

        return response()->streamDownload(
            function () use ($writer) {

                $writer->save(
                    'php://output'
                );
            },
            $filename,
            [
                'Content-Type' =>
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );
    }

    /**
     * Proses import Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls',
                'max:5120',
            ],
        ], [
            'file.required' =>
                'Silakan pilih file Excel.',

            'file.mimes' =>
                'File harus berformat XLS atau XLSX.',

            'file.max' =>
                'Ukuran file maksimal 5 MB.',
        ]);

        try {

            $spreadsheet = IOFactory::load(
                $request->file('file')->getRealPath()
            );

            $sheet = $spreadsheet->getSheetByName(
                'Import Pendapatan'
            );

            if (!$sheet) {

                return back()
                    ->withErrors([
                        'file' =>
                            'Sheet "Import Pendapatan" tidak ditemukan.',
                    ])
                    ->withInput();
            }

            $rows = $sheet->toArray(
                null,
                true,
                true,
                true
            );

            $errors = [];

            $preparedRows = [];

            $fileKeys = [];

            foreach ($rows as $rowNumber => $row) {

                /*
                |--------------------------------------------------------------------------
                | LEWATI HEADER
                |--------------------------------------------------------------------------
                */
                if ($rowNumber === 1) {
                    continue;
                }

                $tahun = trim(
                    (string) ($row['A'] ?? '')
                );

                $kode = trim(
                    (string) ($row['B'] ?? '')
                );

                $anggaran = trim(
                    (string) ($row['C'] ?? '')
                );

                $status = trim(
                    (string) ($row['D'] ?? '')
                );

                /*
                |--------------------------------------------------------------------------
                | LEWATI BARIS KOSONG
                |--------------------------------------------------------------------------
                */
                if (
                    $tahun === '' &&
                    $kode === '' &&
                    $anggaran === '' &&
                    $status === ''
                ) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI TAHUN ANGGARAN
                |--------------------------------------------------------------------------
                */
                $year = TahunAnggaran::where(
                    'tahun',
                    $tahun
                )->first();

                if (!$year) {

                    $errors[] =
                        "Baris {$rowNumber}: Tahun Anggaran {$tahun} tidak ditemukan.";
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI FORMAT KODE REKENING
                |--------------------------------------------------------------------------
                */
                $isDetailCode = preg_match(
                    '/^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$/',
                    $kode
                );

                if (!$isDetailCode) {

                    $errors[] =
                        "Baris {$rowNumber}: Kode rekening {$kode} bukan rekening detail. Gunakan format seperti 4.2.1.01.";
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI REKENING
                |--------------------------------------------------------------------------
                */
                $rekening = null;

                if ($isDetailCode) {

                    $rekening = PendapatanRekening::where(
                        'kode',
                        $kode
                    )
                        ->where('is_active', true)
                        ->first();
                }

                if (!$rekening) {

                    $errors[] =
                        "Baris {$rowNumber}: Kode rekening {$kode} tidak ditemukan pada master rekening Pendapatan.";
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI ANGGARAN
                |--------------------------------------------------------------------------
                */
                $numericAnggaran = preg_replace(
                    '/[^0-9]/',
                    '',
                    $anggaran
                );

                if (
                    $numericAnggaran === '' ||
                    !is_numeric($numericAnggaran)
                ) {

                    $errors[] =
                        "Baris {$rowNumber}: Anggaran tidak valid.";
                }

                /*
                |--------------------------------------------------------------------------
                | VALIDASI STATUS
                |--------------------------------------------------------------------------
                */
                if (
                    !in_array(
                        $status,
                        [
                            'draft',
                            'dipublikasikan',
                        ],
                        true
                    )
                ) {

                    $errors[] =
                        "Baris {$rowNumber}: Status publikasi harus draft atau dipublikasikan.";
                }

                /*
                |--------------------------------------------------------------------------
                | CEK DUPLIKAT DALAM FILE
                |--------------------------------------------------------------------------
                */
                if ($year && $rekening) {

                    $key =
                        $year->id .
                        '-' .
                        $rekening->id;

                    if (isset($fileKeys[$key])) {

                        $errors[] =
                            "Baris {$rowNumber}: Rekening {$kode} untuk Tahun Anggaran {$tahun} duplikat dalam file.";
                    }

                    $fileKeys[$key] = true;
                }

                /*
                |--------------------------------------------------------------------------
                | CEK DUPLIKAT DATABASE
                |--------------------------------------------------------------------------
                */
                if ($year && $rekening) {

                    $exists = Pendapatan::where(
                        'tahun_anggaran_id',
                        $year->id
                    )
                        ->where(
                            'pendapatan_rekening_id',
                            $rekening->id
                        )
                        ->exists();

                    if ($exists) {

                        $errors[] =
                            "Baris {$rowNumber}: Rekening {$kode} untuk Tahun Anggaran {$tahun} sudah ada di database.";
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | SIAPKAN DATA
                |--------------------------------------------------------------------------
                */
                if (
                    $year &&
                    $rekening &&
                    $numericAnggaran !== '' &&
                    is_numeric($numericAnggaran) &&
                    in_array(
                        $status,
                        [
                            'draft',
                            'dipublikasikan',
                        ],
                        true
                    )
                ) {

                    $kodeParts = explode(
                        '.',
                        $rekening->kode
                    );

                    $kelompok = match (
                        $kodeParts[1] ?? null
                    ) {

                        '1' =>
                            'Pendapatan Asli Desa',

                        '2' =>
                            'Pendapatan Transfer',

                        '3' =>
                            'Pendapatan Lain-lain',

                        default =>
                            null,
                    };

                    $preparedRows[] = [

                        'tahun_anggaran_id' =>
                            $year->id,

                        'pendapatan_rekening_id' =>
                            $rekening->id,

                        'kode' =>
                            $rekening->kode,

                        'kelompok' =>
                            $kelompok,

                        'uraian' =>
                            $rekening->uraian,

                        'anggaran' =>
                            $numericAnggaran,

                        'status_publikasi' =>
                            $status,
                    ];
                }
            }

            /*
            |--------------------------------------------------------------------------
            | JIKA ADA ERROR
            |--------------------------------------------------------------------------
            */
            if (count($errors) > 0) {

                return back()
                    ->withErrors($errors)
                    ->withInput();
            }

            /*
            |--------------------------------------------------------------------------
            | TIDAK ADA DATA
            |--------------------------------------------------------------------------
            */
            if (count($preparedRows) === 0) {

                return back()
                    ->withErrors([
                        'file' =>
                            'Tidak ada data yang dapat diimport.',
                    ]);
            }

            /*
            |--------------------------------------------------------------------------
            | SIMPAN DALAM SATU TRANSAKSI
            |--------------------------------------------------------------------------
            */
            DB::transaction(
                function () use ($preparedRows) {

                    foreach ($preparedRows as $data) {

                        Pendapatan::create(
                            $data
                        );
                    }
                }
            );

            /*
            |--------------------------------------------------------------------------
            | BERHASIL
            |--------------------------------------------------------------------------
            */
            return redirect()
                ->route(
                    'admin.pendapatan.index'
                )
                ->with(
                    'success',
                    count($preparedRows) .
                    ' data Pendapatan berhasil diimport.'
                );

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withErrors([
                    'file' =>
                        'File Excel tidak dapat diproses. Pastikan formatnya sesuai template e-APBDesa.',
                ]);
        }
    }

    /**
     * Konversi nomor kolom menjadi huruf Excel.
     */
    private function columnLetter(
        int $column
    ): string {

        $letter = '';

        while ($column > 0) {

            $modulo =
                ($column - 1) % 26;

            $letter =
                chr(65 + $modulo) .
                $letter;

            $column =
                (int) (
                    ($column - $modulo) /
                    26
                );
        }

        return $letter;
    }
}