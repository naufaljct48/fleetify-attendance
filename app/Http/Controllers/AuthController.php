<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard')->with('swal', [
                'type'  => 'success',
                'title' => 'Success',
                'text'  => 'Login successful'
            ]);
        } else {
            return back()->with('swal', [
                'type'  => 'error',
                'title' => 'Failed',
                'text'  => 'Invalid email or password'
            ]);
        }
    }

    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');

        if ($password !== $password_confirmation) {
            return back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Password tidak cocok'
            ]);
        }
        if (!preg_match('/^(?=.*[A-Z])[A-Za-z0-9]{8}$/', $password)) {
            return back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Password harus 8 karakter, alfanumerik dan mengandung minimal 1 huruf kapital'
            ]);
        }
        $allowedDomains = ['gmail.com', 'hotmail.com'];
        $emailDomain = substr(strrchr($email, "@"), 1);
        if (!in_array($emailDomain, $allowedDomains)) {
            return back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Email harus menggunakan domain yang valid (gmail.com, hotmail.com)'
            ]);
        }
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return back()->with('swal', [
                'type'  => 'error',
                'title' => 'Gagal',
                'text'  => 'Email sudah terdaftar'
            ]);
        }
        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password)
        ]);
        Auth::login($user);
        return redirect()->route('dashboard')->with('swal', [
            'type'  => 'success',
            'title' => 'Berhasil',
            'text'  => 'Registrasi berhasil'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
