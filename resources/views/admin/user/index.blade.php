@extends('layouts.SideTopBar')
@section('title', 'Data Pengguna')

@section('content')
<div class="container-fluid">
    <h3>Daftar Pengguna</h3>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Saldo Wallet</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user )
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ number_format($user->wallet->balance ?? 0 ) }}</td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection