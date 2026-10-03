UI CLEAN V2

Berdasarkan screenshot:
- Jarak Year/Bidang dan Sub Bidang/Kegiatan diperlebar.
- Label diberi jarak bawah yang konsisten.
- Search icon diberi ruang kiri yang jelas.
- Search input lebih tinggi/rapi.
- Dropdown kembali menjadi popover absolute dengan z-index sehingga tidak menggeser/mengacaukan grid.
- Daftar tetap scrollable dengan tinggi terbatas.
- Data/controller/database tidak diubah.

Replace:
resources/views/admin/belanja/form.blade.php

Then:
php artisan view:clear
php artisan optimize:clear
