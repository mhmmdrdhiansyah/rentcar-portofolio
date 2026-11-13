<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentalInquiryRequest;
use App\Models\Vehicle;
use App\Support\WhatsAppMessageBuilder;
use Illuminate\Http\JsonResponse;

class RentalInquiryController extends Controller
{
    public function __invoke(RentalInquiryRequest $request): JsonResponse
    {
        $number = config('business.whatsapp_number');

        if (! preg_match('/^\d+$/', (string) $number)) {
            return response()->json(['message' => __('messages.wa_unavailable')], 503);
        }

        $data = $request->validated();

        $vehicleName = null;
        if (filled($data['vehicle'] ?? null)) {
            $vehicleName = Vehicle::query()
                ->where('slug', $data['vehicle'])
                ->where('is_published', true)
                ->value('name');
        }

        $url = (new WhatsAppMessageBuilder(app()->getLocale(), $number))->build([
            'name' => $data['name'],
            'service' => __('messages.services.'.$data['service']),
            'vehicle' => $vehicleName ?? $data['vehicle'] ?? null,
            'date' => $data['date'],
            'time' => $data['time'],
            'duration' => __('messages.duration_hours', ['hours' => $data['duration']]),
            'pickup' => $data['pickup'],
            'route' => $data['service'] === 'driver' ? ($data['route'] ?? null) : null,
            'flight' => $data['service'] === 'transfer'
                ? trim(($data['flight_number'] ?? '').' '.($data['flight_time'] ?? ''))
                : null,
            'notes' => $data['notes'] ?? null,
        ]);

        // Deliberately nothing is stored or logged: Phase 1 has no lead storage (PRD §10.7).
        return response()->json(['whatsapp_url' => $url]);
    }
}
