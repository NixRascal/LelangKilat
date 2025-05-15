@extends('layouts.navbar')
@section('title', 'Detail Partisipasi Lelang')

@section('content')
<div class="content-wrapper">
    <div class="container py-4">
        <h1 class="mb-3">Detail Partisipasi Anda</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h4>{{ $auction->title }}</h4>
                <p>{{ $auction->description }}</p>
                <p><strong>Kategori:</strong> {{ $auction->category->name ?? '-' }}</p>
                <p><strong>Harga Awal:</strong> Rp{{ number_format($auction->starting_bid, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $auction->status }}</p>
            </div>
        </div>
        <h5>Riwayat Penawaran Anda</h5>
        <ul class="list-group mb-4">
            @forelse($userBids as $bid)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $bid->created_at->format('d M Y H:i') }}</span>
                    <span>Rp{{ number_format($bid->amount, 0, ',', '.') }}</span>
                </li>
            @empty
                <li class="list-group-item text-muted">Anda belum pernah menawar pada lelang ini.</li>
            @endforelse
        </ul>
        <a href="{{ route('auctions.participated') }}" class="btn btn-secondary">Kembali ke Lelang yang Diikuti</a>
    </div>
</div>
@endsection 