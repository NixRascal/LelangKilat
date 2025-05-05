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
  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg fixed-top py-3" style="background-color: #f53d2d;">
    <div class="container-xl">  
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        <img src="{{ asset('LogoOnlyPutih.png') }}" alt="Logo" height="45" class="me-2">
        <span class="fw-bold fs-4 text-white">LelangKilat</span>
      </a>

      {{-- Search --}}
      <form class="d-flex mx-auto" style="max-width: 700px; width: 100%;">
        <input class="form-control me-2" type="search" placeholder="Cari barang lelang...">
        <button class="btn btn-light" type="submit">Cari</button>
      </form>

        <ul class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
          @if(Auth::check())
        
            {{-- Tombol Wallet (1) --}}
            <li class="nav-item dropdown" onmouseover="this.classList.add('show')" onmouseout="this.classList.remove('show')">
              <div class="nav-link p-0" id="dropdownWallet" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('icons/wallet.png') }}" alt="Wallet" height="35">
              </div>
              <ul class="dropdown-menu dropdown-menu-end large-wallet-dropdown" aria-labelledby="dropdownWallet">
                <li class="dropdown-item fw-bold fs-6">💰 Saldo Anda: Rp{{ number_format(Auth::user()->wallet->balance ?? 0, 0, ',', '.') }}</li>
                <li class="dropdown-item text-danger fw-semibold fs-6">❗Saldo Ditahan: Rp{{ number_format(Auth::user()->wallet->reserved_balance ?? 0, 0, ',', '.') }}</li>
              </ul>
            </li>
        
            {{-- Tombol Buat Lelang (2) --}}
            <li class="nav-item">
              <a class="nav-link p-0" href="{{ route('auctions.create') }}" title="Buat Lelang">
                <img src="{{ asset('icons/buatLelang.png') }}" alt="Buat Lelang" height="35">
              </a>
            </li>
        
            {{-- Dropdown Tombol Lelang (3) --}}
            <li class="nav-item dropdown">
              <a class="nav-link p-0 dropdown-toggle" href="#" id="dropdownLelang" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('icons/lelang.png') }}" alt="Lelang" height="35">
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownLelang">
                <li><a class="dropdown-item" href="{{ route('auctions.participated') }}">Lelang yang Diikuti</a></li>
                <li><a class="dropdown-item" href="{{ route('auctions.mine') }}">Lelang Saya</a></li>
              </ul>
            </li>
        
            {{-- Dropdown Profil (4) --}}
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle p-0" href="#" id="dropdownProfil" data-bs-toggle="dropdown" aria-expanded="false">
                @if(Auth::user()->profile_photo)
                  <img src="{{ asset(Auth::user()->profile_photo) }}" class="rounded-circle" height="40" alt="Avatar">
                @else
                  <img src="https://ui-avatars.com/api/?bold=true&uppercase=true&background=fff&color=f53d2d&name={{ urlencode(Auth::user()->name) }}" class="rounded-circle" height="40" alt="Avatar">
                @endif
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownProfil">
                <li><a class="dropdown-item" href="#">Pengaturan Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="{{ route('logout') }}" method="POST">@csrf
                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                  </form>
                </li>
              </ul>
            </li>
          </li>
        @endif
      </ul>
    </div>
  </nav>

  {{-- Konten --}}
  <div class="container mt-4">
    @yield('content')
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
  ></script>
</body>
</html>
