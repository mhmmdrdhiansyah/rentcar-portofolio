@props(['placement' => 'header', 'variant' => 'green'])

@php
    $number = config('business.whatsapp_number');
    $configured = filled($number) && preg_match('/^\d+$/', (string) $number);
    $dark = $variant === 'dark';

    $enabled = [
        'inline-flex items-center gap-2 font-bold text-white transition-all px-5 py-2.5 text-label-lg',
        'rounded-xl px-3 py-3 text-label-md' => $dark,
        'rounded-full' => ! $dark,
        'bg-neutral-900 hover:bg-neutral-950 shadow-[inset_2px_2px_5px_0px_rgba(0,0,0,0.5),inset_-2px_-2px_6px_1px_rgba(80,78,78,0.5)]' => $dark,
        'bg-whatsapp-green hover:bg-whatsapp-green-hover hover:-translate-y-0.5 shadow-[0_4px_16px_rgba(37,211,102,0.25)] active:translate-y-0 active:scale-[0.98]' => ! $dark,
    ];

    $disabled = [
        'inline-flex cursor-not-allowed items-center gap-2 px-5 py-2.5 text-label-lg font-bold',
        'rounded-xl px-3 py-3 text-label-md' => $dark,
        'rounded-full' => ! $dark,
        'bg-neutral-900/60 text-white/70' => $dark,
        'bg-whatsapp-green/50 text-white/80' => ! $dark,
    ];
@endphp

{{-- The enabled and disabled branches intentionally share button markup:
     identical footprint so the header/floating layout never shifts when the
     WhatsApp number config flips. (layout-preservation over DRY) --}}
@if ($configured)
    <a
        href="https://wa.me/{{ $number }}?text={{ rawurlencode(__('messages.wa_greeting')) }}"
        target="_blank"
        rel="noopener noreferrer"
        data-cta-placement="{{ $placement }}"
        {{ $attributes->class($enabled) }}
    >
        @unless ($dark)
            <span class="material-symbols-outlined text-[20px]" aria-hidden="true">chat</span>
        @endunless
        <span class="hidden whitespace-nowrap md:inline">{{ __('messages.cta_whatsapp') }}</span>
        <span class="md:hidden">{{ __('messages.cta_whatsapp_short') }}</span>
        @if ($dark)
            <span class="material-symbols-outlined text-[20px]" aria-hidden="true">chevron_right</span>
        @endif
    </a>
@else
    {{-- TODO-01: WhatsApp number unverified — CTA ships disabled, never a broken wa.me link. --}}
    <button
        type="button"
        disabled
        title="{{ __('messages.wa_number_pending_title') }}"
        data-cta-placement="{{ $placement }}"
        {{ $attributes->class($disabled) }}
    >
        @unless ($dark)
            <span class="material-symbols-outlined text-[20px]" aria-hidden="true">chat</span>
        @endunless
        <span class="hidden whitespace-nowrap md:inline">{{ __('messages.cta_whatsapp') }}</span>
        <span class="md:hidden">{{ __('messages.cta_whatsapp_short') }}</span>
        @if ($dark)
            <span class="material-symbols-outlined text-[20px]" aria-hidden="true">chevron_right</span>
        @endif
    </button>
@endif
