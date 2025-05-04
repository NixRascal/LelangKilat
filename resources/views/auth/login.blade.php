@extends('layouts.app')

@section('title', 'Login')

@section('content')
<style>
  body {
    background-color: #f53d2d;
  }
</style>

<div class="row min-vh-100 justify-content-center align-items-center">
  <div class="col-12 col-md-10 d-flex flex-column flex-md-row align-items-center justify-content-between">
    
    {{-- Kiri: Branding --}}
    <div class="text-center text-white mb-5 mb-md-0 w-100 w-md-50">
      <img src="{{ asset('LogoLengkap.png') }}" alt="Lelang Kilat" style="height: 250px;" class="mb-1">
      <h3 class="fw-bold">Selamat Datang di <span style="color: #fff">LelangKilat</span></h3>
      <p class="mb-0">Bidding Lebih Cepat, Lebih Transparan, Lebih Aman</p>
    </div>

    {{-- Kanan: Form Login --}}
    <div class="card shadow-sm p-4 w-100 w-md-50" style="max-width: 400px;">
      <h5 class="text-center mb-4">Masuk</h5>
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            required
            autofocus
          >
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Kata Sandi</label>
          <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            required
          >
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="remember" name="remember">
          <label class="form-check-label" for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-danger w-100">MASUK</button>
      </form>

      <div class="text-center mt-3">
        <small>Belum punya akun? <a href="{{ route('register.form') }}">Daftar</a></small>
      </div>
    </div>
  </div>
</div>
@endsection
