<?php

namespace App\Support;

use App\Models\Setting;

/**
 * The company's public contact details from Admin → Settings, ready to display.
 */
final class ContactDetails
{
    public function __construct(
        public readonly string $phone,
        public readonly string $phoneHref,
        public readonly string $email,
        public readonly string $address,
    ) {
    }

    public static function fromSettings(): self
    {
        $settings = Setting::allCached();
        $phone = trim((string) ($settings['contact_phone'] ?? ''));

        return new self(
            phone: self::formatPhone($phone),
            phoneHref: preg_replace('/[^0-9+]/', '', $phone),
            email: trim((string) ($settings['contact_email'] ?? '')),
            address: trim((string) ($settings['office_address'] ?? '')),
        );
    }

    /**
     * Group Philippine mobile numbers for reading: 09454116141 → 0945 411 6141.
     */
    public static function formatPhone(string $phone): string
    {
        $digits = preg_replace('/\D/', '', $phone);

        if (preg_match('/^(09\d{2})(\d{3})(\d{4})$/', $digits, $parts)) {
            return "{$parts[1]} {$parts[2]} {$parts[3]}";
        }

        if (preg_match('/^63(9\d{2})(\d{3})(\d{4})$/', $digits, $parts)) {
            return "+63 {$parts[1]} {$parts[2]} {$parts[3]}";
        }

        return $phone;
    }
}
