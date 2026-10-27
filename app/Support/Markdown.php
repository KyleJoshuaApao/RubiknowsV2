<?php

namespace App\Support;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Renders the plain text typed into CMS textareas. Blank lines start new
 * paragraphs, lines starting with "-" become bullet lists, and **bold** works.
 * Raw HTML is stripped and unsafe links are dropped.
 */
final class Markdown
{
    public static function render(?string $text): HtmlString
    {
        $text = trim((string) $text);

        if ($text === '') {
            return new HtmlString('');
        }

        return new HtmlString(Str::markdown($text, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 10,
            'renderer' => ['soft_break' => "<br>\n"],
        ]));
    }
}
