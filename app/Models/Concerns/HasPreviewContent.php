<?php

namespace App\Models\Concerns;

use App\Support\PreviewMode;
use Illuminate\Database\Eloquent\Builder;

/**
 * Rows flagged is_preview fill the site out for signed-in admins while real
 * content is being prepared. Everyone else never sees them.
 */
trait HasPreviewContent
{
    protected static function bootHasPreviewContent(): void
    {
        static::addGlobalScope('preview', function (Builder $query): void {
            if (! PreviewMode::active()) {
                $query->where($query->getModel()->getTable().'.is_preview', false);
            }
        });
    }
}
