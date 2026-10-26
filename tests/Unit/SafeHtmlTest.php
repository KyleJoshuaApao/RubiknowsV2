<?php

namespace Tests\Unit;

use App\Support\SafeHtml;
use PHPUnit\Framework\TestCase;

class SafeHtmlTest extends TestCase
{
    public function test_it_keeps_basic_formatting_and_quill_classes(): void
    {
        $html = '<p class="ql-align-center"><strong>Bold</strong> and <em>italic</em></p><ul><li>One</li></ul>';

        $this->assertSame($html, SafeHtml::clean($html));
    }

    public function test_it_removes_scripts_and_event_handlers(): void
    {
        $clean = SafeHtml::clean('<p onclick="x()">Hi<script>alert(1)</script><img src=x onerror=alert(1)></p><style>p{}</style>');

        $this->assertSame('<p>Hi</p>', $clean);
    }

    public function test_it_unwraps_unknown_tags_but_keeps_their_text(): void
    {
        $this->assertSame('<p>Inside a div</p>', SafeHtml::clean('<div><p>Inside a <font>div</font></p></div>'));
    }

    public function test_it_only_keeps_safe_links(): void
    {
        $this->assertSame(
            '<a href="https://example.com" rel="noopener noreferrer">ok</a>',
            SafeHtml::clean('<a href="https://example.com" target="_blank">ok</a>')
        );

        foreach (['javascript:alert(1)', "java\tscript:alert(1)", 'JaVaScRiPt:alert(1)', 'data:text/html,x', '//evil.example'] as $href) {
            $this->assertSame('<a>bad</a>', SafeHtml::clean('<a href="'.$href.'">bad</a>'), $href);
        }
    }

    public function test_it_drops_non_quill_classes(): void
    {
        $this->assertSame('<p>Text</p>', SafeHtml::clean('<p class="evil ql-align-center">Text</p>'));
    }

    public function test_it_handles_empty_and_plain_text_input(): void
    {
        $this->assertSame('', SafeHtml::clean(null));
        $this->assertSame('', SafeHtml::clean('   '));
        $this->assertSame('Plain &amp; simple', SafeHtml::clean('Plain & simple'));
    }
}
