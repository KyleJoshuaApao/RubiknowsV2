<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
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

        // Get all settings from database to validate keys
        $allowedKeys = Setting::pluck('key')->toArray();

        $data = Arr::except($data, '_token');

        // Filter to only allowed keys
        $filteredData = array_intersect_key($data, array_flip($allowedKeys));

        foreach ($filteredData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
