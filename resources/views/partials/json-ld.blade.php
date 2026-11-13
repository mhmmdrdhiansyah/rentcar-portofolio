<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'AutoRental',
    'name' => config('business.name'),
    'description' => __('messages.meta_description'),
    'url' => \App\Support\Seo::canonical(),
    'areaServed' => [
        ['@type' => 'Place', 'name' => __('messages.area_tanjungpandan')],
        ['@type' => 'Place', 'name' => __('messages.area_airport')],
        ['@type' => 'Place', 'name' => __('messages.area_island')],
        ['@type' => 'Place', 'name' => __('messages.area_manggar')],
    ],
    // Facts only (PRD §12.4): no address (no office), no operating hours
    // (TODO-10), no prices, no ratings.
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
