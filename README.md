# ⚡️ LelangKilat Platform

Repositori ini berisi dua aplikasi yang saling terintegrasi:

1. **Backend** – Laravel 10 yang menyediakan REST API (`/api/v1`).
2. **Frontend** – React + Vite yang mengonsumsi API tersebut.

Semua konfigurasi menggunakan zona waktu `Asia/Jakarta` dan format lokal Indonesia.

## 🏗️ Arsitektur Singkat

Lihat ringkasan lengkap pada [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md). Diagram ASCII, penjelasan layer, dan daftar komponen tersedia di sana.

## 🚀 Setup Lingkungan

### Prasyarat
- PHP 8.1+
- Composer
- Node.js 20+
- NPM 10+
- MySQL/MariaDB & Redis

### Backend
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve # port 8000
```

### Frontend
```bash
cd frontend
npm install
npm run dev # port 5173
```

### QA Seed
Seeder `QaSeeder` otomatis dijalankan oleh `php artisan db:seed`. Kredensial contoh:

| Peran  | Email            | Kata Sandi   |
|--------|------------------|--------------|
| Admin  | admin@qa.test    | password123  |
| Staff  | staff@qa.test    | password123  |
| User   | user1@qa.test    | password123  |

### Perintah Penting
| Fungsi                  | Perintah                                  |
|------------------------|--------------------------------------------|
| Menjalankan test PHP   | `php artisan test`                         |
| Lint PHP (Pint)        | `vendor/bin/pint`                          |
| Test Frontend          | `cd frontend && npm run test`              |
| Lint Frontend          | `cd frontend && npm run lint`              |
| Build Frontend         | `cd frontend && npm run build`             |

## 🔐 Keamanan
- Autentikasi: Laravel Sanctum bearer token + refresh token rotasi.
- Role based access control melalui middleware `role`.
- Rate limit default 120 req/menit.
- Semua input tervalidasi via Form Request & Zod.
- Audit log setiap aksi kritikal, disimpan di tabel `audit_logs`.

## 📊 Observabilitas
- Endpoint health: `/api/v1/health/live` & `/api/v1/health/ready`.
- Structured logging dengan header `X-Request-Id`.
- Queue & cache siap pakai (Redis).

## 🔁 Migrasi Bertahap
Rencana detail migrasi terdapat pada [`docs/MIGRATION_PLAN.md`](docs/MIGRATION_PLAN.md).

## 📚 Dokumentasi Lain
- [Dokumen API](docs/API/README.md)
- [Panduan Frontend](docs/frontend/README.md)
- [Checklist QA](docs/QA_CHECKLIST.md)

Selamat berkarya! 🎉
