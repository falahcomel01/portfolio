<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private const TEXT_FIELDS = [
        'name', 'title',
        'hero_desc', 'contact_desc',
        'whatsapp', 'wa_message', 'avatar_link',
        'github', 'linkedin', 'twitter',
        'hero_card_title',
        'hero_card_subtitle',
        'hero_card_items',
    ];

    public function index()
    {
        // Mengambil semua setting menjadi array key => value
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'hero_desc' => 'nullable|string|max:5000',
            'contact_desc' => 'nullable|string|max:5000',
            'whatsapp' => 'nullable|string|max:50',
            'wa_message' => 'nullable|string|max:1000',
            'avatar_link' => 'nullable|url|max:2048',
            'github' => 'nullable|url|max:2048',
            'linkedin' => 'nullable|url|max:2048',
            'twitter' => 'nullable|url|max:2048',
            'hero_card_title' => 'nullable|string|max:255',
            'hero_card_subtitle' => 'nullable|string|max:255',
            'hero_card_items' => 'nullable|string|max:5000',
            'hero_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'favicon' => 'nullable|image|mimes:png,ico,webp|max:1024',
        ]);

        foreach (self::TEXT_FIELDS as $field) {
            if (array_key_exists($field, $validated)) {
                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $validated[$field]]
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
