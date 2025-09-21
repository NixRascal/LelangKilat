# Rencana Migrasi Bertahap Frontend → API

## Ringkasan
Migrasi dilakukan dalam tiga fase untuk meminimalkan downtime dan memastikan setiap modul teruji sebelum produksi.

## Fase
1. **Fase 1 – API Paritas (8 jam)**
   - Aktivasi endpoint `/api/v1` paralel dengan Blade lama.
   - Implementasi middleware role & audit log.
   - Risiko: perbedaan validasi. Mitigasi: regression test manual.
2. **Fase 2 – Frontend Hybrid (12 jam)**
   - Deploy aplikasi React berdampingan (sub-path `/app`).
   - Gunakan toggle env `APP_FRONTEND_MODE=hybrid` untuk memilih UI.
   - Risiko: inkonsistensi data. Mitigasi: caching API + monitoring log error.
3. **Fase 3 – Cutover (6 jam)**
   - Alihkan domain utama ke frontend baru.
   - Putuskan route Blade lama kecuali fallback login.
   - Risiko: fallback belum lengkap. Mitigasi: rollback dengan mengaktifkan `APP_FRONTEND_MODE=legacy`.

## Rollback
- Simpan release branch `legacy-ui`.
- Jalankan `php artisan config:set app.frontend_mode=legacy` lalu `php artisan config:cache`.
- Kembalikan DNS ke server lama jika terjadi kegagalan besar.

## Kebutuhan QA
- Gunakan seed `QaSeeder`.
- Uji 3 skenario end-to-end: (1) lelang sukses, (2) bid ditolak karena saldo, (3) pembatalan lelang oleh admin.

## Monitoring
- Pantau `storage/logs/laravel.log` untuk error 4xx/5xx.
- Gunakan header `X-Request-Id` untuk korelasi log frontend-backend.
