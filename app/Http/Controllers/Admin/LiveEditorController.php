<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LiveEditorRequest;
use App\Models\Setting;

class LiveEditorController extends Controller
{
    public function index()
    {
        // Fetch specific dynamic settings
        $settings = [
            'home_stats_bar' => json_decode(Setting::getValue('home_stats_bar', '[]'), true),
            'home_markets' => json_decode(Setting::getValue('home_markets', '[]'), true),
            'home_marquee' => json_decode(Setting::getValue('home_marquee', '[]'), true),
            'home_careers' => json_decode(Setting::getValue('home_careers', '{}'), true),
        ];

        return view('admin.live-editor.index', compact('settings'));
    }

    public function store(LiveEditorRequest $request)
    {
        $data = $request->validated();

        if (isset($data['home_stats_bar'])) {
            // Re-index array to prevent weird JSON object generation if keys were missing
            Setting::updateOrCreate(['key' => 'home_stats_bar'], ['value' => json_encode(array_values($data['home_stats_bar']))]);
        }

        if (isset($data['home_markets'])) {
            $markets = array_filter(array_map('trim', explode(',', $data['home_markets'])));
            Setting::updateOrCreate(['key' => 'home_markets'], ['value' => json_encode(array_values($markets))]);
        }

        if (isset($data['home_marquee'])) {
            $marquee = array_filter(array_map('trim', explode(',', $data['home_marquee'])));
            Setting::updateOrCreate(['key' => 'home_marquee'], ['value' => json_encode(array_values($marquee))]);
        }

        if (isset($data['home_careers'])) {
            Setting::updateOrCreate(['key' => 'home_careers'], ['value' => json_encode($data['home_careers'])]);
        }

        return redirect()->back()->with('success', 'Homepage layout updated successfully!');
    }
}
