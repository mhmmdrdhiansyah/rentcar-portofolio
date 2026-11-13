<?php

namespace App\Support;

use Illuminate\Support\Facades\URL;

/**
 * Central SEO metadata: title, description, canonical, hreflang alternates.
 * Phase 1 is a single-page site — one entry per locale (PRD §8: no thin pages).
 */
class Seo
{
    public static function locales(): array
    {
        return config('business.supported_locales');
    }

    public static function currentPath(): string
    {
        return '/'.request()->route('locale');
    }

    public static function canonical(): string
    {
        return URL::to(self::currentPath());
    }

    /** @return array<string, string> locale => absolute URL */
    public static function alternates(): array
    {
        $alternates = [];
        foreach (self::locales() as $locale) {
            $alternates[$locale] = URL::to('/'.$locale);
        }

        return $alternates;
    }

    public static function sitemapUrls(): array
    {
        return array_values(self::alternates());
    }
}
