<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalInquiryRequest extends FormRequest
{
    private const SERVICES = ['driver', 'selfdrive', 'delivery', 'transfer'];

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => trim((string) $this->input('name')),
            'pickup' => trim((string) $this->input('pickup')),
            'notes' => mb_substr(trim((string) $this->input('notes')), 0, 500),
        ]);
    }

    public function rules(): array
    {
        $service = $this->input('service');

        return [
            'name' => ['required', 'string', 'max:100'],
            'service' => ['required', 'in:'.implode(',', self::SERVICES)],
            'vehicle' => ['nullable', 'exists:vehicles,slug,is_published,1'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'duration' => ['required', 'in:12,24'],
            'pickup' => ['required', 'string', 'max:200'],
            // Conditional fields are validated only when their service is chosen.
            'route' => [$service === 'driver' ? 'required' : 'nullable', 'string', 'max:200'],
            'flight_number' => [$service === 'transfer' ? 'required' : 'nullable', 'string', 'max:20'],
            'flight_time' => [$service === 'transfer' ? 'required' : 'nullable', 'date_format:H:i'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return __('messages.validation');
    }
}
