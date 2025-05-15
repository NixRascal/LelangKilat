@extends('layouts.navbar')
@section('title', 'Beranda')
@section('content')

@php
\Carbon\Carbon::setLocale('id');
@endphp

<div class="content-wrapper">
  {{-- Banner Carousel --}}
  <div id="bannerCarousel" class="carousel slide mb-4 container mt-4" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">
      @foreach ($ads as $index => $ad)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
          <img src="{{ Storage::url($ad->image_path) }}" class="d-block w-100 rounded banner-fixed" alt="Banner {{ $index + 1 }}">
        </div>
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  {{-- Kategori --}}
  <div class="container mt-4">
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3">
      @foreach($categories as $cat)
        <div class="col">
          <a href="{{ route('auctions.category', $cat->slug) }}" class="text-decoration-none text-dark">
          {{-- <a href="{{ route('user.search_result', ['category' => $cat['name']]) }}" class="text-decoration-none text-dark"> --}}
            <div class="card text-center border-0 shadow h-100 py-3">
              <img src="{{ $cat['icon_path'] }}" alt="{{ $cat['name'] }}"
                   class="mx-auto mb-2" style="width:55px;height:55px;object-fit:contain;">
              <div class="small fw-medium text-truncate px-2">{{ $cat['name'] }}</div>
            </div>
          </a>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Daftar Lelang --}}
  <div class="container-fluid mt-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      @foreach($auctions as $auc)
        <div class="col">
          <div class="card h-100">
            {{-- status label --}}
            @if ($auc->status === 'ACTIVE')
              <span class="label-live">Sedang Berlangsung</span>
            @elseif ($auc->status === 'PENDING')
              <span class="label-live bg-warning text-dark">Menunggu Dimulai</span>
            @elseif ($auc->status === 'CLOSED')
              <span class="label-live bg-secondary">Selesai</span>
            @endif

            {{-- gambar --}}
            <img src="{{ asset($auc->image_path) }}" class="card-img-top fixed-img" alt="Gambar Lelang">

            {{-- isi kartu --}}
            <div class="card-body">
              {{-- countdown / teks status --}}
              <small class="text-muted d-block mb-1">
                @if ($auc->status === 'PENDING')
                  Dimulai dalam {{ \Carbon\Carbon::parse($auc->start_time)->diffForHumans(\Carbon\Carbon::now(), true) }}
                @elseif ($auc->status === 'ACTIVE')
                  Berakhir dalam {{ \Carbon\Carbon::parse($auc->end_time)->diffForHumans(\Carbon\Carbon::now(), true) }}
                @else
                  Berakhir
                @endif
              </small>

              <div class="multi-line-title mb-2">{{ $auc->title }}</div>

              @php
                $current = $auc->bids->max('amount') ?? $auc->starting_bid;
              @endphp

              <div class="mb-2">
                <div class="d-flex justify-content-between small">
                  <span class="fw-normal">Penawaran Awal</span>
                  <span class="fw-normal">Rp{{ number_format($auc->starting_bid, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                  <span class="fw-medium text-success">Kelipatan Penawaran</span>
                  <span class="fw-medium text-success">Rp{{ number_format($auc->bid_increment, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                  <span class="fw-medium text-success">Penawaran Sekarang</span>
                  <span class="fw-medium text-success">Rp{{ number_format($current, 0, ',', '.') }}</span>
                </div>
              </div>

              <a href="{{ route('auctions.show', $auc) }}" class="btn btn-sm btn-success w-100">
                PASANG TAWARAN
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    {{-- pagination --}}
    <div class="d-flex justify-content-center mt-4">
      {{ $auctions->withQueryString()->links() }}
    </div>
  </div>
</div>
@endsection
