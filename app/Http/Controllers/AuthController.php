<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegisterForm() {
        return view("auth.register");
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email'=> $data['email'],
            'password'=> bcrypt($data['password']),
            'role'=> 'USER',
        ]);

        $user->wallet()->create([
            'balance' => 0,
            'reserved_balance' => 0,
        ]);

        Auth::login($user);
        
        return redirect()->route('home');
    }
    
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email'=> 'required|email',
            'password'=> 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
            if ($user->role == 'ADMIN') {
                return redirect()->route('admin.dashboard');
            }
    
            return redirect()->route('home');
        }
        
        return back()->withErrors(['salah'=> 'Email atau password salah'])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }
}