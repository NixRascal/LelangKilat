<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @yield('title') &middot; {{ config('app.name','Lelang Kilat') }}
  </title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="{{ asset('css/lelangkilat.css') }}">
</head>

<body>
</body>
<footer class="bg-light mt-5 border-top" style="width: 100%">
    <div class="container py-4">
      <div class="row">
        <!-- Tentang -->
        <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
          <h5 class="text-uppercase fw-bold">LelangKilat</h5>
          <p>
            Platform lelang terpercaya dan cepat. Temukan barang impianmu dengan harga terbaik!
          </p>
        </div>
  
        <!-- Navigasi -->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h6 class="text-uppercase">Menu</h6>
          <ul class="list-unstyled mb-0">
            <li><a href="{{ url('/home') }}" class="text-white text-decoration-none">Beranda</a></li>
            <li><a href="{{ route('login.form') }}" class="text-white text-decoration-none">Masuk</a></li>
            <li><a href="{{ route('register.form') }}" class="text-white text-decoration-none">Daftar</a></li>
            <li><a href="#" class="text-white text-decoration-none">Tentang Kami</a></li>
          </ul>
        </div>
  
        <!-- Kontak -->
        <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
          <h6 class="text-uppercase">Kontak</h6>
          <p class="mb-0">Email: support@lelangkilat.com</p>
          <p>WhatsApp: 0822-1234-5678</p>
        </div>
      </div>
    </div>
  
    <div class="text-center py-2" style="background-color: #d73825;">
      © {{ now()->year }} LelangKilat. All rights reserved.
    </div>
  </footer>
  
  <div class="container mt-4">
    @yield('content')
  </div>