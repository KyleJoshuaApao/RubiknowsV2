<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LiveEditorRequest;
use App\Models\Setting;
use App\Support\PublicContentCache;

class LiveEditorController extends Controller
{
    public function index()
    {
        $settings = [
            'home_stats_bar' => Setting::getJson('home_stats_bar'),
            'home_markets' => Setting::getJson('home_markets'),
            'home_marquee' => Setting::getJson('home_marquee'),
            'home_careers' => Setting::getJson('home_careers'),
        ];

        return view('admin.live-editor.index', compact('settings'));
    }

    public function store(LiveEditorRequest $request)
    {
        $data = $request->validated();

        if (isset($data['home_stats_bar'])) {
            // Re-index so missing keys don't turn the list into a JSON object.
            $this->saveJson('home_stats_bar', array_values($data['home_stats_bar']));
        }

        if (isset($data['home_markets'])) {
            $this->saveJson('home_markets', $this->commaList($data['home_markets']));
        }

        if (isset($data['home_marquee'])) {
            $this->saveJson('home_marquee', $this->commaList($data['home_marquee']));
        }

        if (isset($data['home_careers'])) {
            $this->saveJson('home_careers', $data['home_careers']);
        }

        PublicContentCache::forgetHome();

        return redirect()->back()->with('success', 'Homepage layout updated successfully!');
    }

    private function saveJson(string $key, array $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => json_encode($value)]);
    }

    /**
     * @return array<int, string>
     */
    private function commaList(string $value): array
    {
        return array_values(array_filter(array_map('trim', explode(',', $value))));
    }
}
