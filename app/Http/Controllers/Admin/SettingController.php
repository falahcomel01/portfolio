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
        $fields = [
            'name', 'title',
            'hero_desc', 'contact_desc',
            'whatsapp', 'wa_message', 'avatar_link',
            'github', 'linkedin', 'twitter',

            // === FIELD HERO VISUAL CARD ===
            'hero_card_title',
            'hero_card_subtitle',
            'hero_card_items',
        ];

        foreach ($fields as $field) {
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
            'message' => 'Pengaturan berhasil disimpan!',
        ];

        // 2. HANDLE UPLOAD FOTO HERO (foto besar di section hero atas)
        if ($request->hasFile('hero_photo')) {
            $oldHero = Setting::where('key', 'hero_photo')->first();
            if ($oldHero && $oldHero->value && Storage::disk('public')->exists($oldHero->value)) {
                Storage::disk('public')->delete($oldHero->value);
            }
            $path = $request->file('hero_photo')->store('image', 'public');
            Setting::updateOrCreate(['key' => 'hero_photo'], ['value' => $path]);
            $responseData['hero_photo_url'] = Storage::url($path);
        }

        // 3. HANDLE UPLOAD AVATAR (foto profil di section about)
        if ($request->hasFile('avatar')) {
            $oldAvatar = Setting::where('key', 'avatar')->first();
            if ($oldAvatar && $oldAvatar->value && Storage::disk('public')->exists($oldAvatar->value)) {
                Storage::disk('public')->delete($oldAvatar->value);
            }
            $path = $request->file('avatar')->store('image', 'public');
            Setting::updateOrCreate(['key' => 'avatar'], ['value' => $path]);
            $responseData['avatar_url'] = Storage::url($path);
        }

        // 4. HANDLE UPLOAD FAVICON
        if ($request->hasFile('favicon')) {
            $oldFavicon = Setting::where('key', 'favicon')->first();
            if ($oldFavicon && $oldFavicon->value && Storage::disk('public')->exists($oldFavicon->value)) {
                Storage::disk('public')->delete($oldFavicon->value);
            }
            $path = $request->file('favicon')->store('image', 'public');
            Setting::updateOrCreate(['key' => 'favicon'], ['value' => $path]);
            $responseData['favicon_url'] = Storage::url($path);
        }

        // 5. RETURN JSON (untuk AJAX fetch())
        return response()->json($responseData);
    }
}