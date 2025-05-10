@extends('layouts.navbar')
@section('title', 'Beranda')
@section('content')

@php
\Carbon\Carbon::setLocale('id');
@endphp

{{-- Banner --}}
<div class="content-wrapper">
  <div class="container mt-4">
      <img src="{{ asset('ads/baner1.png') }}" class="w-100 rounded banner-fixed" alt="Banner LelangKilat">
  </div>
  
  <div class="container mt-4">
    <div class="row row-cols-6 row-cols-sm-6 row-cols-md-6 g-3">
      @foreach($categories as $cat)
        <div class="col">
          <a href="{{ route('auctions.index',['category'=>$cat['name']]) }}" class="text-decoration-none text-dark">
            <div class="card text-center border-0 shadow h-100 py-3">
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
          <div class="card h-100" style="width: 18rem;">
            @if ($auc->status === 'ACTIVE')
              <span class="label-live">Sedang Berlangsung</span>
            @elseif ($auc->status === 'PENDING')
              <span class="label-live bg-warning text-dark">Menunggu Dimulai</span>
            @elseif ($auc->status === 'CLOSED')
              <span class="label-live bg-secondary">Selesai</span>
            @endif

            <img src="{{ asset($auc->image_path) }}" class="card-img-top fixed-img" alt="Gambar Lelang">

            <div class="card-body">
              <small class="text-muted d-block mb-1">
                Berakhir dalam {{ \Carbon\Carbon::parse($auc->end_time)->diffForHumans(now(), true) }}
              </small>
              <div class="multi-line-title mb-2">{{ $auc->title }}</div>
                @php
                $current = $auc->bids->max('amount') ?? $auc->starting_price;
                @endphp
                <div class="mb-2">
                  <div class="d-flex justify-content-between small">
                    <span class="fw-normal">Bid Awal</span>
                    <span class="fw-normal">Rp{{ number_format($auc->starting_bid, 0, ',', '.') }}</span>
                  </div>
                  <div class="d-flex justify-content-between small">
                    <span class="fw-medium text-success">Bid Sekarang</span>
                    <span class="fw-medium text-success">Rp{{ number_format($auc->current_bid, 0, ',', '.') }}</span>
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
</div>
@endsection
