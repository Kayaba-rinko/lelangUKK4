<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Masyarakat;
use Illuminate\Support\Facades\Hash;

class authController extends Controller
{
    public function showLoginMasyarakat()
    {
        return view('auth.login');
    }
    public function showLoginPetugas()
    {
        return view('auth.login_petugas');
    }
    public function loginMasyarakat(Request $request)
    {
        $credenstials = $request->only('username', 'password');
        if(Auth::guard('masyarakat')->attempt($credenstials)){
            if( Auth::guard('masyarakat')->user()->status != 'aktif'){
                Auth::guard('masyarakat')->logout();
                return back()->with('error', 'Akun Anda diblokir. Silakan hubungi petugas.');
            }
            $request->session()->regenerate();
            return redirect()->intended('/masyarakat/dashboard');
        }
        return back()->with('error', 'Login Gagal, Username atau Password Salah');
    }
    public function loginPetugas(Request $request)
    {
        $credenstials = $request->only('username', 'password');
        if(Auth::guard('petugas')->attempt($credenstials)){
            $request->session()->regenerate();
            return redirect()->intended('/petugas/dashboard');
        }
        return back()->with('error', 'Login Gagal, Username atau Password Salah');
    }
    public function logout(Request $request){
        if(Auth::guard('masyarakat')->check()){
            Auth::guard('masyarakat')->logout();
        }
        if(Auth::guard('petugas')->check()){
            Auth::guard('petugas')->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function showRegister()
    {
        return view('auth.register');
    }
    public function registerMasyarakat(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:masyarakat,username',
            'password' => 'required|string|min:6|confirmed',
            'telp' => 'nullable|string|max:15|unique:masyarakat,telp',
        ]);
        $Masyarakat = Masyarakat::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'telp' => $request->telp,
        ]);
        Auth::guard('masyarakat')->login($Masyarakat);
        return redirect('/masyarakat/dashboard')->with('success', 'Registrasi Berhasil, Silahkan Login');
    }
}
