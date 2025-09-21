# Arsitektur LelangKilat vNext

## Ringkasan

Platform LelangKilat kini dipisah menjadi dua aplikasi mandiri: **backend Laravel API** dan **frontend React** yang berkomunikasi melalui REST API versi `v1` berbasis JSON. Backend menangani autentikasi (Laravel Sanctum + JWT kompatibel), bisnis proses lelang, audit log, dan integrasi eksternal. Frontend memanfaatkan React Query untuk pengambilan data, design system internal, serta routing berbasis peran. Semua komunikasi mengikuti format tanggal dan mata uang Indonesia dengan zona waktu `Asia/Jakarta`.

## Diagram ASCII

```
+-----------------------+          HTTPS (REST v1)          +---------------------------+
|  Frontend React       |  <------------------------------> |  Laravel API (App Layer) |
|  - Vite + React Query |                                   |  - Controllers (API v1)   |
|  - Design System      |                                   |  - Services & DTO         |
|  - Protected Routes   |                                   |  - Repositories           |
|  - Theme Light/Dark   |                                   |  - Events & Jobs          |
+----------+------------+                                   +-----------+---------------+
           |                                                                |
           |                                                                v
           |                                                 +---------------------------+
           |                                                 | MySQL / MariaDB           |
           |                                                 | Redis (cache + queue)     |
           |                                                 | MinIO/S3 (object storage) |
           |                                                 +---------------------------+
           |
           v
+-----------------------+
| Observability Stack   |
| - Health Endpoints    |
| - Structured Logging  |
| - Metrics Exporter    |
+-----------------------+
```

## Lapisan Backend

- **Routes**: `routes/api.php` dengan prefix `/api/v1` dan middleware `auth:sanctum`, rate limit, dan CORS terbatas domain frontend.
- **Controller** (`App\Http\Controllers\Api\V1`): menangani validasi request, mendelegasikan ke service.
- **DTO/Form Request** (`App\Http\Requests\Api\V1`): validasi terpusat menggunakan aturan dan pesan khusus berbahasa Indonesia.
- **Service** (`App\Services`): bisnis proses, pemanggilan repository, menulis audit log, mengemas respon konsisten.
- **Repository** (`App\Repositories`): query database dengan filter/pagination/sorting standar.
- **Resources** (`App\Http\Resources`): serialisasi keluaran untuk UI dan API.
- **Events & Jobs** (`App\Events`, `App\Jobs`): untuk notifikasi, email, pekerjaan berat antrian.

## Lapisan Frontend

- **Data Layer**: `src/lib/apiClient.ts` (Axios) + `src/lib/queryClient.ts` (TanStack Query) dengan strategi revalidate `staleTime` & `cacheTime` terukur.
- **Design System**: token (`tokens.ts`), tema (`theme.css`), dan komponen (`components/*`) reusable.
- **Routing**: `react-router` dengan guard berbasis peran dan fallback loading/error state.
- **State Management**: TanStack Query + konteks ringan untuk session & preferensi.

## Keamanan

- Autentikasi berbasis Sanctum token + refresh token rotasi.
- Middleware peran (`EnsureRole`) dan `Policy` Laravel untuk operasi sensitif.
- Sanitasi input via FormRequest + `spatie/laravel-query-builder` pattern di repository.
- Rate limiting, CORS ketat, logging request ID, audit log menyimpan aktivitas penting.

## Observabilitas

- Endpoint `GET /api/v1/health/live` dan `/ready`.
- Structured logging JSON + `X-Request-Id` header.
- Queue worker dan scheduler siap di profile `.env`.

## Deployment Profiles

- **Development**: `docker-compose.dev.yml` (mysql, redis, mailpit).
- **Staging**: build pipeline men-deploy ke container, auto migrate & seed QA.
- **Production**: build release, migration manual, worker & scheduler terpisah.

## Integrasi

- Ekspor laporan ke CSV/XLSX via `maatwebsite/excel` (opsional) dengan job queue.
- Pengiriman email (verifikasi, reset kata sandi) via `notifications`.
- Websocket (pusher) untuk update lelang real-time (opsional, fase lanjut).

