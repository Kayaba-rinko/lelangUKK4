@extends('layouts.auth')
@section('title', 'Register')
@section('content')
    <div class="logo">
        <div class="logo-icon">📝</div>
        <h1 class="logo-text">LelangUKK</h1>
    </div>
    <h2 class="title">Create an Account</h2>
    <form method="POST" action="{{ route('register.submit') }}">
        @csrf
        <input type="text" name="name" placeholder="Name" required autofocus>
        <input type="text" minlength="16" maxlength="16" name="username" placeholder="NIK" required autofocus>
        <input type="text" name="telp" placeholder="No Telp" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit"
            style="width: 100%;padding: 12px;margin-top: 20px;background-color: #4b42c4;color: white;border: none;border-radius: 3px;font-size: 16px;cursor: pointer;">Register</button>
    </form>
    <div class="options">
        <a href="{{ route('login') }}">Already have an account? Login</a>
    </div>
@endsection