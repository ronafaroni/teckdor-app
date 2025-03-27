<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function register()
    {
        return view('login.register');
    }

    public function authenticate(Request $request)
    {
        // Validasi manual
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $credentials = ['email' => $email, 'password' => $password];

        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            // Tambahkan identifier khusus untuk membedakan sesi
            $sessionKey = 'user_' . Auth::id(); // Gunakan ID user sebagai prefix
            session([$sessionKey => Auth::user()]);

            if (Auth::user()->role == 'admin') {
                return redirect()->intended('/admin-dashboard');
            } else if (Auth::user()->role == 'customer') {
                return redirect()->intended('/customer-dashboard');
            } else if (Auth::user()->role == 'finance') {
                return redirect()->intended('/finance-dashboard');
            }
        }

        // Jika login gagal
        return back()->withErrors([
            'error' => 'Email or password is incorrect.',
        ])->withInput();
    }


    public function saveRegister(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'role' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'role.required' => 'Role wajib diisi.',
            ]
        );

        $user = new \App\Models\User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('login')->with('success', 'Registrasi successfull.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
