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
            'home_careers' => Setting::getJson('home_careers'),
        ];

        return view('admin.live-editor.index', compact('settings'));
    }

    public function store(LiveEditorRequest $request)
    {
        $data = $request->validated();

        // Re-index so removed rows don't turn the list into a JSON object, and
        // skip half-filled rows.
        $stats = array_values(array_filter(
            $data['home_stats_bar'] ?? [],
            fn ($stat) => filled($stat['value'] ?? null) && filled($stat['label'] ?? null)
        ));
        $this->saveJson('home_stats_bar', $stats);

        $this->saveJson('home_careers', array_filter([
            'title' => trim((string) ($data['home_careers']['title'] ?? '')),
            'description' => trim((string) ($data['home_careers']['description'] ?? '')),
        ]));

        PublicContentCache::forgetHome();

        return redirect()->back()->with('success', 'Homepage updated.');
    }

    private function saveJson(string $key, array $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => json_encode($value)]);
    }
}
