<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocaleRoutingTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_indonesian_homepage_renders_with_id_locale(): void
    {
        $response = $this->get('/id');

        $response->assertStatus(200);
        $response->assertSee('lang="id"', false);
    }

    public function test_english_homepage_renders_with_en_locale(): void
    {
        $response = $this->get('/en');

        $response->assertStatus(200);
        $response->assertSee('lang="en"', false);
    }

    public function test_unsupported_locale_is_rejected(): void
    {
        $this->get('/xx')->assertStatus(404);
    }

    public function test_root_redirects_to_default_locale_prefix(): void
    {
        $this->get('/')->assertRedirect('/id');
    }
}
