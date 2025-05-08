@extends('layouts.SideTopBar')
@section('title', 'Edit Lelang')

@section('content')
<div class="container">
    <h3>Edit Data Lelang</h3>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('auctions.update', $auction->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" value="{{ $auction->title }}" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control">{{ $auction->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Harga Awal</label>
            <input type="number" name="starting_bid" class="form-control"
                value="{{ $auction->starting_bid }}"
                {{ $auction->current_bid > $auction->starting_bid ? 'readonly' : '' }}>

            @if ($auction->current_bid > $auction->starting_bid)
                <small class="text-danger">Harga awal tidak bisa diubah karena sudah ada penawaran.</small>
            @endif
        </div>

        <div class="mb-3">
            <label>Tanggal Selesai</label>
            <input type="datetime-local" name="end_time" class="form-control"
                value="{{ \Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label>Gambar Lelang</label><br>
            @if ($auction->image_path)
                <img src="{{ asset($auction->image_path) }}" width="150" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>
            

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
