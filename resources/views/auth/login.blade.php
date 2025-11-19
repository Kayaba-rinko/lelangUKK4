@extends('layouts.auth')
@section('title', 'Login Masyarakat')

@section('content')
    <div class="logo">
        <div class="logo-icon">👤</div>
        <h1 class="logo-text">Login Masyarakat</h1>
    </div>

    <h2 class="title">Welcome Back</h2>

    <form method="POST" action="{{ route('login.masyarakat') }}">
        @csrf

        <input type="text" minlength="16" maxlength="16" name="username" placeholder="NIK" required autofocus>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" class="btn-login">
            Login
        </button>
    </form>

    <div class="options">
        <a href="{{ route('register') }}">Belum punya akun? Daftar</a>

        <br><br>
        <a href="{{ route('login.petugas') }}">Login sebagai Petugas</a>
    </div>
@endsection
