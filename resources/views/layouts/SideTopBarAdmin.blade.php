<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title') &middot; {{ config('app.name', 'Lelang Kilat') }}</title>
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/lelangkilat.css') }}">
</head>
<body>

  <!-- ✅ TOPBAR: Full-width -->
  <nav class="navbar navbar-dark bg-dark px-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <span class="navbar-text text-white">Helo, {{ Auth::user()->name }}</span>
      <div class="dropdown">
        <a class="nav-link dropdown-toggle p-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ asset(Auth::user()->profile_photo ?? 'default.jpg') }}" class="rounded-circle" height="40" alt="Avatar">
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Pengaturan Profil</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form action="{{ route('logout') }}" method="POST">@csrf
              <button class="dropdown-item text-danger">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ✅ KONTEN UTAMA -->
  <div class="container-fluid">
    <div class="row min-vh-100">
      
      <!-- SIDEBAR -->
      <nav class="col-md-2 bg-dark text-white sidebar py-4">
        <div class="text-center mb-4">
          <img src="{{ asset('LogoOnlyPutih.png') }}" style="height: 60px;">
        </div>
        <ul class="nav flex-column px-2">
          <li class="mb-3"><a class="nav-link text-white d-flex align-items-center gap-2" href="/admin/dashboard"><img src="{{ asset('icons/dashboard.png') }}" width="24">Dashboard</a></li>
          <li class="mb-3"><a class="nav-link text-white d-flex align-items-center gap-2" href="/admin/pengguna"><img src="{{ asset('icons/user.png') }}" width="24">Pengguna</a></li>
          <li class="mb-3"><a class="nav-link text-white d-flex align-items-center gap-2" href="/admin/lelang"><img src="{{ asset('icons/lelang.png') }}" width="24">Lelang</a></li>
          <li class="mb-3"><a class="nav-link text-white d-flex align-items-center gap-2" href="/admin/akunadmin"><img src="{{ asset('icons/admin.png') }}" width="24">Admin</a></li>
          <li class="mb-3"><a class="nav-link text-white d-flex align-items-center gap-2" href="{{ route('admin.banner.edit') }}"><img src="{{ asset('icons/banner.png') }}" width="24">Banner</a></li>
        </ul>
      </nav>

      <!-- KONTEN -->
      <main class="col-md-10 p-4">
        @yield('content')
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
