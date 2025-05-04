@extends('layouts.app')

@section('title', 'Register')

@section('content')
<style>
  body {
    background-color: #f53d2d;
  }
</style>

<div class="row min-vh-100 justify-content-center align-items-center">
  <div class="col-12 col-md-10 d-flex flex-column flex-md-row align-items-center justify-content-between">
    
    <div class="text-center text-white mb-5 mb-md-0 w-100 w-md-50">
      <img src="{{ asset('LogoLengkap.png') }}" alt="Lelang Kilat" style="height: 250px;" class="mb-1">
      <h3 class="fw-bold">Selamat Datang di <span style="color: #fff">LelangKilat</span></h3>
      <p class="mb-0">Bidding Lebih Cepat, Lebih Transparan, Lebih Aman</p>
    </div>

    <div class="card shadow-sm p-4 w-100 w-md-50" style="max-width: 400px;">
      <h5 class="text-center mb-4">Daftar</h5>
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" id="name" name="name" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Kata Sandi</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="mb-4">
          <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
          <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">DAFTAR</button>
      </form>

      <div class="text-center mt-3">
        <small>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></small>
      </div>
    </div>
  </div>
</div>
@endsection
