@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<style>
  .product-card img {
    height: 160px;
    object-fit: cover;
  }

  .label-live {
    position: absolute;
    top: 10px;
    left: 10px;
    background: red;
    color: white;
    font-weight: bold;
    font-size: 12px;
    padding: 4px 8px;
    border-radius: 4px;
  }

  .dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0;
  }

  .large-wallet-dropdown {
    min-width: 290px;
    padding: 10px 15px;
  }

  .large-wallet-dropdown .dropdown-item {
    padding: 10px 15px;
  }

  .multi-line-title {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 17px;
    line-height: 1.3;
    height: 2.6em;
  }

  .banner-fixed {
  height: 250px;
  object-fit: cover;
  object-position: center;
}

</style>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3">
  <div class="container-fluid px-4">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('LogoOnlyPutih.png') }}" alt="Logo" height="45" class="me-2">
      <span class="fw-bold fs-4 text-danger">LelangKilat</span>
    </a>
    <form class="d-flex mx-auto" style="max-width: 700px; width: 100%;">
      <input class="form-control me-2" type="search" placeholder="Cari barang lelang...">
      <button class="btn btn-danger" type="submit">Cari</button>
    </form>
    <ul class="navbar-nav ms-auto d-flex flex-row align-items-center gap-3">
      <li class="nav-item dropdown" onmouseover="this.classList.add('show')" onmouseout="this.classList.remove('show')">
        <div class="nav-link p-0" id="dropdownWallet" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ asset('icons/wallet.png') }}" alt="Wallet" height="35">
        </div>
        <ul class="dropdown-menu dropdown-menu-end large-wallet-dropdown" aria-labelledby="dropdownWallet">
          <li class="dropdown-item fw-bold fs-6">💰 Saldo Anda: Rp{{ number_format($user->wallet->balance ?? 0, 0, ',', '.') }}</li>
          <li class="dropdown-item text-danger fw-semibold fs-6">❗Saldo Ditahan: Rp{{ number_format($user->wallet->reserved_balance ?? 0, 0, ',', '.') }}</li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link p-0" href="#">
          <img src="{{ asset('icons/lelang.png') }}" alt="Lelang Diikuti" height="35">
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle p-0" href="#" id="dropdownProfil" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" class="rounded-circle" height="40" alt="Avatar">
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
    </ul>
  </div>
</nav>

{{-- Banner --}}
<div class="container mt-4">
    <img src="{{ asset('ads/baner1.png') }}" class="w-100 rounded banner-fixed" alt="Banner LelangKilat">
</div>
  
  <div class="container mt-4">
    <div class="row row-cols-6 row-cols-sm-6 row-cols-md-6 g-3">
      @foreach($categories as $cat)
        <div class="col">
          <a href="{{ route('auctions.index',['category'=>$cat['name']]) }}" class="text-decoration-none text-dark">
            <div class="card text-center border-0 shadow-sm h-100 py-3">
              <img src="{{$cat['icon_path']}}" alt="{{ $cat['name'] }}" class="mx-auto mb-2" style="width:55px;height:55px;object-fit:contain;">
              <div class="small fw-medium text-truncate px-2">
                {{ $cat['name'] }}
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>  
  
  {{-- Daftar Lelang --}}
  <div class="container mt-4">
    <div class="row">
      @foreach($auctions as $auc)
        <div class="col-md-3 mb-4">
          <div class="card product-card position-relative h-100">
            <span class="label-live">LIVE</span>
              <img src="{{ asset($auc->coverImage->image_path) }}" class="card-img-top">

            <div class="card-body">
              <small class="text-muted d-block mb-1">
                Berakhir {{ \Carbon\Carbon::parse($auc->end_time)->diffForHumans(now(), true) }}
              </small>
              <div class="multi-line-title">{{ $auc->title }}</div>
              @php
                $current = $auc->bids->max('amount') ?? $auc->starting_price;
              @endphp
              <div class="mb-2">
                <div class="d-flex justify-content-between small">
                  <span class="text-muted">Bid Awal</span>
                  <span class="text-muted">Rp{{ number_format($auc->starting_price,0,',','.') }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                  <span class="fw-semibold">Bid Sekarang</span>
                  <span class="fw-semibold text-success">Rp{{ number_format($current,0,',','.') }}</span>
                </div>
              </div>
  
              <a href="{{ route('auctions.show',$auc) }}" class="btn btn-sm btn-success w-100">OPEN BIDDING</a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  
    {{-- pagination --}}
    <div class="d-flex justify-content-center">
      {{ $auctions->withQueryString()->links() }}
    </div>
  </div>  
@endsection
