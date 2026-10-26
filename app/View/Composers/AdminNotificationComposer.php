<?php

namespace App\View\Composers;

use App\Models\ContactMessage;
use App\Models\JobApplication;
use App\Models\QuotationRequest;
use App\Support\PublicContentCache;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

/**
 * Unread badge counts for the admin sidebar. Cached briefly and cleared by the
 * submission models whenever a message, quotation or application changes.
 */
class AdminNotificationComposer
{
    public function compose(View $view): void
    {
        $counts = Cache::remember(
            PublicContentCache::ADMIN_NOTIFICATION_COUNTS,
            now()->addSeconds(30),
            fn () => [
                'messages' => ContactMessage::where('status', 'New')->count(),
                'quotations' => QuotationRequest::where('status', 'Pending')->count(),
                'applications' => JobApplication::where('status', 'Received')->count(),
            ],
        );

        $view->with([
            'unreadMsgs' => $counts['messages'],
            'pendingQuotes' => $counts['quotations'],
            'newApps' => $counts['applications'],
            'totalNotifications' => array_sum($counts),
        ]);
    }
}
