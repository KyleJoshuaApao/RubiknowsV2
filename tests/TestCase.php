<?php

namespace Tests;

use App\Support\SpamGuard;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Public form data as a person would submit it: with the signed start time
     * from when the form was shown, a minute earlier.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function publicForm(array $data): array
    {
        return [SpamGuard::TOKEN_FIELD => SpamGuard::token(now()->subMinute()), ...$data];
    }
}
