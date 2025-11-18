@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')
    <div class="logo">
        <div class="logo-icon">🔄</div>
        <h1 class="logo-text">LelangUKK</h1>
    </div>
    <h2 class="title">Reset Your Password</h2>
    <form method="POST" action="#">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="email" name="email" placeholder="Email" value="{{ old('email', $request->email) }}" required autofocus>
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm New Password" required>
        <button type="submit"
            style="width: 100%;padding: 12px;margin-top: 20px;background-color: #4b42c4;color: white;border: none;border-radius: 3px;font-size: 16px;cursor: pointer;
                ">Reset Password</button>
    </form>
    <div class="options">
        <a href="#">Back to Login</a>
    </div>
@endsection