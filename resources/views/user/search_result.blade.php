@extends('layouts.navbar') {{-- Pastikan ini hanya navbar, tanpa banner/kategori --}}

@section('title', 'Hasil Pencarian')

@section('content')
<div class="content-wrapper">
    <h4 class="mt-3 mb-3">Hasil Pencarian "{{ request('search') }}"</h4>

    @if($auctions->isEmpty())
        <div class="alert alert-warning">Barang tidak ditemukan.</div>
    @else
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

                        {{-- image --}}
                        <img src="{{ asset($auc->image_path) }}" class="card-img-top fixed-img" alt="Gambar Lelang">

                        {{-- card body --}}
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
                                    <span class="fw-normal">Penawaran Awal</span>
                                    <span class="fw-normal">Rp{{ number_format($auc->starting_bid, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="fw-medium text-success">Kelipatan Penawaran</span>
                                    <span class="fw-medium text-success">Rp{{ number_format($auc->bid_increment, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="fw-medium text-success">Penawaran Sekarang</span>
                                    <span class="fw-medium text-success">Rp{{ number_format($auc->current_bid, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <a href="{{ route('auctions.show', $auc) }}" class="btn btn-sm btn-success w-100">OPEN BIDDING</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection