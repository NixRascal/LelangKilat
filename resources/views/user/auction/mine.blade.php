@extends('layouts.navbar')
@section('title', 'Lelang Saya')

@section('content')
<div class="content-wrapper">
    <div class="container py-4">
        <h1 class="mb-4">Lelang Saya</h1>
        <div class="row">
            @forelse($auctions as $auction)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($auction->image_path)
                            <img src="{{ asset($auction->image_path) }}" class="card-img-top" alt="{{ $auction->title }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->title }}</h5>
                            <p class="card-text">{{ $auction->description }}</p>
                            <p class="mb-1"><strong>Harga Saat Ini:</strong> Rp {{ number_format($auction->current_bid ?? $auction->starting_bid, 0, ',', '.') }}</p>
                            <a href="{{ route('user.auction.edit', $auction->id) }}" class="btn btn-primary btn-block">Edit Lelang</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada lelang.</p>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $auctions->links() }}
        </div>
    </div>
</div>
@endsection 