<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;

/**
 * Whether the current viewer is a signed-in admin, who also sees preview
 * content. Console commands, queued jobs and visitors never do.
 */
final class PreviewMode
{
    public static function active(): bool
    {
        if (app()->runningInConsole() && ! app()->runningUnitTests()) {
            return false;
        }

        return (bool) Auth::user()?->isAdmin();
    }
}
