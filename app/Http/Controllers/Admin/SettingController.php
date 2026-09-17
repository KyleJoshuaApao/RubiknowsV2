<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Support\PublicContentCache;
use Illuminate\Support\Arr;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(SettingRequest $request)
    {
        // Validate that only allowed settings keys are being updated
        $data = $request->validated();

        $data = Arr::except($data, ['_token', '_method']);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        \Illuminate\Support\Facades\Cache::forget('site_settings');
        PublicContentCache::forgetHome();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
