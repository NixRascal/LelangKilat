@extends('layouts.SideTopBarAdmin')
@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid">
    <h3>Daftar Akun Admin</h3>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{session('success')}}
        </div>
    @endif
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-3">Tambah Akun Admin</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Daftar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($admins as $index => $admins )
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $admins->name }}</td>
                    <td>{{ $admins->email }}</td>
                    <td>{{ $admins->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-center">
                            <a href="{{ route('admin.admins.edit', $admins->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.admins.destroy', $admins->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin Ingin Menghapus?')">
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