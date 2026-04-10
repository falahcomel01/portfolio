<?php

namespace App\Helpers;

use App\Models\Setting;

class SettingHelper
{
    public static function get($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value)
    {
        return Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAll()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return $settings;
    }
}