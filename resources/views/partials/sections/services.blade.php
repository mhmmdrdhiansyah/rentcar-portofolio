<section id="services" class="bg-surface" aria-labelledby="services-title">
    <div class="mx-auto max-w-7xl px-4 py-20 md:px-8">
        <h2 id="services-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.services_title')</h2>
        <p class="mt-3 max-w-2xl text-body-md text-on-surface-variant">@lang('messages.services_sub')</p>

        <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-2">
            @foreach ([
                'driver' => ['icon' => 'airline_seat_recline_extra', 'title' => __('messages.service_driver'), 'desc' => __('messages.service_driver_desc')],
                'selfdrive' => ['icon' => 'key', 'title' => __('messages.service_selfdrive'), 'desc' => __('messages.service_selfdrive_desc')],
                'delivery' => ['icon' => 'local_shipping', 'title' => __('messages.service_delivery'), 'desc' => __('messages.service_delivery_desc')],
                'transfer' => ['icon' => ' connecting_airports', 'title' => __('messages.service_transfer'), 'desc' => __('messages.service_transfer_desc')],
            ] as $service => $card)
                <a
                    href="#booking-form"
                    class="group rounded-xl border border-border-soft bg-pure-white p-6 transition-all hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(24,59,67,0.08)]"
                >
                    <span class="inline-flex size-12 items-center justify-center rounded-full bg-secondary-container text-primary">
                        <span class="material-symbols-outlined text-[24px]" aria-hidden="true">{{ trim($card['icon']) }}</span>
                    </span>
                    <h3 class="mt-4 text-headline-md">{{ $card['title'] }}</h3>
                    <p class="mt-2 text-body-md text-on-surface-variant">{{ $card['desc'] }}</p>
                    <span class="mt-4 inline-flex items-center gap-1 text-label-lg font-bold text-primary">
                        {{ __('messages.learn_more') }}
                        <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-0.5" aria-hidden="true">arrow_forward</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
