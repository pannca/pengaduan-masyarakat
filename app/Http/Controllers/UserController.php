<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('login.login');
    }

    public function login(Request $request)
    {
        return view('login.login');
    }

    public function LoginRegister(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek apakah tombol "Login" atau "Register" yang diklik
        if ($request->has('login')) {
            // Proses login
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                // Ambil role user yang berhasil login
                $role = Auth::user()->role;

                // Redirect berdasarkan role
                if ($role == 'GUEST') {
                    return redirect()->route('reports.article')->with('success', 'Welcome, Guest!');
                } elseif ($role == 'STAFF') {
                    return redirect()->route('response')->with('success', 'Welcome, Staff!');
                } elseif ($role == 'HEAD_STAFF') {
                    return redirect()->route('chart')->with('success', 'Welcome, Head Staff!');
                }

                // Default jika role tidak cocok
                return redirect('/')->with('error', 'Role tidak dikenali.');
            }

            // Jika login gagal
            return back()->with('error', 'Email atau password salah');
        }

        // Proses registrasi
        if ($request->has('register')) {
            // Cek apakah email sudah terdaftar
            $cekEmail = User::where('email', $request->email)->first();

            if ($cekEmail) {
                return back()->with('error', 'Email sudah terdaftar, silakan login.');
            }

            // Buat akun baru dengan role default 'guest'
            $User = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'guest', // Default role
            ]);

            // Login user yang baru dibuat
            Auth::login($User);

            // Redirect ke halaman guest setelah registrasi
            return redirect()->route('reports.article')->with('success', 'Akun berhasil dibuat! Anda masuk sebagai Guest.');
        }
    }


    public function logout() {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda Telah Logout!');
    }

    public function showRegister()
    {
        return view('login.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'GUEST',
        ]);

        Auth::login($user);

        return redirect()->route('reports.article')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Show the form for usereating a new resource.
     */
    public function usereate()
    {
        //
    }

    /**
     * Store a newly usereated resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(user $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(user $user)
    {
        //
    }
}
