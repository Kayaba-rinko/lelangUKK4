@extends('layouts.auth')
@section('title', 'Login Petugas')

@section('content')
    <div class="logo">
        <div class="logo-icon">🛡️</div>
        <h1 class="logo-text">Login Petugas</h1>
    </div>

    <h2 class="title">Secure Access</h2>

    <form method="POST" action="{{ route('login.petugas.submit') }}">
        @csrf

        <input type="text" name="username" placeholder="Username Petugas" required autofocus>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn-login">
            Login Petugas
        </button>
    </form>

    <div class="options">
        <a href="{{ route('login') }}">Login sebagai Masyarakat</a>
    </div>
@endsection
