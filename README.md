# e-APBDesa

**Sistem Informasi Publikasi APBDesa** untuk Pemerintah Desa dan masyarakat.

## Tahap 1 — Fondasi

Tahap ini menyediakan fondasi Laravel Blade, autentikasi administrator, layout responsif, profil Desa Sumber Jaya yang dapat disunting, dan master Tahun Anggaran dengan satu tahun aktif.

### Menjalankan aplikasi

1. Salin `.env.example` menjadi `.env`, kemudian isi kredensial MySQL 8.
2. Instal dependensi: `composer install` dan `npm install`.
3. Buat aplikasi key: `php artisan key:generate`.
4. Migrasi dan data contoh: `php artisan migrate --seed`.
5. Bangun aset: `npm run build`.
6. Jalankan: `php artisan serve`.

Akun contoh: `admin@eapbdesa.test` / `password`. Ubah kredensial ini sebelum aplikasi digunakan.

> Data awal adalah data dummy pengembangan, bukan APBDesa resmi.
