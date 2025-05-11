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

<body class="d-flex flex-column min-vh-100">
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg fixed-top py-3" style="background-color: #f53d2d;">
    <div class="container-xl">  
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        <img src="{{ asset('LogoOnlyPutih.png') }}" alt="Logo" height="45" class="me-2">
        <span class="fw-bold fs-4 text-white">LelangKilat</span>
      </a>

      {{-- Search --}}
      <form class="d-flex mx-auto" style="max-width: 700px; width: 100%;" action="{{ route('search') }}" method="GET">
        <input class="form-control me-2" type="search" name="search" placeholder="Cari barang lelang..." value="{{ request('search') }}">
        <button class="btn btn-light" type="submit">Cari</button>
      </form>

      <ul class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
        @auth
          {{-- Tombol Wallet --}}
          <li class="nav-item dropdown" onmouseover="this.classList.add('show')" onmouseout="this.classList.remove('show')">
            <div class="nav-link p-0" id="dropdownWallet" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="{{ asset('icons/wallet.png') }}" alt="Wallet" height="35">
            </div>
            <ul class="dropdown-menu dropdown-menu-end large-wallet-dropdown" aria-labelledby="dropdownWallet">
              <li class="dropdown-item fw-bold fs-6">💰 Saldo Anda: Rp{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</li>
              <li class="dropdown-item text-danger fw-semibold fs-6">❗Saldo Ditahan: Rp{{ number_format(Auth::user()->wallet->reserved_balance ?? 0, 0, ',', '.') }}</li>
            </ul>
          </li>
      
          {{-- Tombol Buat Lelang --}}
          <li class="nav-item">
            <a class="nav-link p-0" href="{{ route('auctions.create') }}" title="Buat Lelang">
              <img src="{{ asset('icons/buatLelang.png') }}" alt="Buat Lelang" height="35">
            </a>
          </li>
      
          {{-- Dropdown Tombol Lelang --}}
          <li class="nav-item dropdown">
            <a class="nav-link p-0 dropdown-toggle" href="#" id="dropdownLelang" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="{{ asset('icons/lelang.png') }}" alt="Lelang" height="35">
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLelang">
              <li><a class="dropdown-item" href="{{ route('auctions.participated') }}">Lelang yang Diikuti</a></li>
              <li><a class="dropdown-item" href="{{ route('auctions.mine') }}">Lelang Saya</a></li>
            </ul>
          </li>
      
          {{-- Dropdown Profil --}}
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle p-0" href="#" id="dropdownProfil" data-bs-toggle="dropdown" aria-expanded="false">
              @if(Auth::user()->profile_photo)
                <img src="{{ asset(Auth::user()->profile_photo) }}" class="rounded-circle" height="40" alt="Avatar">
              @else
                <img src="https://ui-avatars.com/api/?bold=true&uppercase=true&background=fff&color=f53d2d&name={{ urlencode(Auth::user()->name) }}" class="rounded-circle" height="40" alt="Avatar">
              @endif
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="#">Pengaturan Profil</a></li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="{{ route('logout') }}" method="POST">@csrf
                  <button class="dropdown-item text-danger" type="submit">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @endauth
      
        @guest
          <li class="nav-item">
            <a href="{{ route('login.form') }}" class="btn btn-light text-primary fw-semibold">Login</a>
          </li>
        @endguest
      </ul>      
    </div>
  </nav>

  {{-- Konten --}}
  <main class="flex-fill container mt-4">
    @yield('content')
  </main>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
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
          <li><a href="{{ url('/home') }}" class="text-dark text-decoration-none">Beranda</a></li>
          <li><a href="{{ route('login.form') }}" class="text-dark text-decoration-none">Masuk</a></li>
          <li><a href="{{ route('register.form') }}" class="text-dark text-decoration-none">Daftar</a></li>
          <li><a href="#" class="text-dark text-decoration-none">Tentang Kami</a></li>
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
</html>