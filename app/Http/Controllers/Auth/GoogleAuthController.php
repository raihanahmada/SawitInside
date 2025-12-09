<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\PelamarProfil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    // 1. Mengarahkan user ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // 2. Menangani balikan (callback) dari Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if (!$user) {
                $username = str_replace(' ', '', strtolower($googleUser->getName())) . rand(100, 999);

                $user = User::create([
                    'username'      => $username,
                    'email'         => $googleUser->getEmail(),
                    'password'      => Hash::make(Str::random(16)),
                    'role'          => 'pelamar',
                    'google_id'     => $googleUser->getId(),
                    'google_avatar' => $googleUser->getAvatar(),

                    // 🛠️ PERBAIKAN DI SINI: Gunakan 'status' => 'approved'
                    // Hapus baris: 'is_verified' => true,
                    'status'        => 'approved',
                ]);
            }
            else {
                if (empty($user->google_id)) {
                    $user->update([
                        'google_id'     => $googleUser->getId(),
                        'google_avatar' => $googleUser->getAvatar(),
                    ]);
                }
            }

            Auth::login($user);

            if ($user->role === 'pelamar') {
                return redirect()->route('pelamar.dashboard');
            } elseif ($user->role === 'pemilik') {
                return redirect('/');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect('/');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login: ' . $e->getMessage());
        }
    }
}
