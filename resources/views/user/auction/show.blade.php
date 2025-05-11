@extends('layouts.navbar')
@section('title', $auction->title)

@section('content')
@php
  // Locale
  \Carbon\Carbon::setLocale('id');

  // Hitung penawaran tertinggi
  $highestBid       = $auction->bids->max('amount') ?? $auction->starting_bid;
  $highestBidder    = optional(
    $auction->bids()
            ->where('amount', $highestBid)
            ->latest()
            ->first()
  )->user;

  // Tentukan state berdasarkan waktu
  $now              = \Carbon\Carbon::now();
  $start            = \Carbon\Carbon::parse($auction->start_time);
  $end              = \Carbon\Carbon::parse($auction->end_time);

  if ($now->lt($start)) {
    $state = 'PENDING';
  } elseif ($now->between($start, $end)) {
    $state = 'ACTIVE';
  } else {
    $state = 'CLOSED';
  }
@endphp

<div class="content-wrapper">
  <div class="container my-5 border rounded p-4">
    <div class="row justify-content-center align-items-start">

      {{-- Gambar Produk --}}
      <div class="col-md-5 mb-1">
        <div class="border rounded p-1">
          <img src="{{ asset($auction->image_path) }}"
               alt="Foto Lelang"
               class="img-fluid w-100"
               style="object-fit: contain;">
        </div>
      </div>

      {{-- Informasi Lelang --}}
      <div class="col-md-7">
        <h4 class="mb-3">{{ $auction->title }}</h4>

        {{-- Status --}}
        @if($state === 'PENDING')
          <span class="badge bg-warning text-dark mb-1">Menunggu Dimulai</span>
        @elseif($state === 'ACTIVE')
          <span class="badge bg-success mb-1">Sedang Berlangsung</span>
        @else
          <span class="badge bg-secondary mb-1">Selesai</span>
        @endif

        {{-- Countdown / teks waktu --}}
        <p class="text-muted mb-1">
          @if($state === 'PENDING')
            Dimulai dalam <span id="countdown">memuat...</span>
          @elseif($state === 'ACTIVE')
            Berakhir dalam <span id="countdown">memuat...</span>
          @else
            Berakhir
          @endif
        </p>

        <p class="text-muted mb-1">
          Dilelang oleh:
          <strong>{{ optional($auction->owner)->name ?? 'Tidak diketahui' }}</strong>
        </p>
        <p class="text-muted mb-1">
          Kategori:
          <span class="badge bg-secondary">{{ $auction->category->name }}</span>
        </p>

        {{-- Tabel ringkasan --}}
        <table class="table table-borderless w-100 mt-2">
          <tr>
            <td>Penawaran Awal</td>
            <td class="text-end">
              Rp{{ number_format($auction->starting_bid, 0, ',', '.') }}
            </td>
          </tr>
          <tr>
            <td>Kelipatan Penawaran</td>
            <td class="text-end text-success">
              Rp{{ number_format($auction->bid_increment, 0, ',', '.') }}
            </td>
          </tr>
          <tr>
            <td>Penawaran Sekarang</td>
            <td class="text-end fw-semibold text-success">
              Rp{{ number_format($auction->current_bid ?? $auction->starting_bid, 0, ',', '.') }}
            </td>
          </tr>
          <tr>
            <td>Penawar Tertinggi</td>
            <td class="text-end">
              {{ $highestBidder?->name ?? '-' }}
            </td>
          </tr>
        </table>

        {{-- Tombol tawar hanya bila ACTIVE --}}
        @auth
          @if($state === 'ACTIVE')
            @if ($auction->highest_bidder_id === Auth::id())
              <div class="alert alert-info">
                Kamu adalah penawar tertinggi saat ini.
              </div>
            @else
              <form action="{{ route('bid.place', $auction->id) }}"
                    method="POST"
                    class="mt-4">
                @csrf
                <input type="hidden"
                       name="amount"
                       value="{{ $auction->current_bid + $auction->bid_increment }}">
                <button type="submit"
                        class="btn btn-primary w-100">
                  Pasang Penawaran
                </button>
              </form>
            @endif
          @else
            <button class="btn btn-secondary w-100 mt-4" disabled>
              {{ $state === 'PENDING' ? 'Belum Dimulai' : 'Lelang Selesai' }}
            </button>
          @endif
        @else
          <a href="{{ route('login.form') }}"
             class="btn btn-outline-primary mt-4 w-100">
            Login untuk ikut menawar
          </a>
        @endauth

      </div>
    </div>

    {{-- Deskripsi Barang --}}
    <div class="row mt-5">
      <div class="col-md-12">
        <h5>Deskripsi Barang</h5>
        <p>{{ $auction->description }}</p>
      </div>
    </div>

    {{-- Riwayat Penawaran --}}
    <div class="row mt-4">
      <div class="col-md-12">
        <h5>Riwayat Penawaran</h5>
        <ul class="list-group">
          @forelse($auction->bids->sortByDesc('created_at') as $bid)
            <li class="list-group-item d-flex justify-content-between">
              <span>{{ $bid->user->name }}</span>
              <span>Rp{{ number_format($bid->amount, 0, ',', '.') }}</span>
            </li>
          @empty
            <li class="list-group-item text-muted">
              Belum ada penawaran.
            </li>
          @endforelse
        </ul>
      </div>
    </div>

  </div>
</div>

{{-- Countdown Script --}}
<script>
  const state       = "{{ $state }}";
  const countdownEl = document.getElementById('countdown');

  @if($state !== 'CLOSED')
    // Tentukan target waktu: start_time jika pending, end_time jika active
    const targetTime = new Date("{{ $state === 'PENDING'
      ? $start->format('Y-m-d\\TH:i:s')
      : $end->format('Y-m-d\\TH:i:s')
    }}").getTime();

    const interval = setInterval(() => {
      const now  = Date.now();
      const diff = targetTime - now;

      if (diff <= 0) {
        clearInterval(interval);
        countdownEl.innerText = state === 'PENDING'
          ? 'Dimulai'
          : 'Waktu Habis';
      } else {
        const sec  = Math.floor(diff / 1000);
        const min  = Math.floor(sec / 60);
        const hrs  = Math.floor(min / 60);
        const days = Math.floor(hrs / 24);

        const rHrs  = hrs % 24;
        const rMin  = min % 60;
        const rSec  = sec % 60;

        countdownEl.innerText =
          `${days}hr ${rHrs}j ${rMin}m ${rSec}d`;
      }
    }, 1000);
  @endif
</script>
@endsection
