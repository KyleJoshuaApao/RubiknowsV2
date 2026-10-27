<?php

namespace App\Support;

use DateTimeInterface;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**
 * Lightweight bot filtering for the public forms: a honeypot field that people
 * never see, and a signed timestamp that rejects forms submitted faster than a
 * person could fill them in.
 */
final class SpamGuard
{
    public const HONEYPOT_FIELD = 'fax_number';

    public const TOKEN_FIELD = 'form_started';

    public const MIN_SECONDS = 3;

    public static function token(?DateTimeInterface $renderedAt = null): string
    {
        return Crypt::encryptString((string) ($renderedAt ?? now())->getTimestamp());
    }

    public static function caughtByHoneypot(Request $request): bool
    {
        return filled($request->input(self::HONEYPOT_FIELD));
    }

    public static function submittedTooQuickly(Request $request): bool
    {
        try {
            $renderedAt = (int) Crypt::decryptString((string) $request->input(self::TOKEN_FIELD));
        } catch (DecryptException) {
            return true;
        }

        return now()->getTimestamp() - $renderedAt < self::MIN_SECONDS;
    }
}
