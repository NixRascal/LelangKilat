@extends('layouts.navbar')
@section('title', 'Edit Lelang')

@section('content')
<div class="content-wrapper">
    <div class="container py-4">
        <h1>Edit Lelang</h1>
        <form action="{{ route('user.auction.update', $auction->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $auction->title) }}" required>
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description', $auction->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label>Harga Awal</label>
                <input type="number" name="starting_bid" class="form-control"
                    value="{{ old('starting_bid', $auction->starting_bid) }}"
                    {{ $auction->current_bid > $auction->starting_bid ? 'readonly' : '' }}>
                @if ($auction->current_bid > $auction->starting_bid)
                    <small class="text-danger">Harga awal tidak bisa diubah karena sudah ada penawaran.</small>
                @endif
            </div>

            <div class="mb-3">
                <label>Tanggal Mulai</label>
                <input type="datetime-local" name="start_time" class="form-control"
                    value="{{ old('start_time', \Carbon\Carbon::parse($auction->start_time)->format('Y-m-d\TH:i')) }}" required>
            </div>

            <div class="mb-3">
                <label>Durasi Lelang</label>
                <div class="row">
                    @php
                        $start = \Carbon\Carbon::parse($auction->start_time);
                        $end = \Carbon\Carbon::parse($auction->end_time);
                        $diff = $start->diff($end);
                        $days = old('duration_days', $diff->d);
                        $hours = old('duration_hours', $diff->h);
                        $minutes = old('duration_minutes', $diff->i);
                    @endphp
                    <div class="col">
                        <input type="number" name="duration_days" class="form-control" min="0" placeholder="Hari" value="{{ $days }}">
                    </div>
                    <div class="col">
                        <input type="number" name="duration_hours" class="form-control" min="0" max="23" placeholder="Jam" value="{{ $hours }}">
                    </div>
                    <div class="col">
                        <input type="number" name="duration_minutes" class="form-control" min="0" max="59" placeholder="Menit" value="{{ $minutes }}">
                    </div>
                </div>
                <small class="form-text text-muted">Isi durasi lelang dalam hari, jam, dan menit.</small>
            </div>

            <div class="mb-3">
                <label>Gambar Lelang</label><br>
                @if ($auction->image_path)
                    <img src="{{ asset($auction->image_path) }}" width="150" class="mb-2">
                @endif
                <input type="file" name="image" class="form-control">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
            </div>

            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection 