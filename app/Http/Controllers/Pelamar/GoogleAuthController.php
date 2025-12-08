<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->getId())->first();

            if (!$user) {
                $user = User::where('email', $googleUser->getEmail())->first();

                if (!$user) {
                    $user = User::create([
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'password' => Hash::make(uniqid()),
                        'google_id' => $googleUser->getId(),
                        'google_avatar' => $googleUser->getAvatar(),
                        'role' => 'pelamar',
                    ]);
                } else {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'google_avatar' => $googleUser->getAvatar(),
                    ]);
                }
            }

            Auth::login($user);
            return redirect()->route('pelamar.dashboard');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal login dengan Google');
        }
    }
}
