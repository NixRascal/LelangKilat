@extends('layouts.SideTopBarAdmin')
@section('title', 'Edit Banner User')

@section('content')
<div class="container">
    <h3>Edit Banner Halaman User</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banner.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Banner Saat Ini:</label><br>
            <div class="row">
                @forelse($banners as $banner)
                    <div class="col-md-4 mb-2">
                        <img src="{{ Str::startsWith($banner->image_path, 'storage/') ? asset($banner->image_path) : asset('storage/'.$banner->image_path) }}" width="300" class="mb-2 border">
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.banner.single.edit', $banner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.banner.delete', $banner->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada banner.</p>
                @endforelse
            </div>
        </div>
    </form>
    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Upload Banner Baru</label>
            <input type="file" name="banner" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah Banner</button>
    </form>
</div>
@endsection 