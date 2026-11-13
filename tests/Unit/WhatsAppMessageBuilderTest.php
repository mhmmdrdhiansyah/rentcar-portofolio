<?php

namespace Tests\Unit;

use App\Support\WhatsAppMessageBuilder;
use PHPUnit\Framework\TestCase;

class WhatsAppMessageBuilderTest extends TestCase
{
    // Covers the wa.me message builder (design.md §5.3, PRD §10.5).
    private const NUMBER = '6281234567890';

    private function data(): array
    {
        return [
            'name' => 'Budi Santoso',
            'service' => 'Rental dengan sopir',
            'vehicle' => 'Toyota Avanza',
            'date' => '2026-12-01',
            'time' => '08:00',
            'duration' => '24 jam',
            'pickup' => 'Bandara H.A.S. Hanandjoeddin',
            'route' => 'Tanjungpandan',
            'flight' => null,
            'notes' => 'Butuh car seat anak',
        ];
    }

    public function test_builds_id_message_with_all_fields(): void
    {
        $url = (new WhatsAppMessageBuilder('id', self::NUMBER))->build($this->data());

        $this->assertStringStartsWith('https://wa.me/'.self::NUMBER.'?text=', $url);

        $text = urldecode(substr($url, strlen('https://wa.me/'.self::NUMBER.'?text=')));
        $this->assertStringContainsString("Halo Let's Ride Belitung", $text);
        $this->assertStringContainsString('Nama: Budi Santoso', $text);
        $this->assertStringContainsString('Jenis layanan: Rental dengan sopir', $text);
        $this->assertStringContainsString('Kendaraan: Toyota Avanza', $text);
        $this->assertStringContainsString('Tanggal mulai: 2026-12-01', $text);
        $this->assertStringContainsString('Jam mulai: 08:00', $text);
        $this->assertStringContainsString('Durasi: 24 jam', $text);
        $this->assertStringContainsString('Lokasi penjemputan/pengantaran: Bandara H.A.S. Hanandjoeddin', $text);
        $this->assertStringContainsString('Tujuan/rute: Tanjungpandan', $text);
        $this->assertStringContainsString('Detail penerbangan: tidak ada', $text);
        $this->assertStringContainsString('Catatan: Butuh car seat anak', $text);
        $this->assertStringContainsString('Mohon informasi ketersediaan kendaraan', $text);
    }

    public function test_builds_en_message(): void
    {
        $data = $this->data();
        $data['service'] = 'Car rental with driver';
        $data['duration'] = '24 hours';

        $url = (new WhatsAppMessageBuilder('en', self::NUMBER))->build($data);
        $text = urldecode(substr($url, strlen('https://wa.me/'.self::NUMBER.'?text=')));

        $this->assertStringContainsString('Hello', $text);
        $this->assertStringContainsString('Name: Budi Santoso', $text);
        $this->assertStringContainsString('Service: Car rental with driver', $text);
        $this->assertStringContainsString('Please share availability', $text);
    }

    public function test_missing_optional_fields_render_placeholder(): void
    {
        $data = $this->data();
        unset($data['vehicle'], $data['route'], $data['notes']);

        $url = (new WhatsAppMessageBuilder('id', self::NUMBER))->build($data);
        $text = urldecode(substr($url, strlen('https://wa.me/'.self::NUMBER.'?text=')));

        $this->assertStringContainsString('Kendaraan: belum ditentukan', $text);
        $this->assertStringContainsString('Tujuan/rute: tidak ada', $text);
        $this->assertStringContainsString('Catatan: tidak ada', $text);
    }

    public function test_special_characters_are_url_encoded(): void
    {
        $data = $this->data();
        $data['name'] = "O'Brien & Co <b>bold</b> 100%";

        $url = (new WhatsAppMessageBuilder('id', self::NUMBER))->build($data);

        // No raw & outside encoding, no raw spaces or angle brackets in URL.
        $query = substr($url, strlen('https://wa.me/'.self::NUMBER.'?text='));
        $this->assertStringNotContainsString(' ', $query);
        $this->assertStringNotContainsString('<', $query);

        $text = urldecode($query);
        $this->assertStringContainsString("O'Brien & Co <b>bold</b> 100%", $text);
    }

    public function test_multiline_notes_are_flattened(): void
    {
        $data = $this->data();
        $data['notes'] = "baris satu\nbaris  dua   tiga";

        $url = (new WhatsAppMessageBuilder('id', self::NUMBER))->build($data);
        $text = urldecode(substr($url, strlen('https://wa.me/'.self::NUMBER.'?text=')));

        $this->assertStringContainsString('Catatan: baris satu baris dua tiga', $text);
    }
}
