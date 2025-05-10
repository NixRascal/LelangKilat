@extends('layouts.SideTopBarAdmin')
@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid">
    <h3>Daftar Lelang</h3>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Pemilik</th>
                <th>Judul</th>
                <th>Bid Awal</th>
                <th>Bid Sekarang</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auctions as $index => $auction )
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $auction->owner->name }}</td>
                    <td>{{ $auction->title }}</td>
                    <td>{{ $auction->starting_bid }}</td>
                    <td>{{ $auction->current_bid }}</td>
                    <td>{{ $auction->start_time }}</td>
                    <td>{{ $auction->end_time }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('admin.auction.edit', $auction->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.auction.destroy', $auction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin Ingin Menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection