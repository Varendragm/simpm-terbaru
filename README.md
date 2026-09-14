# SIMPM — Sistem Informasi Manajemen Pemeliharaan Mesin
### Pabrik Gula Rendeng — Laravel + MySQL

Implementasi backend/full-stack (Laravel 10, Blade, MySQL) dari `prd-SIMPM-PG-Rendeng-v1.1.md`
dan `design-SIMPM-PG-Rendeng-v1.1.md`, melanjutkan mockup fungsional v19.

## 1. Cakupan yang sudah diimplementasikan

- Struktur data **Pabrik → Stasiun → Mesin** yang scalable (tabel `stations`, `machines`) —
  tambah/edit/hapus stasiun & mesin dari UI (menu **Stasiun & Mesin**, khusus Supervisor).
- **Autentikasi sungguhan** berbasis session (bukan role-switcher demo lagi) dengan 3 role:
  `supervisor`, `teknisi`, `manajer` — lihat `RoleMiddleware`.
- **Dashboard per peran** (`/dashboard`): Supervisor, Manajer (eksekutif read-only), Teknisi (tugas pribadi).
- **Perhitungan performa dari data operasional**, bukan angka hardcode — lihat
  `app/Services/PerformanceCalculator.php`, yang mengimplementasikan persis rumus di PRD §6.8:
  Availability, MTTR, MTBF, Reliability, Performance, Quality, OEE. Jika data mentah
  (`machine_performance_data`) belum tersedia untuk suatu periode, hasil dikembalikan `null`
  dan tampilan menunjukkan **"Belum tersedia"** — tidak pernah mengarang angka.
- **Alur Preventive Maintenance lengkap**: Supervisor membuat jadwal → Teknisi mengisi laporan
  pemeriksaan (kategori, temuan, tindakan, sparepart, downtime) → Supervisor memvalidasi
  (setuju/tolak + catatan + opsi jadwal berikutnya) → otomatis tercatat ke
  **Riwayat Maintenance** saat disetujui.
- **Riwayat Maintenance gabungan**: kolom `source` membedakan asal data `pm` (hasil PM
  tervalidasi) vs `sippm` (sinkronisasi dari SIPPM, sesuai kontrak data di PRD §7 —
  `machineId`, kategori, pekerjaan, pelaksana, downtime, tanggal).
- **Laporan & Grafik** dengan filter Periode/Stasiun/Mesin: KPI ringkas, OEE per mesin,
  Downtime per mesin, tren downtime 6 bulan, ringkasan per stasiun (tabel).
- **Profil & password** per pengguna.
- Filter berjenjang Stasiun → Mesin di beberapa halaman menggunakan endpoint kecil
  `GET /master/stasiun/{station}/mesin` (JSON) tanpa reload halaman.
- Tampilan mengikuti design token "Industrial Clean" dari `design.md` (§3.1 sidebar,
  warna status, tipografi Barlow Condensed / Inter / IBM Plex Mono) — lihat `public/css/app.css`.

## 2. Yang sengaja belum dibangun (sesuai PRD §5.2 & §11)

- Modul pelaporan kerusakan (SIPPM) — dianggap sistem terpisah yang sudah berjalan;
  SIMPM hanya menyediakan struktur `maintenance_histories.source = 'sippm'` sebagai titik
  integrasi. Untuk integrasi nyata, buat job/endpoint yang menulis ke tabel tersebut
  sesuai kontrak data pada PRD §7.
- Ekspor PDF/Excel sungguhan — tombol di halaman Laporan saat ini placeholder.
- Notifikasi (jadwal jatuh tempo, validasi tertunda) dan audit trail perubahan master data.

## 3. Struktur Basis Data (ringkas)

| Tabel | Fungsi |
|---|---|
| `users` | Akun & peran (supervisor/teknisi/manajer) |
| `stations` | Master stasiun |
| `machines` | Master mesin, relasi `station_id` |
| `machine_performance_data` | **Data operasional mentah** per mesin per periode (`YYYY-MM`): planned time, downtime, repair time, jumlah kegagalan, actual/ideal/good output — sumber perhitungan performa |
| `pm_schedules` | Jadwal preventive maintenance |
| `inspection_reports` | Laporan pemeriksaan Teknisi per jadwal |
| `sparepart_usages` | Sparepart yang dipakai per laporan |
| `validation_histories` | Keputusan validasi Supervisor |
| `maintenance_histories` | Riwayat final (gabungan PM tervalidasi + sinkronisasi SIPPM), sumber halaman Laporan |

