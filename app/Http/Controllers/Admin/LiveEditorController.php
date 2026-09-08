<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_stats_bar' => 'nullable|array',
            'home_markets' => 'nullable|string', // Comma separated for easy input, or JSON
            'home_marquee' => 'nullable|string',
            'home_careers' => 'nullable|array',
        ]);

        if (isset($validated['home_stats_bar'])) {
            // Re-index array to prevent weird JSON object generation if keys were missing
            Setting::updateOrCreate(['key' => 'home_stats_bar'], ['value' => json_encode(array_values($validated['home_stats_bar']))]);
        }

        if (isset($validated['home_markets'])) {
            $markets = array_filter(array_map('trim', explode(',', $validated['home_markets'])));
            Setting::updateOrCreate(['key' => 'home_markets'], ['value' => json_encode(array_values($markets))]);
        }

        if (isset($validated['home_marquee'])) {
            $marquee = array_filter(array_map('trim', explode(',', $validated['home_marquee'])));
            Setting::updateOrCreate(['key' => 'home_marquee'], ['value' => json_encode(array_values($marquee))]);
        }

        if (isset($validated['home_careers'])) {
            Setting::updateOrCreate(['key' => 'home_careers'], ['value' => json_encode($validated['home_careers'])]);
        }

        return redirect()->back()->with('success', 'Homepage layout updated successfully!');
    }
}
