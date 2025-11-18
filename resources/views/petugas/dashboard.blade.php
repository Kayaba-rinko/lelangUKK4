@extends('layouts.dashboard')
@section('title','Dashboard')

@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::guard('petugas')->user();
    $level = $user->level_id ?? $user->id_level ?? null; 
    // Admin = 1, Petugas = 2
@endphp

@section('content')
<div class="main-content">

    <div class="header">
        <h1>
            @if($level == 1)
                Dashboard Admin
            @elseif($level == 2)
                Dashboard Petugas
            @endif
        </h1>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

        <a href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="btn-logout">
            Logout
        </a>
    </div>

    {{-- TAMPILAN ADMIN (LEVEL 1) --}}
    @if($level == 1)
    <div class="stats-grid">
        <div class="stat-box">
            <h3>Total Masyarakat</h3>
            <p>120</p>
        </div>
        <div class="stat-box">
            <h3>Total Petugas</h3>
            <p>12</p>
        </div>
        <div class="stat-box">
            <h3>Total Lelang</h3>
            <p>45</p>
        </div>
    </div>
    @endif

    {{-- TAMPILAN PETUGAS (LEVEL 2) --}}
    @if($level == 2)
    <div class="card-box">
        <h2>Upcoming Auctions</h2>
        <div class="stats-grid">
            <div class="stat-box">
                <h3>Auction #1</h3>
                <button class="btn-primary">Verify</button>
            </div>
            <div class="stat-box">
                <h3>Auction #2</h3>
                <button class="btn-primary">Verify</button>
            </div>
            <div class="stat-box">
                <h3>Auction #3</h3>
                <button class="btn-primary">Verify</button>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
