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


# Syneps Mentoring System - Detailed Documentation & Database

## 1. System Overview
Sistem Syneps Mentoring adalah platform untuk mempermudah proses pendaftaran, review, dan mentoring proyek (Skripsi, Tesis, Disertasi, Penelitian) dengan 3 role utama: Admin, Mentor, dan Peserta.

## 2. Detailed Role & Access

### A. Admin Role
- **Dashboard**: Ringkasan jumlah peserta, status project, distribusi mentor
- **Data Management**: CRUD peserta, project, mentor
- **Document Review**: Approve/reject pendaftaran berdasarkan dokumen
- **Mentor Assignment**: Menugaskan mentor ke peserta
- **Monitoring**: Tracking progress semua project
- **System Settings**: Pengaturan tahun ajaran, batas waktu pendaftaran
- **Export**: Download data dalam format Excel/PDF
- **Activity Log**: Melihat semua aktivitas admin

### B. Mentor Role
- **Portfolio**: Melihat daftar peserta yang dibimbing
- **Document Review**: Review data & dokumen project peserta
- **Mentoring Notes**: Menulis dan menyimpan catatan bimbingan
- **File Upload**: Upload file revisi, template, atau panduan
- **Progress Update**: Update status dan progress project peserta
- **Schedule**: Mengatur jadwal bimbingan

### C. Peserta Role
- **Registration**: Registrasi akun dan login
- **Project Form**: Mengisi form pendaftaran project lengkap
- **Document Upload**: Upload dokumen proposal, data, dan pendukung
- **Status Tracking**: Memantau status project dan progress bimbingan
- **Schedule View**: Melihat jadwal bimbingan yang ditetapkan
- **Download**: Mengunduh catatan dan file dari mentor

## 3. Detailed Features Breakdown

### A. Peserta Features Detail

#### 3.A.1 Registration & Authentication
- Form registrasi dengan validasi email
- Login dengan email/password
- Password reset functionality
- Email verification untuk aktivasi akun

#### 3.A.2 Project Registration Form
**Data Diri:**
- Nama lengkap
- NIM/NPM
- Email
- No. Telepon
- Program studi
- Fakultas
- IPK

**Info Project:**
- Judul project
- Bidang/kategori (Skripsi/Tesis/Disertasi/Penelitian)
- Jenis penelitian (Kualitatif/Kuantitatif/Mixed)
- Deskripsi singkat
- Status saat ini (Proposal/Bab 1/Bab 2/dst)
- Target selesai

**Kebutuhan Mentoring:**
- Area bantuan yang dibutuhkan
- Frekuensi bimbingan diinginkan
- Preferensi mentor (jika ada)

**Upload Documents:**
- Proposal (PDF, max 10MB)
- Data pendukung (ZIP/RAR, max 50MB)
- Dokumen tambahan (PDF, max 5MB each)

#### 3.A.3 Status Tracking
- Timeline visual progress
- Status notifications
- Milestone indicators
- Feedback history

### B. Mentor Features Detail

#### 3.B.1 Portfolio Management
- Dashboard peserta yang dibimbing
- Filter berdasarkan status/bidang
- Quick stats (total peserta, completed, in progress)

#### 3.B.2 Document Review System
- PDF viewer integrated
- Annotation tools
- Review checklist
- Approval/rejection workflow

#### 3.B.3 Mentoring Notes
- Rich text editor
- Categorized notes (Meeting/Review/Feedback)
- Date stamped entries
- Export to PDF

#### 3.B.4 File Management
- Upload revised documents
- Template library
- Version control
- Access control per peserta

### C. Admin Features Detail

#### 3.C.1 Dashboard Analytics
- Total peserta (active/completed/pending)
- Project distribution by type
- Mentor workload distribution
- Monthly registration trends
- Status overview pie charts

#### 3.C.2 Data Management
- Peserta CRUD with search/filter
- Bulk operations (approve/reject)
- Data validation rules
- Import/export functionality

#### 3.C.3 Mentor Assignment System
- Available mentor list
- Workload balancing
- Expertise matching
- Assignment history

## 4. Database Schema (MySQL)

### 4.1 Users Table (Authentication)
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'mentor', 'peserta') NOT NULL DEFAULT 'peserta',
    is_active BOOLEAN DEFAULT TRUE,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.2 Peserta Profiles
```sql
CREATE TABLE peserta_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nim VARCHAR(20) UNIQUE NOT NULL,
    phone VARCHAR(15),
    program_studi VARCHAR(100) NOT NULL,
    fakultas VARCHAR(100) NOT NULL,
    ipk DECIMAL(3,2),
    angkatan YEAR,
    alamat TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.3 Mentor Profiles
```sql
CREATE TABLE mentor_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    nip VARCHAR(20) UNIQUE,
    expertise TEXT, -- JSON array of expertise areas
    max_mentees INT DEFAULT 10,
    current_mentees INT DEFAULT 0,
    bio TEXT,
    education TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.4 Projects
```sql
CREATE TABLE projects (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    peserta_id BIGINT UNSIGNED NOT NULL,
    mentor_id BIGINT UNSIGNED NULL,
    title VARCHAR(500) NOT NULL,
    category ENUM('skripsi', 'tesis', 'disertasi', 'penelitian') NOT NULL,
    research_type ENUM('kualitatif', 'kuantitatif', 'mixed') NOT NULL,
    description TEXT NOT NULL,
    current_status VARCHAR(100) DEFAULT 'proposal',
    target_completion DATE,
    mentoring_needs TEXT,
    mentor_preference VARCHAR(255),
    status ENUM('pending', 'reviewed', 'approved', 'rejected', 'in_progress', 'completed') DEFAULT 'pending',
    approved_at TIMESTAMP NULL,
    approved_by BIGINT UNSIGNED NULL,
    completed_at TIMESTAMP NULL,
    FOREIGN KEY (peserta_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mentor_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.5 Project Documents
```sql
CREATE TABLE project_documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    document_type ENUM('proposal', 'data_pendukung', 'tambahan', 'revisi') NOT NULL,
    original_name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    file_size INT UNSIGNED,
    mime_type VARCHAR(100),
    uploaded_by BIGINT UNSIGNED NOT NULL,
    description TEXT,
    version INT DEFAULT 1,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.6 Mentoring Sessions
