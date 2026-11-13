<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoAndGuardrailTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_every_locale_page_has_unique_title_canonical_and_hreflang(): void
    {
        foreach (['id', 'en'] as $locale) {
            $response = $this->get("/$locale");
            $response->assertOk();

            $response->assertSee('<link rel="canonical"', false);
            $response->assertSee('hreflang="id"', false);
            $response->assertSee('hreflang="en"', false);
            $response->assertSee('hreflang="x-default"', false);
            $response->assertSee('<meta name="description"', false);
        }

        // Unique titles per locale.
        $idTitle = $this->get('/id')->getContent();
        $enTitle = $this->get('/en')->getContent();
        preg_match('/<title>(.*?)<\/title>/s', $idTitle, $idMatch);
        preg_match('/<title>(.*?)<\/title>/s', $enTitle, $enMatch);
        $this->assertNotSame($idMatch[1], $enMatch[1]);
    }

    public function test_sitemap_lists_both_locale_urls(): void
    {
        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertSee('/id</loc>', false);
        $response->assertSee('/en</loc>', false);
    }

    public function test_robots_txt_allows_crawling(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('User-agent');
    }

    public function test_json_ld_contains_no_fabricated_facts(): void
    {
        $content = $this->get('/id')->getContent();

        $this->assertStringContainsString('application/ld+json', $content);
        $this->assertStringNotContainsString('aggregateRating', $content);
        $this->assertStringNotContainsString('streetAddress', $content);
        $this->assertStringNotContainsString('priceRange', $content);
    }

    public function test_no_price_figures_anywhere_in_rendered_pages(): void
    {
        // PRD §7.5 bans displaying prices. Mentions of "asking the admin for
        // pricing" are copy, not prices — currency figures are the marker.
        foreach (['id', 'en'] as $locale) {
            $content = $this->get("/$locale")->getContent();

            $this->assertDoesNotMatchRegularExpression('/Rp\s?\d/i', $content, "[$locale] Rupiah figure found");
            $this->assertDoesNotMatchRegularExpression('/\bIDR\b/i', $content, "[$locale] IDR figure found");
            $this->assertDoesNotMatchRegularExpression('/(harga|price)\s*[:=]\s*[\d]/i', $content, "[$locale] price label with figure found");
        }
    }

    public function test_no_unverified_claims_in_rendered_pages(): void
    {
        foreach (['id', 'en'] as $locale) {
            $content = strtolower($this->get("/$locale")->getContent());

            foreach (['termurah', 'cheapest', 'nomor satu', '24/7', 'number one'] as $claim) {
                $this->assertStringNotContainsString($claim, $content, "[$locale] unverified claim: $claim");
            }
        }
    }

    public function test_disabled_cta_when_whatsapp_number_unconfigured(): void
    {
        config(['business.whatsapp_number' => null]);

        $response = $this->get('/id');
        $response->assertOk();
        $response->assertSee('disabled', false);
        $this->assertStringNotContainsString('https://wa.me', $response->getContent());
    }

    public function test_post_click_notice_is_present(): void
    {
        $content = $this->get('/id')->getContent();

        $this->assertStringContainsStringIgnoringCase('belum menjadi booking', $content);
    }

    public function test_not_found_returns_real_404(): void
    {
        $this->get('/id/halaman-tidak-ada')->assertStatus(404);
    }
}
