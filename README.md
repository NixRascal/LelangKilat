# ⚡ LelangKilat – Aplikasi Lelang Ultra-Cepat Berbasis Laravel

LelangKilat adalah platform lelang berbasis web yang didesain untuk memberikan pengalaman **real-time**, **gamified**, dan **instan** dalam proses pelelangan. Sistem ini dilengkapi dengan fitur dompet digital, keamanan escrow, dan anti-sniping algorithm demi memastikan proses bidding yang adil dan cepat.

---

## 🚀 Fitur Unggulan

- 🎯 Lelang cepat & real-time dengan WebSocket
- 🛡️ Sistem escrow untuk keamanan pembeli & penjual
- 👛 Wallet pengguna untuk mengatur saldo penawaran
- 🔁 Auto-bid dan Anti-sniping system
- 🖥️ Panel Admin CRUD (Users, Auctions, Bids, Payments)
- 📄 Blade Templating yang responsif dan modular

---

## 🧱 Teknologi yang Digunakan

- **Laravel 10+** – PHP Framework MVC
- **MySQL** – Relational Database
- **WebSocket / Laravel Echo** – Real-time communication
- **Laravel Queue** – Job dispatching untuk penawaran
- **Bootstrap 5** – Desain antarmuka pengguna
- **Blade** – Template engine Laravel

---

## 📂 Struktur Database

Proyek ini menggunakan 5 entitas utama:

| Tabel      | Deskripsi                                     |
|------------|-----------------------------------------------|
| users      | Data pengguna (login via NPM, tanpa email)    |
| auctions   | Data barang yang dilelang                     |
| bids       | Data penawaran dari pengguna                  |
| payments   | Transaksi pembayaran lelang                   |
| admins     | Data admin sistem                             |
