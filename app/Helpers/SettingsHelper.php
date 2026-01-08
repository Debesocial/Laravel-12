<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null) {
        $path = 'settings.json'; // storage/app/settings.json

        if (!Storage::disk('local')->exists($path)) {
            return $default;
        }

        $data = Storage::disk('local')->get($path);
        $settings = json_decode($data, true) ?? [];

        return $settings[$key] ?? $default;
    }
}

if (!function_exists('set_setting')) {
    function set_setting($key, $value) {
        $path = 'settings.json';

        $settings = Storage::disk('local')->exists($path)
            ? json_decode(Storage::disk('local')->get($path), true)
            : [];

        $settings[$key] = $value;

        Storage::disk('local')->put($path, json_encode($settings, JSON_PRETTY_PRINT));
        return true;
    }
}