## 4. Menjalankan Proyek

### Prasyarat
- PHP >= 8.1 dengan ekstensi umum Laravel (`pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`)
- Composer 2.x
- MySQL 8.x (atau MariaDB 10.4+)

### Langkah instalasi

```bash
# 1. Masuk ke folder proyek
cd simpm

# 2. Install dependency PHP
composer install

# 3. Salin & sesuaikan environment (file .env sudah ada, cek/ubah kredensial DB)
cp .env.example .env   # jika .env belum ada
# edit .env -> DB_DATABASE, DB_USERNAME, DB_PASSWORD sesuai server MySQL Anda

# 4. Generate application key
php artisan key:generate

# 5. Buat database MySQL kosong terlebih dahulu, misalnya:
#    CREATE DATABASE simpm_pg_rendeng CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 6. Jalankan migrasi + seeder (membuat tabel & data contoh setara mockup)
php artisan migrate --seed

# 7. Buat symlink storage (untuk kebutuhan upload/asset publik di kemudian hari)
php artisan storage:link

# 8. Jalankan server pengembangan
php artisan serve
```

Buka `http://127.0.0.1:8000` — Anda akan diarahkan ke halaman login.

### Akun demo (dibuat oleh `UserSeeder`)

| Peran | Email | Password |
|---|---|---|
| Supervisor | supervisor@simpm.local | password123 |
| Manajer | manajer@simpm.local | password123 |
| Teknisi | budi@simpm.local | password123 |
| Teknisi | rudi@simpm.local | password123 |

Data contoh mencakup 3 stasiun (Gilingan, Boiler, Puteran & Pemurnian), 9 mesin,
6 bulan data operasional per mesin, beberapa jadwal PM (terjadwal/menunggu
validasi), dan riwayat maintenance dari kedua sumber (`pm` & `sippm`) — cukup
untuk mendemonstrasikan seluruh alur di PRD tanpa entri data manual.

> Catatan: proyek ini tidak menggunakan Vite/npm build — seluruh CSS/JS berada
> di `public/css` dan inline pada Blade, sehingga tidak perlu langkah `npm install`
> untuk menjalankannya.

## 5. Peta Fitur → Kode

| Modul PRD | Rute utama | Controller | View |
|---|---|---|---|
| §6.1 Master Stasiun & Mesin | `/master/stasiun-mesin` | `StationController`, `MachineController` | `stations/index.blade.php` |
| §6.2 Dashboard per peran | `/dashboard` | `DashboardController` | `dashboard/*.blade.php` |
| §6.3 Performa & Detail Mesin | `/performa`, `/performa/{machine}` | `PerformanceController` | `performance/*.blade.php` |
| §6.4 Jadwal PM | `/jadwal`, `/jadwal-baru` | `PmScheduleController` | `schedules/*.blade.php` |
| §6.5 Validasi Pemeriksaan | `/jadwal/{s}/laporan`, `/validasi` | `InspectionReportController`, `ValidationController` | `schedules/report.blade.php`, `validation/*.blade.php` |
| §6.6 Riwayat Maintenance | `/riwayat` | `MaintenanceHistoryController` | `history/index.blade.php` |
| §6.7 Laporan & Grafik | `/laporan` | `ReportController` | `reports/index.blade.php` |
| §6.8 Perhitungan Performa | — (service) | `App\Services\PerformanceCalculator` | dipakai di semua view performa |
| §6.9 Profil & Akun | `/profil` | `ProfileController` | `profile/edit.blade.php` |

## 6. Langkah Lanjutan yang Disarankan (lihat PRD §11)

1. Sambungkan `maintenance_histories.source = 'sippm'` ke webhook/API SIPPM sungguhan.
2. Tambahkan job terjadwal (Laravel Scheduler) untuk notifikasi jadwal PM jatuh tempo
   dan pemeriksaan yang menunggu validasi terlalu lama.
3. Implementasikan ekspor PDF/Excel sungguhan (mis. `barryvdh/laravel-dompdf`,
   `maatwebsite/excel`) menggantikan tombol placeholder di halaman Laporan.
4. Tambahkan audit trail (`spatie/laravel-activitylog` atau tabel `activity_logs` custom)
   untuk perubahan master data Stasiun/Mesin.
5. Tambahkan test otomatis (PHPUnit/Pest) untuk `PerformanceCalculator` dan alur validasi.
