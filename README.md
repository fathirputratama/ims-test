Sistem Manajemen Klinik
Aplikasi berbasis web untuk mengelola pendaftaran pasien, transaksi medis, dan pembayaran di klinik. Dibangun menggunakan Laravel, Laravel Breeze,  PostgreSQL, dan Tailwind CSS.

Clone Repository
git clone https://github.com/fathirputratama/ims-test.git
cd ims-test


Instal Dependensi
composer install
npm install


Konfigurasi Environment

Salin file .env.example ke .env:cp .env.example .env


Sesuaikan konfigurasi database di .env:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nama_database
DB_USERNAME=postgres
DB_PASSWORD=rahasia

Generate Key
php artisan key:generate

Jalankan Migrasi
php artisan migrate


Jalankan Seeder
php artisan db:seed --class=ProvinceSeeder
php artisan db:seed --class=CitySeeder

PERINGATAN: Pastikan menjalankan ProvinceSeeder dan CitySeeder sebelum menggunakan fitur pendaftaran pasien. Tabel provinces dan cities harus terisi untuk mendukung input alamat (provinsi dan kota) di form pendaftaran.

Kompilasi Asset
npm run dev

Jalankan Server
php artisan serve

Akses aplikasi di http://127.0.0.1:8000.