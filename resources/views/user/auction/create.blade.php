@extends('layouts.navbar')

@section('title', 'Buat Lelang')

@section('content')
<div class="content-wrapper">
    <div class="container">
        <h2>Buat Lelang Baru</h2>
        <form action="{{ route('auctions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="title" name="item_name" required>
            </div>
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="starting_bid" class="form-label">Harga Awal</label>
                <input type="number" class="form-control" id="starting_bid" name="start_price" required>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Tanggal Mulai</label>
                <input type="datetime-local" class="form-control" id="start_time" name="start_date" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Durasi Lelang</label>
                <div class="row g-2">
                    <div class="col-4">
                        <input type="number" class="form-control" name="duration_days" min="0" placeholder="Hari" value="0">
                    </div>
                    <div class="col-4">
                        <input type="number" class="form-control" name="duration_hours" min="0" max="23" placeholder="Jam" value="0">
                    </div>
                    <div class="col-4">
                        <input type="number" class="form-control" name="duration_minutes" min="0" max="59" placeholder="Menit" value="0">
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="image_path" class="form-label">Foto Barang</label>
                <input type="file" class="form-control" id="image_path" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Buat Lelang</button>
        </form>
    </div>
</div>
@endsection
