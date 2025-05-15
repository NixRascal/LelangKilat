@extends('layouts.SideTopBarAdmin')
@section('title', 'Edit Banner')

@section('content')
<div class="container">
    <h3>Edit Banner</h3>
    <img src="{{ asset('storage/' . ltrim($banner->image_path, '/')) }}" width="400" class="mb-3 border">
    <form action="{{ route('admin.banner.single.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Ganti Gambar Banner (opsional)</label>
            <input type="file" name="banner" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('admin.banner.edit') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection 