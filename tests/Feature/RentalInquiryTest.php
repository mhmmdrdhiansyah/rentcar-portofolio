<?php

namespace Tests\Feature;

use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class RentalInquiryTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private const SERVICE_LABELS = [
        'driver' => 'Rental dengan sopir',
        'selfdrive' => 'Rental lepas kunci',
        'delivery' => 'Pengantaran kendaraan ke bandara',
        'transfer' => 'Antar-jemput penumpang bandara',
    ];

    private function validPayload(): array
    {
        return [
            'name' => 'Budi Santoso',
            'service' => 'driver',
            'vehicle' => 'toyota-avanza',
            'date' => now()->addDays(3)->toDateString(),
            'time' => '08:00',
            'duration' => '24',
            'pickup' => 'Bandara H.A.S. Hanandjoeddin',
            'route' => 'Tanjungpandan',
        ];
    }

    public function test_valid_payload_returns_whatsapp_url(): void
    {
        Config::set('business.whatsapp_number', '6281234567890');

        $response = $this->postJson('/id/rental-inquiry', $this->validPayload());

        $response->assertOk();
        $response->assertJsonStructure(['whatsapp_url']);
        $this->assertStringStartsWith('https://wa.me/6281234567890?text=', $response->json('whatsapp_url'));
    }

    public function test_payload_is_never_stored_or_logged(): void
    {
        Config::set('business.whatsapp_number', '6281234567890');
        Config::set('logging.default', 'null');

        $before = [
            Vehicle::count(),
            \Illuminate\Support\Facades\DB::table('sessions')->count(),
        ];

        $this->postJson('/id/rental-inquiry', $this->validPayload())->assertOk();

        $this->assertSame($before, [Vehicle::count(), \Illuminate\Support\Facades\DB::table('sessions')->count()]);
    }

    public function test_missing_required_fields_return_validation_errors(): void
    {
        $response = $this->postJson('/id/rental-inquiry', []);

        $response->assertStatus(422);
        foreach (['name', 'service', 'date', 'time', 'duration', 'pickup'] as $field) {
            $response->assertJsonValidationErrors($field);
        }
    }

    public function test_past_date_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['date'] = now()->subDay()->toDateString();

        $this->postJson('/id/rental-inquiry', $payload)
            ->assertJsonValidationErrors(['date']);
    }

    public function test_invalid_duration_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['duration'] = '6';

        $this->postJson('/id/rental-inquiry', $payload)
            ->assertJsonValidationErrors(['duration']);
    }

    public function test_transfer_service_requires_flight_details(): void
    {
        $payload = $this->validPayload();
        $payload['service'] = 'transfer';
        unset($payload['route']);

        $this->postJson('/id/rental-inquiry', $payload)
            ->assertJsonValidationErrors(['flight_number', 'flight_time']);
    }

    public function test_selfdrive_payload_ignores_route(): void
    {
        Config::set('business.whatsapp_number', '6281234567890');
        $payload = $this->validPayload();
        $payload['service'] = 'selfdrive';
        $payload['route'] = 'Tanjungpandan';

        $response = $this->postJson('/id/rental-inquiry', $payload);

        $response->assertOk();
        $text = urldecode(substr($response->json('whatsapp_url'), strlen('https://wa.me/6281234567890?text=')));
        $this->assertStringContainsString('Tujuan/rute: tidak ada', $text);
    }

    public function test_message_uses_service_and_vehicle_labels(): void
    {
        Config::set('business.whatsapp_number', '6281234567890');
        $payload = $this->validPayload();
        $payload['service'] = 'delivery';

        $response = $this->postJson('/id/rental-inquiry', $payload);

        $text = urldecode(substr($response->json('whatsapp_url'), strlen('https://wa.me/6281234567890?text=')));
        $this->assertStringContainsString(self::SERVICE_LABELS['delivery'], $text);
        $this->assertStringContainsString('Toyota Avanza', $text);
    }

    public function test_unknown_service_is_rejected(): void
    {
        $payload = $this->validPayload();
        $payload['service'] = 'helicopter';

        $this->postJson('/id/rental-inquiry', $payload)
            ->assertJsonValidationErrors(['service']);
    }
}
