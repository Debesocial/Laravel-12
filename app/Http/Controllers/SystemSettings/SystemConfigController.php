<?php

namespace App\Http\Controllers\SystemSettings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    public function index()
    {
        return view('pages.system_settings.system-config');
    }

    public function update(Request $request)
    {$request->validate([
    'app_name' => [
        'required',
        'string',
        'min:3',
        'max:100',
    ],
    'app_tagline' => [
        'nullable',
        'string',
        'max:150',
    ],
    'app_tagline1' => [
        'nullable',
        'string',
        'max:150',
    ],
    'app_tagline2' => [
        'nullable',
        'string',
        'max:300',
    ],
    'footer_text' => [
        'nullable',
        'string',
        'max:200',
    ],
    'app_logo' => [
        'nullable',
        'image',
        'mimes:jpg,jpeg,png,webp',
        'max:2048', // 2MB
    ],
    'app_favicon' => [
        'nullable',
        'image',
        'mimes:png,ico,webp',
        'max:1024', // 1MB
    ],
]);


        //-- Simpan text config
        set_setting('app_name', $request->app_name);
        set_setting('app_tagline', $request->app_tagline);
        set_setting('app_tagline1', $request->app_tagline1);
        set_setting('app_tagline2', $request->app_tagline2);
        set_setting('footer_text', $request->footer_text);

        //-- Upload logo jika ada
        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('uploads/settings', 'public');
            set_setting('app_logo', $path);
        }

        //-- Upload favicon jika ada
        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('uploads/settings', 'public');
            set_setting('app_favicon', $path);
        }

        return back()->with('success', __('Configuration updated successfully!'));
    }
}