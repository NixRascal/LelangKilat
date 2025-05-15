@extends('layouts.navbar')

@section('title', 'Daftar Lelang')

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h2>Daftar Lelang</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Awal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($auctions as $auction)
                    <tr>
                        <td>{{ $auction->title }}</td>
                        <td>{{ $auction->category->name ?? '-' }}</td>
                        <td>Rp{{ number_format($auction->starting_bid, 0, ',', '.') }}</td>
                        <td>{{ $auction->status }}</td>
                        <td>
                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-info btn-sm">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada lelang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>
            {{ $auctions->links() }}
        </div>
    </div>
</div>
@endsection 