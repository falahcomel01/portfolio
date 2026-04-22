<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        // Mengambil semua setting menjadi array key => value
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // 1. DAFTAR SEMUA FIELD TEKS
        // Pastikan semua key ini ada di form input name="..."
        // NOTE: Saya menambahkan 3 field baru di paling bawah (hero_card...)
        // Saya menghapus role, passion, hero_badge, dribbble karena sudah tidak ada di form.
        $fields = [
            'name', 'title', 
            'hero_desc', 'contact_desc', 
            'whatsapp', 'wa_message', 'avatar_link', 
            'github', 'linkedin', 'twitter',
            
            // === FIELD BARU UNTUK HERO VISUAL CARD ===
            'hero_card_title', 
            'hero_card_subtitle', 
            'hero_card_items'
        ];

        foreach ($fields as $field) {
            // Update/Create data setting
            // Kita simpan meskipun kosong, agar user bisa menghapus teks jika mau
            if ($request->has($field)) {
                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field)]
                );
            }
        }

        // Response data untuk dikirim ke frontend (JSON)
        $responseData = [
            'success' => true,
            'message' => 'Pengaturan berhasil disimpan!'
        ];

        // 2. HANDLE UPLOAD AVATAR
        if ($request->hasFile('avatar')) {
            // Hapus gambar lama jika ada
            $oldAvatar = Setting::where('key', 'avatar')->first();
            if ($oldAvatar && Storage::disk('public')->exists($oldAvatar->value)) {
                Storage::disk('public')->delete($oldAvatar->value);
            }

            // Simpan gambar baru
            $path = $request->file('avatar')->store('image', 'public');
            Setting::updateOrCreate(['key' => 'avatar'], ['value' => $path]);
            
            // Kirim URL baru agar preview gambar di frontend langsung berubah
            $responseData['avatar_url'] = Storage::url($path);
        }

        // 3. HANDLE UPLOAD FAVICON
        if ($request->hasFile('favicon')) {
            // Hapus gambar lama jika ada
            $oldFavicon = Setting::where('key', 'favicon')->first();
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon->value)) {
                Storage::disk('public')->delete($oldFavicon->value);
            }

            // Simpan gambar baru
            $path = $request->file('favicon')->store('image', 'public');
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $path]);
            
            // Kirim URL baru
            $responseData['favicon_url'] = Storage::url($path);
        }

        // 4. RETURN JSON (PENTING UNTUK AJAX)
        // Form frontend menggunakan fetch(), jadi harus return JSON, bukan redirect.
        return response()->json($responseData);
    }
}