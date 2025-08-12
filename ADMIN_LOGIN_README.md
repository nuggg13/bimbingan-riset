# Sistem Login Admin - Bimbingan Riset

## Deskripsi
Sistem login admin yang sudah terintegrasi dengan Laravel menggunakan tabel `admin` yang sudah ada. Sistem ini menggunakan guard terpisah untuk admin dan memiliki middleware keamanan.

## Fitur
- ✅ Login admin dengan email dan password
- ✅ Dashboard admin yang responsif
- ✅ Middleware keamanan untuk route admin
- ✅ Logout dengan session invalidation
- ✅ UI modern dengan Tailwind CSS
- ✅ Validasi form yang aman
- ✅ Error handling yang user-friendly

## Struktur Database
Tabel `admin` yang sudah ada:
- `id_admin` (Primary Key)
- `nama`
- `email`
- `password`
- `nomor_wa`
- `created_at`
- `updated_at`

## File yang Dibuat/Dimodifikasi

### 1. Model
- `app/Models/Admin.php` - Model Admin dengan autentikasi

### 2. Controller
- `app/Http/Controllers/AdminController.php` - Controller untuk login, logout, dan dashboard

### 3. Middleware
- `app/Http/Middleware/AdminMiddleware.php` - Middleware untuk melindungi route admin

### 4. Views
- `resources/views/admin/login.blade.php` - Halaman login admin
- `resources/views/admin/dashboard.blade.php` - Dashboard admin

### 5. Routes
- `routes/web.php` - Route untuk admin (login, logout, dashboard)

### 6. Configuration
- `config/auth.php` - Konfigurasi guard dan provider untuk admin
- `app/Http/Kernel.php` - Registrasi middleware admin

### 7. Seeder
- `database/seeders/AdminSeeder.php` - Data admin default
- `database/seeders/DatabaseSeeder.php` - Update untuk memanggil AdminSeeder

## Cara Penggunaan

### 1. Akses Login Admin
```
http://your-domain.com/admin/login
```

### 2. Kredensial Default
Setelah menjalankan seeder, Anda bisa login dengan:

**Admin 1:**
- Email: `admin@bimbinganriset.com`
- Password: `admin123`

**Admin 2:**
- Email: `superadmin@bimbinganriset.com`
- Password: `superadmin123`

### 3. Dashboard Admin
```
http://your-domain.com/admin/dashboard
```

## Route yang Tersedia

| Method | URL | Name | Description |
|--------|-----|------|-------------|
| GET | `/admin/login` | `admin.login` | Form login admin |
| POST | `/admin/login` | - | Proses login |
| POST | `/admin/logout` | `admin.logout` | Logout admin |
| GET | `/admin/dashboard` | `admin.dashboard` | Dashboard admin (protected) |

## Middleware

### AdminMiddleware
- Melindungi route admin
- Redirect ke login jika belum authenticated
- Dapat diakses dengan `Route::middleware('admin')`

## Keamanan

1. **CSRF Protection** - Semua form dilindungi dengan CSRF token
2. **Session Security** - Session regeneration setelah login
3. **Password Hashing** - Password di-hash menggunakan bcrypt
4. **Route Protection** - Route admin dilindungi middleware
5. **Input Validation** - Validasi email dan password

## Customization

### Menambah Route Admin Baru
```php
Route::middleware('admin')->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::get('/admin/settings', [AdminController::class, 'settings']);
});
```

### Menambah Fitur di Dashboard
Edit file `resources/views/admin/dashboard.blade.php` dan tambahkan section baru sesuai kebutuhan.

## Troubleshooting

### 1. Error "Class 'App\Models\Admin' not found"
- Pastikan model Admin sudah dibuat
- Jalankan `composer dump-autoload`

### 2. Error "Guard [admin] is not defined"
- Pastikan konfigurasi auth.php sudah diupdate
- Pastikan middleware sudah didaftarkan di Kernel.php

### 3. Login tidak berhasil
- Pastikan tabel admin sudah ada
- Pastikan seeder sudah dijalankan
- Cek apakah password sudah di-hash

### 4. Route tidak ditemukan
- Pastikan route sudah didefinisikan di web.php
- Jalankan `php artisan route:clear`
- Jalankan `php artisan route:cache`

## Dependencies

- Laravel 10+
- PHP 8.1+
- Database MySQL/PostgreSQL/SQLite

## Support

Jika ada pertanyaan atau masalah, silakan buat issue atau hubungi tim development.
