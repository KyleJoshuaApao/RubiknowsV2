<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

final class MediaUrl
{
    /**
     * Resolve both uploaded storage paths and explicitly supplied remote demo media.
     */
    public static function for(?string $path): ?string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return null;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
