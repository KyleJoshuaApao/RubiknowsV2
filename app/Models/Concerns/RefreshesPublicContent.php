<?php

namespace App\Models\Concerns;

use App\Support\PublicContentCache;

/**
 * Clears the cached public pages whenever a CMS record changes, so edits made
 * in the admin panel show up on the website straight away.
 */
trait RefreshesPublicContent
{
    protected static function bootRefreshesPublicContent(): void
    {
        static::saved(fn () => PublicContentCache::forgetPublicContent());
        static::deleted(fn () => PublicContentCache::forgetPublicContent());
    }
}
