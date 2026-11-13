<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TranslationCompletenessTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private const BRAND_KEYS = [
        'meta_title',   // contains the brand name in both languages
        'nav_faq',      // "FAQ" is the accepted term in both languages
        'cta_whatsapp_short', // "Chat" works in both languages
        'area_tanjungpandan', // Place name: "Tanjungpandan" in both languages
        'area_manggar',       // Place name: "Manggar" in both languages
        'brand_name',     // "Let's Ride Belitung" in both languages
    ];

    private function messages(string $locale): array
    {
        return require lang_path($locale.'/messages.php');
    }

    private function flatten(array $items, string $prefix = ''): array
    {
        $flat = [];
        foreach ($items as $key => $value) {
            $path = $prefix === '' ? $key : "$prefix.$key";
            if (is_array($value)) {
                $flat += $this->flatten($value, $path);
            } else {
                $flat[$path] = $value;
            }
        }

        return $flat;
    }

    public function test_key_sets_are_identical_between_locales(): void
    {
        $id = array_keys($this->flatten($this->messages('id')));
        $en = array_keys($this->flatten($this->messages('en')));

        $this->assertSame(sort($id), sort($en));
        $this->assertSame([], array_values(array_diff($id, $en)), 'Keys missing in en');
        $this->assertSame([], array_values(array_diff($en, $id)), 'Keys missing in id');
    }

    public function test_en_values_differ_from_id_except_brand_strings(): void
    {
        $id = $this->flatten($this->messages('id'));
        $en = $this->flatten($this->messages('en'));

        foreach ($id as $key => $value) {
            if (str_contains($key, 'services.')) {
                continue; // Service labels in the WhatsApp message are Indonesian in both locales.
            }
            if (in_array($key, self::BRAND_KEYS, true)) {
                continue;
            }
            $this->assertNotSame($value, $en[$key], "Locale key [$key] is not translated");
        }
    }

    public function test_no_placeholder_copy_ships(): void
    {
        foreach (['id', 'en'] as $locale) {
            foreach ($this->flatten($this->messages($locale)) as $key => $value) {
                $this->assertStringNotContainsStringIgnoringCase('lorem', $value, "[$locale] $key");
                $this->assertStringNotContainsStringIgnoringCase('placeholder', $value, "[$locale] $key");
            }
        }
    }

    public function test_english_page_contains_no_untranslated_indonesian_ui_strings(): void
    {
        $en = $this->get('/en');
        $en->assertOk();

        foreach (['Beranda', 'Area Layanan', 'Tentang Kami', 'Pesan via WhatsApp', 'Lihat Armada', 'Cara Pemesanan'] as $indonesian) {
            $en->assertDontSee($indonesian);
        }
    }

    public function test_indonesian_page_contains_the_indonesian_ui_strings(): void
    {
        $id = $this->get('/id');
        $id->assertOk();

        $id->assertSee('Beranda');
        $id->assertSee('Pesan via WhatsApp');
    }
}
