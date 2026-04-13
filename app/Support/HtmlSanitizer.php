<?php

namespace App\Support;

class HtmlSanitizer
{
    public static function clean(?string $html): string
    {
        if (!$html) {
            return '';
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?>' . '<div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $allowedTags = ['a','p','br','ul','ol','li','strong','em','b','i','u','blockquote','code','pre','h1','h2','h3','h4','h5','h6','img','table','thead','tbody','tr','th','td','span','div'];
        $allowedAttrs = [
            'a' => ['href','title','target','rel'],
            'img' => ['src','alt','title','width','height'],
            '*' => ['class']
        ];

        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('//*') as $node) {
            if (!in_array($node->nodeName, $allowedTags)) {
                $node->parentNode->removeChild($node);
                continue;
            }

            if ($node->hasAttributes()) {
                $attrs = [];
                foreach ($node->attributes as $attr) {
                    $attrs[] = $attr->name;
                }
                foreach ($attrs as $attrName) {
                    $isAllowed = in_array($attrName, $allowedAttrs[$node->nodeName] ?? []) || in_array($attrName, $allowedAttrs['*']);
                    if (!$isAllowed || strpos($attrName, 'on') === 0 || $attrName === 'style') {
                        $node->removeAttribute($attrName);
                        continue;
                    }
                    $val = $node->getAttribute($attrName);
                    if ($node->nodeName === 'a' && $attrName === 'href') {
                        $lower = strtolower($val);
                        if (preg_match('/^\s*javascript:/', $lower)) {
                            $node->removeAttribute('href');
                        }
                        if (preg_match('/^\s*data:/', $lower)) {
                            $node->removeAttribute('href');
                        }
                        if (!preg_match('/^(https?:|mailto:|\/|#)/', $lower)) {
                            $node->setAttribute('href', '#');
                        }
                        $node->setAttribute('rel', 'noopener noreferrer');
                        $target = $node->getAttribute('target');
                        if (!in_array($target, ['_blank', '_self', ''])) {
                            $node->removeAttribute('target');
                        }
                    }
                    if ($node->nodeName === 'img' && $attrName === 'src') {
                        $lower = strtolower($val);
                        if (preg_match('/^\s*javascript:/', $lower)) {
                            $node->removeAttribute('src');
                        }
                        if (preg_match('/^\s*data:/', $lower)) {
                            $node->removeAttribute('src');
                        }
                        if (!preg_match('/^(https?:|\/)/', $lower)) {
                            $node->removeAttribute('src');
                        }
                    }
                }
            }
        }

        $container = $doc->getElementsByTagName('div')->item(0);
        $htmlOut = '';
        foreach ($container->childNodes as $child) {
            $htmlOut .= $doc->saveHTML($child);
        }
        return $htmlOut ?? '';
    }
}

