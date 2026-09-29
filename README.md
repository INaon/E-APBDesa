# e-APBDesa

Sistem Informasi Publikasi APBDesa untuk transparansi anggaran dan realisasi Desa Sumber Jaya.

## Menjalankan aplikasi
1. Salin `.env.example` ke `.env`, atur koneksi MySQL, lalu buat basis data `e_apbdesa`.
2. Jalankan `composer install`, `php artisan key:generate`, `php artisan migrate --seed`.
3. Jalankan `npm install && npm run build` dan `php artisan storage:link`.
4. Mulai aplikasi dengan `php artisan serve`.

Akun awal: `admin@eapbdesa.test` / `password` (ganti sesudah login).

> Data seeder adalah data demonstrasi, bukan APBDesa resmi.
