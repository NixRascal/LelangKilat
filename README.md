# ⚡ LelangKilat – Aplikasi Lelang Ultra-Cepat Berbasis Laravel
LelangKilat adalah platform lelang real-time berbasis Laravel yang dirancang untuk menciptakan pengalaman kompetitif, adil, dan instan bagi pengguna kampus maupun publik. Dengan integrasi WebSocket dan sistem antrian (queue), aplikasi ini memungkinkan pengguna untuk melakukan penawaran (bid) secara cepat dan aman.

🚀 Fitur Unggulan
🎯 Lelang Real-Time — Sistem penawaran cepat berbasis WebSocket, anti-sniping & auto-bid.
👨‍💼 Manajemen Admin — Kelola pengguna, lelang, tawaran, dan pembayaran dengan mudah.
💸 Sistem Dompet (Wallet) — Setiap pengguna memiliki dompet digital untuk mengatur saldo penawaran.
🔐 Mekanisme Escrow — Dana tertahan otomatis hingga lelang selesai demi keamanan kedua belah pihak.
🖥️ Panel CRUD Lengkap — Kelola semua entitas melalui antarmuka Blade yang elegan dan responsif.

🛠️ Teknologi yang Digunakan
Laravel 10+ (MVC Framework)
MySQL (Relational Database)
Blade Templating Engine
WebSocket (Real-time bidding)
Laravel Queue (Job Dispatching)
Bootstrap 5 (Frontend UI)

📁 Struktur Database (via Migration & Seeder)
Pengguna (users) – login via NPM (tanpa email)
Lelang (auctions) – informasi barang & waktu
Tawaran (bids) – sistem bidding real-time
Pembayaran (payments) – pencatatan transaksi akhir
Admin – kontrol penuh terhadap sistem
Seeder sudah disediakan untuk masing-masing entitas guna mendukung data awal pengujian.