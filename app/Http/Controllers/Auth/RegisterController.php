<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PemilikKebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function showRoleChoice()
    {
        return view('auth.register_choice');
    }

    public function showRegistrationForm(Request $request)
    {
        $path = $request->path();
        $role = basename($path);

        if (!in_array($role, ['pelamar', 'pemilik'])) {
            return redirect()->route('register')->withErrors('Role tidak valid.');
        }

        return view(
            $role === 'pelamar'
                ? 'auth.register_pelamar'
                : 'auth.register_pemilik',
            compact('role')
        );
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => ['required', Rule::in(['pemilik', 'pelamar'])],

            // Validasi khusus Pemilik Kebun
            'luas_kebun'   => Rule::requiredIf($request->role === 'pemilik'),
            'lokasi_kebun' => Rule::requiredIf($request->role === 'pemilik'),
            'kontak'       => Rule::requiredIf($request->role === 'pemilik'),

            'foto_dokumen' => Rule::requiredIf($request->role === 'pemilik'),
            'foto_profil'  => Rule::requiredIf($request->role === 'pemilik'),
        ]);

        // Create USER
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->role === 'pemilik' ? 'pending' : null,
        ]);

        // Jika role = pemilik, simpan tambahan data ke tabel pemilik_kebuns
        if ($user->role === 'pemilik') {

            $profilData = [
                'user_id'       => $user->id,
                'nama_pemilik'  => $request->username,
                'luas_kebun'    => $request->luas_kebun,
                'lokasi_kebun'  => $request->lokasi_kebun,
                'kontak'        => $request->kontak,
            ];

            // Upload FOTO DOKUMEN
            if ($request->hasFile('foto_dokumen')) {
                $file = $request->file('foto_dokumen');
                $filename = time() . '_dok_' . $file->getClientOriginalName();
                $file->storeAs('foto_pemilik', $filename, 'public');
                $profilData['foto_dokumen'] = $filename;
            }

            // Upload FOTO PROFIL (Baru)
            if ($request->hasFile('foto_profil')) {
                $file2 = $request->file('foto_profil');
                $filename2 = time() . '_profil_' . $file2->getClientOriginalName();
                $file2->storeAs('foto_profil', $filename2, 'public');
                $profilData['foto_profil'] = $filename2;
            }

            PemilikKebun::create($profilData);

            return redirect()
                ->route('login')
                ->with('success', 'Registrasi Pemilik Berhasil! Akun Anda sedang menunggu verifikasi Admin.');
        }

        // Kalau pelamar biasa
        return redirect()
            ->route('login')
            ->with('success', 'Registrasi Berhasil! Silakan login.');
    }
}
