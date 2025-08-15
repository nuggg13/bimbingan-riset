# Mentor Dashboard - Bimbingan Riset

## Overview
Dashboard mentor telah berhasil dibuat untuk sistem Bimbingan Riset. Dashboard ini memungkinkan mentor untuk melihat dan mengelola peserta yang mereka bimbing berdasarkan data dari tabel `jadwal`, `pendaftaran`, dan `peserta`.

## Fitur Dashboard Mentor

### 1. **Autentikasi Mentor**
- Login khusus untuk mentor di `/mentor/login`
- Menggunakan guard terpisah untuk keamanan
- Session management yang aman

### 2. **Dashboard Utama** (`/mentor/dashboard`)
- **Statistik Overview:**
  - Total peserta yang dibimbing
  - Jadwal aktif (scheduled & ongoing)
  - Jadwal yang telah selesai
  - Pendaftaran yang masih pending
- **Daftar Peserta Terbaru:** Menampilkan 5 peserta terakhir dengan informasi riset
- **Jadwal Terbaru:** Menampilkan 5 jadwal terbaru dengan status

### 3. **Manajemen Peserta** (`/mentor/participants`)
- **Daftar Lengkap Peserta:** Semua peserta yang dibimbing mentor
- **Informasi Detail:**
  - Data pribadi peserta (nama, email, instansi, fakultas)
  - Judul riset dan deskripsi
  - Minat keilmuan dan basis sistem
  - Status pendaftaran
- **Detail Peserta:** Halaman khusus untuk setiap peserta dengan informasi lengkap
- **Aksi Cepat:** WhatsApp dan email langsung dari dashboard

### 4. **Manajemen Jadwal** (`/mentor/schedules`)
- **Daftar Semua Jadwal:** Dengan filter berdasarkan status
- **Filter Status:**
  - Semua jadwal
  - Terjadwal (scheduled)
  - Sedang berlangsung (ongoing)
  - Selesai (completed)
  - Dibatalkan (cancelled)
- **Informasi Jadwal:**
  - Periode bimbingan
  - Waktu dan hari
  - Status real-time
  - Akses langsung ke detail peserta

## Struktur Database yang Digunakan

### Relasi Tabel:
```
mentor (id_mentor) 
  ↓ (1:N)
jadwal (id_mentor, id_pendaftaran)
  ↓ (N:1)
pendaftaran (id_pendaftaran, id_peserta)
  ↓ (N:1)
peserta (id_peserta)
```

### Query Logic:
- Mentor dapat melihat peserta melalui relasi: `mentor → jadwal → pendaftaran → peserta`
- Sistem memastikan mentor hanya dapat mengakses peserta yang mereka bimbing
- Filter otomatis berdasarkan `id_mentor` di tabel jadwal

## Cara Mengakses

### 1. **Login Mentor**
- URL: `http://localhost/mentor/login`
- Credentials (berdasarkan data di database):
  - Email: `ozi@gmail.com`
  - Password: `password` (atau sesuai hash di database)

### 2. **Navigasi Dashboard**
- **Dashboard:** `/mentor/dashboard`
- **Peserta:** `/mentor/participants`
- **Detail Peserta:** `/mentor/participants/{id}`
- **Jadwal:** `/mentor/schedules`

## File yang Dibuat/Dimodifikasi

### Controllers:
- `app/Http/Controllers/MentorAuthController.php` - Autentikasi mentor
- `app/Http/Controllers/MentorDashboardController.php` - Logic dashboard mentor

### Middleware:
- `app/Http/Middleware/MentorMiddleware.php` - Proteksi route mentor

### Views:
- `resources/views/mentor/layout.blade.php` - Layout utama mentor
- `resources/views/mentor/auth/login.blade.php` - Halaman login
- `resources/views/mentor/dashboard.blade.php` - Dashboard utama
- `resources/views/mentor/participants/index.blade.php` - Daftar peserta
- `resources/views/mentor/participants/detail.blade.php` - Detail peserta
- `resources/views/mentor/schedules/index.blade.php` - Daftar jadwal

### Configuration:
- `config/auth.php` - Ditambahkan guard dan provider mentor
- `app/Http/Kernel.php` - Ditambahkan middleware mentor
- `routes/web.php` - Ditambahkan route mentor

## Keamanan

### 1. **Authentication Guard**
- Menggunakan guard terpisah `mentor` 
- Session terpisah dari admin dan peserta
- Password hashing dengan bcrypt

### 2. **Authorization**
- Middleware memastikan hanya mentor yang login dapat mengakses
- Verifikasi akses: mentor hanya dapat melihat peserta yang mereka bimbing
- Protection terhadap unauthorized access

### 3. **Data Validation**
- Input validation pada form login
- CSRF protection pada semua form
- XSS protection melalui Blade templating

## Fitur Tambahan

### 1. **Responsive Design**
- Mobile-friendly interface
- Tailwind CSS untuk styling konsisten
- Font Awesome icons

### 2. **User Experience**
- Loading states dan feedback
- Intuitive navigation
- Quick actions (WhatsApp, Email)
- Status badges dengan color coding

### 3. **Data Visualization**
- Statistics cards dengan icons
- Status indicators
- Timeline information
- Filter dan search capabilities

## Testing

Untuk menguji dashboard mentor:

1. **Setup Database:**
   - Pastikan ada data mentor di tabel `mentor`
   - Pastikan ada relasi data di `jadwal`, `pendaftaran`, dan `peserta`

2. **Login Test:**
   - Akses `/mentor/login`
   - Login dengan credentials mentor yang valid

3. **Functionality Test:**
   - Cek dashboard statistics
   - Browse peserta dan detail
   - Filter jadwal berdasarkan status
   - Test quick actions (WhatsApp, Email)

## Troubleshooting

### Common Issues:
1. **Route not found:** Jalankan `php artisan route:clear`
2. **View not found:** Jalankan `php artisan view:clear`
3. **Config cache:** Jalankan `php artisan config:clear`
4. **Login gagal:** Periksa credentials di database dan hash password

### Debug Commands:
```bash
php artisan route:list | grep mentor
php artisan config:clear
php artisan view:clear
php artisan cache:clear
```

Dashboard mentor sekarang siap digunakan dan terintegrasi penuh dengan sistem Bimbingan Riset yang sudah ada!