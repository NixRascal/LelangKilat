<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>
    @yield('title') &middot; {{ config('app.name','Lelang Kilat') }}
  </title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="{{ asset('css/lelangkilat.css') }}">
</head>
<body>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>