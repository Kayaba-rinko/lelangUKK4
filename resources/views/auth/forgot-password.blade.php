@extends('layouts.auth')
@section('title', 'Forgot Password')
@section('content')
    <div class="logo">
        <div class="logo-icon">🔑</div>
        <h1 class="logo-text">LelangUKK</h1>
    </div>
    <h2 class="title">Reset Your Password</h2>
    <p class="subtitle">Enter your email to receive a password reset link</p>
    <form method="POST" action="#">
        @csrf
        <input type="email" name="email" placeholder="Email" required autofocus>
        <button type="submit"
            style="width: 100%;padding: 12px;margin-top: 20px;background-color: #4b42c4;color: white;border: none;border-radius: 3px;font-size: 16px;cursor: pointer;
                ">Send Password Reset Link</button>
    </form>
    <div class="options">
        <a href="#">Back to Login</a>
    </div>
@endsection