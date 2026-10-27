<?php

namespace App\Http\Middleware;

use App\Support\SpamGuard;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockSpamSubmissions
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (SpamGuard::caughtByHoneypot($request)) {
            // Answer like a normal submission so automated senders learn nothing.
            return back()->with('success', 'Thank you. We have received your submission.');
        }

        if (SpamGuard::submittedTooQuickly($request)) {
            return back()
                ->withInput($request->except([SpamGuard::HONEYPOT_FIELD, SpamGuard::TOKEN_FIELD]))
                ->withErrors(['form' => 'Please check your details and send the form again.']);
        }

        return $next($request);
    }
}
