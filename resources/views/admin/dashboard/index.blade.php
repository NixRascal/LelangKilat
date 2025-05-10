@extends('layouts.SideTopBarAdmin')
@section('title', 'Dashboard')
@section('content')

<div class="row g-10 justify-content-center">
    <div class="col-md-2 mb-3">
        <div class="card shadow-sm border-start-primary">
            <div class="card-body">
                <h6 class="text-muted">Total Pengguna</h6>
                <h3> 👦🏻 {{ $totalUsers }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card shadow-sm border-start-success">
            <div class="card-body">
                <h6 class="text-muted">Total Lelang</h6>
                <h3> ⚖️ {{ $totalAuctions }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card shadow-sm border-start-warning">
            <div class="card-body">
                <h6 class="text-muted">Lelang Aktif</h6>
                <h3> 🟢 {{ $activeAuctions }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card shadow-sm border-start-warning">
            <div class="card-body">
                <h6 class="text-muted">Penawaran Hari Ini</h6>
                <h3> 📨 {{ $bidsToday }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-2 mb-3">
        <div class="card shadow-sm border-start-warning">
            <div class="card-body">
                <h6 class="text-muted">Lelang Hari Ini</h6>
                <h3> 📅 {{ $todayAuctions  }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection