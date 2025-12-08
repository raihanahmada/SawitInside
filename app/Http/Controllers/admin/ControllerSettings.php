<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Setting;
use Illuminate\Support\Facades\File; // Wajib di-import untuk operasi public_path
use Illuminate\Support\Facades\Cache;

class ControllerSettings extends Controller
{
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        // Pastikan path view sudah benar sesuai struktur Anda
        return view('admin.settings.general', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        // ... (Kode Validasi Dihilangkan untuk keringkasan)

        foreach ($request->except('_token', '_method') as $key => $value) {

            $value_to_save = $value;

            if ($request->hasFile($key)) {
                $file = $request->file($key);

                // 1. Tentukan folder tujuan di public
                $destinationPath = 'images/settings';
                $fileName = $key . '_' . time() . '.' . $file->getClientOriginalExtension();

                // 2. Pastikan folder tujuan ada di public
                if (!File::exists(public_path($destinationPath))) {
                    File::makeDirectory(public_path($destinationPath), 0777, true, true);
                }

                // 3. Pindahkan file ke folder public/images/settings
                $file->move(public_path($destinationPath), $fileName);

                // Path yang disimpan di database adalah path relatif dari folder public
                $value_to_save = $destinationPath . '/' . $fileName;

                // 4. Hapus File Lama dari Folder PUBLIC
                $oldSetting = Setting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value && File::exists(public_path($oldSetting->value))) {
                    File::delete(public_path($oldSetting->value));
                }

            } else if ($key === 'logo_path' || $key === 'hero_image_path') {
                continue;
            } else {
                // Untuk data non-file
                $value_to_save = $value;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value_to_save]
            );
        }

        // HAPUS CACHE GLOBAL SETTINGS OTOMATIS
        Cache::forget('global_settings');

        // Menggunakan nama route BARU Anda (settings.index)
        return redirect()->route('settings.index')->with('success', 'Pengaturan Web berhasil diperbarui!');
    }
}