```sql
CREATE TABLE mentoring_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    mentor_id BIGINT UNSIGNED NOT NULL,
    session_date DATETIME NOT NULL,
    duration_minutes INT DEFAULT 60,
    session_type ENUM('meeting', 'review', 'consultation') NOT NULL,
    notes TEXT,
    feedback TEXT,
    next_action TEXT,
    status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (mentor_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.7 Progress Tracking
```sql
CREATE TABLE project_progress (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id BIGINT UNSIGNED NOT NULL,
    milestone VARCHAR(100) NOT NULL,
    description TEXT,
    target_date DATE,
    completion_date DATE NULL,
    progress_percentage TINYINT UNSIGNED DEFAULT 0,
    status ENUM('pending', 'in_progress', 'completed', 'overdue') DEFAULT 'pending',
    notes TEXT,
    updated_by BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.8 System Settings
```sql
CREATE TABLE system_settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    description TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    updated_by BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 4.9 Activity Logs
```sql
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    model_type VARCHAR(100), -- Model yang di-affect (Project, User, etc)
    model_id BIGINT UNSIGNED, -- ID dari model yang di-affect
    old_values JSON, -- Data sebelum perubahan
    new_values JSON, -- Data setelah perubahan
    ip_address VARCHAR(45),
    user_agent TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4.10 Notifications
```sql
CREATE TABLE notifications (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
    is_read BOOLEAN DEFAULT FALSE,
    action_url VARCHAR(500),
    expires_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 5. Laravel Migration Commands

```bash
# Generate migrations
php artisan make:migration create_peserta_profiles_table
php artisan make:migration create_mentor_profiles_table
php artisan make:migration create_projects_table
php artisan make:migration create_project_documents_table
php artisan make:migration create_mentoring_sessions_table
php artisan make:migration create_project_progress_table
php artisan make:migration create_system_settings_table
php artisan make:migration create_activity_logs_table
php artisan make:migration create_notifications_table
```

## 6. Seeder Data Examples

### 6.1 Default Admin User
```sql
INSERT INTO users (name, email, password, role, email_verified_at) VALUES 
('Super Admin', 'admin@syneps.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW());
```

### 6.2 System Settings
```sql
INSERT INTO system_settings (setting_key, setting_value, setting_type, description, updated_by) VALUES
('registration_open', '1', 'boolean', 'Enable/disable new registrations', 1),
('current_academic_year', '2024/2025', 'string', 'Current academic year', 1),
('max_file_size_mb', '10', 'number', 'Maximum file upload size in MB', 1),
('registration_deadline', '2024-12-31', 'string', 'Registration deadline date', 1);
```

## 7. Key Queries for Common Operations

### 7.1 Dashboard Statistics (Admin)
```sql
-- Total peserta by status
SELECT status, COUNT(*) as count 
FROM projects 
GROUP BY status;

-- Mentor workload
SELECT u.name, mp.current_mentees, mp.max_mentees
FROM users u 
JOIN mentor_profiles mp ON u.id = mp.user_id 
WHERE u.role = 'mentor';

-- Monthly registrations
SELECT MONTH(created_at) as month, COUNT(*) as registrations
FROM projects 
WHERE YEAR(created_at) = YEAR(CURDATE())
GROUP BY MONTH(created_at);
```

### 7.2 Mentor's Students
```sql
-- Get mentor's assigned projects
SELECT p.*, u.name as peserta_name, pp.nim
FROM projects p
JOIN users u ON p.peserta_id = u.id
JOIN peserta_profiles pp ON u.id = pp.user_id
WHERE p.mentor_id = ? AND p.status IN ('approved', 'in_progress');
```

### 7.3 Project Progress Tracking
```sql
-- Get project progress
SELECT pp.*, p.title
FROM project_progress pp
JOIN projects p ON pp.project_id = p.id
WHERE p.id = ?
ORDER BY pp.created_at DESC;
```

## 8. File Storage Structure

```
storage/app/
├── public/
│   ├── documents/
│   │   ├── proposals/
│   │   ├── data/
│   │   └── revisions/
│   └── exports/
│       ├── excel/
│       └── pdf/
```

## 9. Security Considerations

- File upload validation (type, size, virus scan)
- Role-based middleware for all routes
- CSRF protection on forms
- SQL injection protection (Eloquent ORM)
- XSS protection (input sanitization)
- Rate limiting on auth routes
- Secure file download (authorized access only)

## 10. Basic Workflow Implementation

1. **Peserta registers** → Creates user + peserta_profile + project
2. **Admin reviews** → Updates project status + assigns mentor
3. **Mentor starts mentoring** → Creates mentoring_sessions + updates progress
4. **System tracks everything** → Logs in activity_logs + sends notifications

Sistem ini sudah cukup komprehensif untuk kebutuhan dasar dan dapat dikembangkan secara bertahap oleh 2 developer.


@c:\laragon\www\bimbingan-riset@bimbingan-riset real.sql bikkin validasi format nomor wa itu +62 dan ditahap 2 ketika pilihan minat keilmuan dan basis sistem peserta milih lainnya itu muncul kolom teks dimana peserta mengisi nya sendiri, selanjutnya selesaikan dashboard