@extends('layouts.admin')

@section('title', 'Import Belanja')

@section('content')

<style>
    /* =========================================================
       IMPORT BELANJA
       ========================================================= */

    .excel-upload-zone {
        position: relative;
        border: 2px dashed #cbd5e1;
        border-radius: 18px;
        background: #f8fafc;
        transition:
            border-color .2s ease,
            background-color .2s ease,
            box-shadow .2s ease;
    }

    .excel-upload-zone:hover {
        border-color: #93c5fd;
        background: #f8fbff;
    }

    .excel-upload-zone.is-dragging {
        border-color: #3b82f6;
        background: #eff6ff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .08);
    }

    .excel-upload-zone.has-file {
        border-style: solid;
        border-color: #93c5fd;
        background: #f8fbff;
    }

    .excel-upload-input {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .excel-upload-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 58px;
        height: 58px;
        border-radius: 16px;
        background: #eff6ff;
        color: #2563eb;
        transition: transform .2s ease, background-color .2s ease;
    }

    .excel-upload-zone:hover .excel-upload-icon {
        transform: translateY(-2px);
        background: #dbeafe;
    }

    .excel-file-card {
        display: none;
        align-items: center;
        gap: 14px;
        width: 100%;
        border: 1px solid #bfdbfe;
        border-radius: 14px;
        background: #ffffff;
        padding: 14px 16px;
    }

    .excel-file-card.show {
        display: flex;
    }

    .excel-file-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        flex-shrink: 0;
        border-radius: 11px;
        background: #eff6ff;
        color: #2563eb;
    }

    .excel-file-info {
        min-width: 0;
        flex: 1;
    }

    .excel-file-name {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }

    .excel-file-size {
        margin-top: 2px;
        font-size: 12px;
        color: #64748b;
    }

    .excel-remove-file {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        border-radius: 10px;
        color: #64748b;
        transition: background-color .15s ease, color .15s ease;
    }

    .excel-remove-file:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .excel-upload-hint {
        font-size: 12px;
        color: #64748b;
    }
</style>


