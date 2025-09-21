# Checklist QA LelangKilat

## Autentikasi
- [ ] Login admin berhasil, token tersimpan.
- [ ] Logout menghapus token & redirect ke login.
- [ ] Refresh token bekerja setelah token kedaluwarsa (simulasi manual).
- [ ] Reset kata sandi mengubah kredensial.

## Dashboard
- [ ] KPI tampil dengan data sesuai seed.
- [ ] Grafik tren menampilkan 14 hari terakhir.
- [ ] Tugas terbaru muncul sesuai lelang baru.

## Master Data
- [ ] Admin dapat membuat, mengubah, menghapus pengguna.
- [ ] Staff/User tidak bisa mengakses endpoint admin (harus 403).

## Lelang
- [ ] Membuat lelang baru berhasil.
- [ ] Pengguna lain dapat bid lebih tinggi.
- [ ] Bid lebih rendah ditolak dengan pesan validasi.
- [ ] Status lelang berubah otomatis setelah waktu habis (jalankan scheduler/manual).

## Dompet
- [ ] Top up saldo menambah balance dan membuat transaksi.
- [ ] Deduksi saldo saat bid (simulasikan dengan manual update).

## Pelaporan
- [ ] Ekspor CSV menghasilkan file dengan kolom sesuai spesifikasi.
- [ ] File dapat dibuka di Excel/Numbers.

## Pengaturan
- [ ] Mengubah preferensi tema tersimpan dan diterapkan.

## Audit Log
- [ ] Setiap aksi (login, CRUD) muncul di audit log.
- [ ] Filter pencarian berfungsi (uji query parameter `module` & `action`).

## Observabilitas
- [ ] `/api/v1/health/live` mengembalikan status ok.
- [ ] `/api/v1/health/ready` mengembalikan status ready setelah DB & Redis aktif.

## Kinerja
- [ ] Endpoint `/api/v1/auctions` tanpa filter merespon < 300ms di staging.
- [ ] LCP halaman dashboard < 2.5s di koneksi 4G (gunakan Lighthouse).
