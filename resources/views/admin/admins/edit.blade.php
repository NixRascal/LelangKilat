@extends('layouts.SideTopBarAdmin')
@section('title', 'Edit Pengguna')

@section('content')
<div class="container">
    <h3>Edit Data Akun Admin</h3>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.admins.update', $admins->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $admins->email }}" readonly>
            <small class="text-danger">Email tidak bisa diubah.</small>
        </div>

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $admins->name }}" required>
        </div>

        <div class="mb-3">
            <label for="password">Password Baru</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
            </div>
            <small class="form-text text-muted">Isi jika ingin mengganti password.</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
