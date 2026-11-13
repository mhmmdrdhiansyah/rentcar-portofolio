<section id="about" class="bg-surface" aria-labelledby="advantages-title">
    <div class="mx-auto max-w-7xl px-4 py-20 md:px-8">
        <h2 id="advantages-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.advantages_title')</h2>

        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                'diversity' => ['icon' => 'garage', 'title' => __('messages.adv_fleet'), 'desc' => __('messages.adv_fleet_desc')],
                'whatsapp' => ['icon' => 'chat', 'title' => __('messages.adv_whatsapp'), 'desc' => __('messages.adv_whatsapp_desc')],
                'professional' => ['icon' => 'workspace_premium', 'title' => __('messages.adv_service'), 'desc' => __('messages.adv_service_desc')],
                'pricing' => ['icon' => 'sell', 'title' => __('messages.adv_pricing'), 'desc' => __('messages.adv_pricing_desc')],
                'clean' => ['icon' => 'local_car_wash', 'title' => __('messages.adv_clean'), 'desc' => __('messages.adv_clean_desc')],
                'delivery' => ['icon' => 'map', 'title' => __('messages.adv_delivery'), 'desc' => __('messages.adv_delivery_desc')],
                'responsive' => ['icon' => 'support_agent', 'title' => __('messages.adv_responsive'), 'desc' => __('messages.adv_responsive_desc')],
                'flexible' => ['icon' => 'swap_horiz', 'title' => __('messages.adv_flexible'), 'desc' => __('messages.adv_flexible_desc')],
            ] as $advantage)
                <div class="flex gap-4">
                    <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-full bg-sea-foam text-primary">
                        <span class="material-symbols-outlined text-[22px]" aria-hidden="true">{{ $advantage['icon'] }}</span>
                    </span>
                    <div>
                        <h3 class="text-headline-sm">{{ $advantage['title'] }}</h3>
                        <p class="mt-1 text-body-sm text-on-surface-variant">{{ $advantage['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
