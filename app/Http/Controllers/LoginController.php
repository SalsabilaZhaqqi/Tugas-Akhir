<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\InvalidToken;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Handle the Google login callback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // Validasi data yang diterima
            $request->validate([
                'idToken' => 'required|string',
                'user.name' => 'required|string',
                'user.email' => 'required|email',
                'user.uid' => 'required|string',
            ]);
            
            $idToken = $request->idToken;
            $userData = $request->user;
            
            // Cari user berdasarkan email
            $user = User::where('email', $userData['email'])->first();
            
            // Jika user tidak ditemukan, buat user baru
            if (!$user) {
                $user = User::create([
                    'name' => $userData['name'],
                    'email' => $userData['email'],
                    'password' => Hash::make(Str::random(16)), // Generate random password
                    'google_id' => $userData['uid'],
                    'avatar' => $userData['photo'] ?? null,
                ]);
            } else {
                // Update google_id jika belum ada
                if (empty($user->google_id)) {
                    $user->google_id = $userData['uid'];
                    $user->avatar = $userData['photo'] ?? $user->avatar;
                    $user->save();
                }
            }
            
            // Login user
            Auth::login($user);
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => '/dashboard'
            ]);
            
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Google auth error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Autentikasi gagal: ' . $e->getMessage()
            ], 401);
        }
    }
}