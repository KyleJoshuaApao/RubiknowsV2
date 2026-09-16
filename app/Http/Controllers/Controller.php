<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Throwable;

abstract class Controller
{
    /**
     * Convert a storage failure into a form error instead of exposing a 500.
     */
    protected function uploadFailure(string $field, Throwable $exception): RedirectResponse
    {
        try {
            report($exception);
        } catch (Throwable) {
            // A broken log transport must not turn a handled upload failure into a 500.
        }

        return back()
            ->withInput()
            ->withErrors([$field => 'We could not save that file. Please try again with a smaller file.']);
    }
}
