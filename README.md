# Sistem Pengaduan Masyarakat

Aplikasi web untuk mengelola pengaduan masyarakat berbasis Laravel dengan sistem role-based access (Guest, Staff, Head Staff).

## Fitur Utama

### Guest
- Register dan login
- Membuat pengaduan dengan lokasi (Provinsi, Kabupaten, Kecamatan, Kelurahan)
- Upload gambar pendukung
- Melihat semua pengaduan
- Voting dan komentar pada pengaduan
- Melihat status pengaduan pribadi
- Hapus pengaduan (jika belum ditanggapi)

### Staff
- Login dengan akun yang dibuat oleh Head Staff
- Melihat pengaduan sesuai provinsi yang ditugaskan
- Memberikan response dan progress pada pengaduan
- Update status pengaduan (ON_PROCESS, DONE, REJECT)
- Export data pengaduan per kabupaten/kota (CSV)
- Pencarian pengaduan

### Head Staff
- Membuat akun Staff per provinsi
- Melihat semua pengaduan dari semua provinsi
- Kelola akun Staff (reset password, hapus)
- Export data pengaduan per provinsi (CSV)
- Dashboard statistik pengaduan

## Teknologi

- **Framework**: Laravel 10
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, jQuery
- **API**: API Wilayah Indonesia (emsifa.com)
- **Storage**: Laravel Storage (Symbolic Link)

## Instalasi

### Requirement
- PHP 8.2+
- Composer
- MySQL/MariaDB
- XAMPP/Laragon

### Langkah Instalasi

1. Clone repository
```bash
git clone https://github.com/pannca/pengaduan-masyarakat.git
cd pengaduan-masyarakat
```

2. Install dependencies
```bash
composer install
```

3. Copy file .env
```bash
copy .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Konfigurasi database di `.env`
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=pengaduan
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migration
```bash
php artisan migrate
```

7. Buat symbolic link untuk storage
```bash
mklink /D public\storage ..\storage\app\public
```

8. Jalankan aplikasi
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## Role & Akses

| Role | Email | Password | Akses |
|------|-------|----------|-------|
| Guest | (register sendiri) | - | Buat & lihat pengaduan |
| Staff | (dibuat oleh Head Staff) | - | Handle pengaduan per provinsi |
| Head Staff | (seeder/manual) | - | Kelola staff & lihat semua |

## Struktur Database

- **users** - Data user (Guest, Staff, Head Staff)
- **reports** - Data pengaduan
- **responses** - Response staff terhadap pengaduan
- **response_progress** - History progress pengaduan
- **comments** - Komentar pada pengaduan
- **staff_provinces** - Mapping staff ke provinsi

## Catatan

- Gambar pengaduan disimpan di `storage/app/public/reports/`
- Data wilayah (provinsi, kabupaten, kecamatan, kelurahan) menggunakan API eksternal
- Export data dalam format CSV
- Symbolic link wajib dibuat agar gambar bisa diakses

## License

MIT License
