<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use DOMXPath;

/**
 * Allowlist sanitiser for rich text written in the CMS (Quill editor output).
 * Keeps basic formatting, drops scripts, event handlers and unsafe links.
 */
final class SafeHtml
{
    private const ALLOWED_TAGS = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'span', 'ul', 'ol', 'li', 'h2', 'h3', 'h4', 'blockquote', 'a'];

    /** Removed together with everything inside them. */
    private const DROPPED_TAGS = ['script', 'style', 'iframe', 'object', 'embed', 'template', 'noscript', 'svg', 'math', 'form', 'textarea', 'select'];

    public static function clean(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $document = new DOMDocument();
        $previous = libxml_use_internal_errors(true);
        $document->loadHTML(
            '<?xml encoding="UTF-8"><div data-safe-html-root>'.$html.'</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = (new DOMXPath($document))->query('//div[@data-safe-html-root]')->item(0);
        if (! $root) {
            return e(strip_tags($html));
        }

        self::sanitizeChildren($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return $clean;
    }

    private static function sanitizeChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if ($node instanceof DOMText) {
                continue;
            }

            if (! $node instanceof DOMElement) {
                $parent->removeChild($node); // comments, processing instructions

                continue;
            }

            $tag = strtolower($node->tagName);

            if (in_array($tag, self::DROPPED_TAGS, true)) {
                $parent->removeChild($node);

                continue;
            }

            self::sanitizeChildren($node);

            if (! in_array($tag, self::ALLOWED_TAGS, true)) {
                // Keep the text of unknown wrappers (div, font, …) but drop the tag.
                while ($node->firstChild) {
                    $parent->insertBefore($node->firstChild, $node);
                }
                $parent->removeChild($node);

                continue;
            }

            self::sanitizeAttributes($node, $tag);
        }
    }

    private static function sanitizeAttributes(DOMElement $element, string $tag): void
    {
        foreach (iterator_to_array($element->attributes) as $attribute) {
            $name = strtolower($attribute->name);
            $value = $attribute->value;

            $keep = match (true) {
                $name === 'class' => (bool) preg_match('/^(ql-[a-z0-9-]+\s*)+$/', trim($value)),
                $name === 'href' && $tag === 'a' => self::isSafeUrl($value),
                default => false,
            };

            if (! $keep) {
                $element->removeAttribute($attribute->name);
            }
        }

        if ($tag === 'a' && $element->hasAttribute('href')) {
            $element->setAttribute('rel', 'noopener noreferrer');
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        $url = trim($url);

        // Control characters let "java\tscript:" slip past naive scheme checks.
        if (preg_match('/[\x00-\x1F\x7F]/', $url)) {
            return false;
        }

        return (bool) preg_match('~^(https?://|mailto:|/(?!/)|#)~i', $url);
    }
}