<div class="space-y-6">

    {{-- =====================================================
         HEADER
         ====================================================== --}}

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <div class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">
                Administrasi
            </div>

            <h1 class="mt-1 text-2xl font-semibold text-slate-900">
                Import Belanja
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Import data Belanja melalui template Excel master SiskeuDes.
            </p>

        </div>


        <a href="{{ route('admin.belanja.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            Kembali

        </a>

    </div>


    {{-- =====================================================
         ERROR
         ====================================================== --}}

    @if ($errors->any())

        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <div class="font-semibold">
                Import gagal. Tidak ada data yang disimpan.
            </div>

            <ul class="mt-2 max-h-72 list-disc space-y-1 overflow-auto pl-5">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         SUCCESS
         ====================================================== --}}

    @if(session('success'))

        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         UPLOAD + TEMPLATE
         ====================================================== --}}

    <div class="grid gap-6 lg:grid-cols-3">


        {{-- =================================================
             UPLOAD FILE
             ================================================== --}}

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">

            <h2 class="text-lg font-semibold text-slate-900">
                Upload File Excel
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Gunakan template resmi agar dropdown master tersedia.
            </p>


            <form id="importBelanjaForm"
                  action="{{ route('admin.belanja.import') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="mt-6">

                @csrf


                <label class="mb-2.5 block text-sm font-semibold text-slate-700">
                    File Excel
                </label>


                {{-- =================================================
                     UPLOAD ZONE
                     ================================================== --}}

                <div id="excelUploadZone"
                     class="excel-upload-zone">


                    {{-- FILE INPUT --}}
                    <input id="excelFile"
                           type="file"
                           name="file"
                           accept=".xlsx,.xls"
                           required
                           class="excel-upload-input">


                    {{-- EMPTY STATE --}}
                    <label id="excelEmptyState"
                           for="excelFile"
                           class="flex cursor-pointer flex-col items-center justify-center px-6 py-10 text-center">

                        <span class="excel-upload-icon">

                            <svg class="h-7 w-7"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 16V4"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 8l4-4 4 4"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M5 15v3a2 2 0 002 2h10a2 2 0 002-2v-3"/>

                            </svg>

                        </span>


                        <span class="mt-4 text-sm font-semibold text-slate-800">

                            Klik untuk memilih file Excel

                        </span>


                        <span class="mt-1 text-sm text-slate-500">

                            atau tarik dan lepaskan file di sini

                        </span>


                        <span class="mt-3 excel-upload-hint">

                            Format .xlsx atau .xls • Maksimal 10 MB

                        </span>

                    </label>


                    {{-- FILE SELECTED STATE --}}
                    <div id="excelFileCard"
                         class="excel-file-card">


                        <div class="excel-file-icon">

                            <svg class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M7 3h7l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M14 3v5h5"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M8 13h8M8 17h6"/>

                            </svg>

                        </div>


                        <div class="excel-file-info">

                            <div id="excelFileName"
                                 class="excel-file-name">

                                -

                            </div>

                            <div id="excelFileSize"
                                 class="excel-file-size">

                                -

                            </div>

                        </div>


                        <button type="button"
                                id="removeExcelFile"
                                class="excel-remove-file"
                                title="Hapus file">

                            <svg class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">

                                <path stroke-linecap="round"
                                      d="M6 6l12 12"/>

                                <path stroke-linecap="round"
                                      d="M18 6L6 18"/>

                            </svg>

                        </button>

                    </div>

                </div>


                {{-- =================================================
                     SUBMIT
                     ================================================== --}}

                <button type="submit"
                        id="importButton"
                        class="mt-5 inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">

                    <svg class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 3v12"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M7 10l5 5 5-5"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 21h14"/>

                    </svg>

                    <span>
                        Import Sekarang
                    </span>

                </button>

            </form>

        </div>


        {{-- =================================================
             TEMPLATE
             ================================================== --}}

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-semibold text-slate-900">
                Template
            </h2>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Download template terbaru yang mengikuti master aplikasi.
            </p>


            <a href="{{ route('admin.belanja.template') }}"
               class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">

                <svg class="h-5 w-5"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 3v12"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M7 10l5 5 5-5"/>

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M5 21h14"/>

                </svg>

                Download Template Excel

            </a>

        </div>

    </div>


    {{-- =====================================================
         KOLOM EXCEL
         ====================================================== --}}

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-lg font-semibold text-slate-900">
            Kolom Excel
        </h2>


        <div class="mt-4 overflow-x-auto">

            <table class="min-w-full text-left text-sm">

                <thead class="bg-slate-50 text-xs uppercase text-slate-500">

                    <tr>

                        <th class="px-4 py-3">
                            Kolom
                        </th>

                        <th class="px-4 py-3">
                            Keterangan
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Tahun Anggaran
                        </td>

                        <td class="px-4 py-3">
                            Tahun yang tersedia di aplikasi.
                        </td>

                    </tr>


                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Kode Bidang
                        </td>

                        <td class="px-4 py-3">
                            Contoh: 01.
                        </td>

                    </tr>


                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Kode Sub Bidang
                        </td>

                        <td class="px-4 py-3">
                            Contoh: 01.01.
                        </td>

                    </tr>


                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Kode Kegiatan
                        </td>

                        <td class="px-4 py-3">
                            Contoh: 01.01.01.
                        </td>

                    </tr>


                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Kode Rekening
                        </td>

                        <td class="px-4 py-3">
                            Hanya rekening detail, contoh: 5.1.1.01.
                        </td>

                    </tr>


                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Anggaran
                        </td>

                        <td class="px-4 py-3">
                            Angka tanpa simbol Rp.
                        </td>

                    </tr>


                    <tr>

                        <td class="px-4 py-3 font-semibold">
                            Status Publikasi
                        </td>

                        <td class="px-4 py-3">
                            draft atau dipublikasikan.
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', () => {

    const fileInput =
        document.getElementById('excelFile');

    const uploadZone =
        document.getElementById('excelUploadZone');

    const emptyState =
        document.getElementById('excelEmptyState');

    const fileCard =
        document.getElementById('excelFileCard');

    const fileName =
        document.getElementById('excelFileName');

    const fileSize =
        document.getElementById('excelFileSize');

    const removeButton =
        document.getElementById('removeExcelFile');

    const form =
        document.getElementById('importBelanjaForm');

    const importButton =
        document.getElementById('importButton');


    /* =========================================================
       FORMAT FILE SIZE
       ========================================================= */

    function formatFileSize(bytes) {

        if (bytes < 1024) {
            return bytes + ' B';
        }

        if (bytes < 1024 * 1024) {
            return (bytes / 1024).toFixed(1) + ' KB';
        }

        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';

    }


    /* =========================================================
       SHOW FILE
       ========================================================= */

    function showFile(file) {

        if (!file) {
            return;
        }


        const validExtensions = [
            'xlsx',
            'xls'
        ];


        const extension =
            file.name
                .split('.')
                .pop()
                .toLowerCase();


        if (!validExtensions.includes(extension)) {

            alert(
                'File harus berformat .xlsx atau .xls.'
            );

            fileInput.value = '';

            resetFile();

            return;

        }


        if (file.size > 10 * 1024 * 1024) {

            alert(
                'Ukuran file maksimal 10 MB.'
            );

            fileInput.value = '';

            resetFile();

            return;

        }


        fileName.textContent =
            file.name;

        fileSize.textContent =
            `${formatFileSize(file.size)} • File Excel siap diimpor`;


        emptyState.classList.add('hidden');

        fileCard.classList.add('show');

        uploadZone.classList.add('has-file');

    }


    /* =========================================================
       RESET FILE
       ========================================================= */

    function resetFile() {

        fileInput.value = '';

        fileCard.classList.remove('show');

        emptyState.classList.remove('hidden');

        uploadZone.classList.remove('has-file');

    }


    /* =========================================================
       INPUT FILE
       ========================================================= */

    fileInput.addEventListener('change', () => {

        const file =
            fileInput.files[0];

        showFile(file);

    });


    /* =========================================================
       REMOVE FILE
       ========================================================= */

    removeButton.addEventListener('click', event => {

        event.preventDefault();

        resetFile();

    });


    /* =========================================================
       DRAG & DROP
       ========================================================= */

    [
        'dragenter',
        'dragover'
    ].forEach(eventName => {

        uploadZone.addEventListener(
            eventName,
            event => {

                event.preventDefault();

                uploadZone.classList.add(
                    'is-dragging'
                );

            }
        );

    });


    [
        'dragleave',
        'drop'
    ].forEach(eventName => {

        uploadZone.addEventListener(
            eventName,
            event => {

                event.preventDefault();

                uploadZone.classList.remove(
                    'is-dragging'
                );

            }
        );

    });


    uploadZone.addEventListener(
        'drop',
        event => {

            const files =
                event.dataTransfer.files;

            if (!files.length) {
                return;
            }

            try {

                const dataTransfer =
                    new DataTransfer();

                dataTransfer.items.add(
                    files[0]
                );

                fileInput.files =
                    dataTransfer.files;

                showFile(files[0]);

            } catch (error) {

                showFile(files[0]);

            }

        }
    );


    /* =========================================================
       PREVENT SUBMIT WITHOUT FILE
       ========================================================= */

    form.addEventListener('submit', event => {

        if (!fileInput.files.length) {

            event.preventDefault();

            alert(
                'Silakan pilih file Excel terlebih dahulu.'
            );

            return;

        }


        importButton.disabled = true;

        importButton.querySelector('span').textContent =
            'Memproses Import...';

    });

});
</script>

@endsection