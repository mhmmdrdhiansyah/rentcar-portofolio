<?php

namespace App\Support;

class WhatsAppMessageBuilder
{
    public function __construct(
        private readonly string $locale,
        private readonly string $number,
    ) {}

    /**
     * Build a wa.me URL whose text carries the full inquiry.
     *
     * @param array<string, ?string> $data keys: name, service, vehicle?, date,
     *                                     time, duration, pickup, route?, flight?, notes?
     */
    public function build(array $data): string
    {
        $text = $this->locale === 'en'
            ? $this->buildEn($data)
            : $this->buildId($data);

        return 'https://wa.me/'.$this->number.'?text='.rawurlencode($text);
    }

    private function line(string $label, ?string $value, string $empty): string
    {
        $value = $this->flatten($value ?? '');

        return $value === '' ? $label.' '.$empty : $label.' '.$value;
    }

    private function flatten(?string $value): string
    {
        return trim((string) preg_replace('/\s+/', ' ', (string) $value));
    }

    private function buildId(array $data): string
    {
        $lines = [
            "Halo Let's Ride Belitung, saya ingin menanyakan ketersediaan dan harga rental mobil.\n",
            'Nama: '.$this->flatten($data['name'] ?? ''),
            $this->line('Jenis layanan:', $data['service'] ?? '', 'belum dipilih'),
            $this->line('Kendaraan:', $data['vehicle'] ?? null, 'belum ditentukan'),
            $this->line('Tanggal mulai:', $data['date'] ?? '', 'belum ditentukan'),
            $this->line('Jam mulai:', $data['time'] ?? '', 'belum ditentukan'),
            $this->line('Durasi:', $data['duration'] ?? '', 'belum dipilih'),
            $this->line('Lokasi penjemputan/pengantaran:', $data['pickup'] ?? '', 'belum ditentukan'),
            $this->line('Tujuan/rute:', $data['route'] ?? null, 'tidak ada'),
            $this->line('Detail penerbangan:', $data['flight'] ?? null, 'tidak ada'),
            $this->line('Catatan:', $data['notes'] ?? null, 'tidak ada'),
            "\nMohon informasi ketersediaan kendaraan, harga, dan syarat ketentuannya. Terima kasih.",
        ];

        return implode("\n", $lines);
    }

    private function buildEn(array $data): string
    {
        $lines = [
            "Hello Let's Ride Belitung, I would like to ask about car rental availability and pricing.\n",
            'Name: '.$this->flatten($data['name'] ?? ''),
            $this->line('Service:', $data['service'] ?? '', 'not selected'),
            $this->line('Vehicle:', $data['vehicle'] ?? null, 'undecided'),
            $this->line('Start date:', $data['date'] ?? '', 'undecided'),
            $this->line('Start time:', $data['time'] ?? '', 'undecided'),
            $this->line('Duration:', $data['duration'] ?? '', 'not selected'),
            $this->line('Pickup/delivery point:', $data['pickup'] ?? '', 'undecided'),
            $this->line('Route/destination:', $data['route'] ?? null, 'none'),
            $this->line('Flight details:', $data['flight'] ?? null, 'none'),
            $this->line('Notes:', $data['notes'] ?? null, 'none'),
            "\nPlease share availability, pricing, and the rental terms. Thank you.",
        ];

        return implode("\n", $lines);
    }
}
