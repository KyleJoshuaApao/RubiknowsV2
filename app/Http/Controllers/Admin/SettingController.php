<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Support\PublicContentCache;
use App\Support\SafeHtml;

class SettingController extends Controller
{
    /** Settings edited with the rich-text editor and rendered as HTML. */
    private const RICH_TEXT_KEYS = ['about_story_content'];

    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function store(SettingRequest $request)
    {
        // SettingRequest only validates the allowed setting keys.
        foreach ($request->validated() as $key => $value) {
            if (in_array($key, self::RICH_TEXT_KEYS, true)) {
                $value = SafeHtml::clean($value);
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        PublicContentCache::forgetSettings();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
