<footer class="bg-warm-sand-light">
    <div class="mx-auto w-full max-w-7xl px-4 pb-10 pt-16 md:px-8">
        <div class="grid grid-cols-1 gap-12 pb-12 md:grid-cols-2 lg:grid-cols-4">
            <div class="space-y-4">
                <img src="{{ asset('images/logo-text-side.png') }}" alt="{{ __('messages.brand_name') }}" class="h-16 w-auto object-contain">
                <p class="text-body-sm text-on-surface-variant">@lang('messages.footer_blurb')</p>
                <p class="inline-flex items-center gap-1.5 rounded-full bg-secondary-container px-3 py-1.5 text-label-sm text-on-secondary-container">
                    <span class="material-symbols-outlined text-[16px]" aria-hidden="true">verified</span>
                    @lang('messages.footer_chip')
                </p>
            </div>

            <nav aria-label="{{ __('messages.nav_services') }}">
                <p class="mb-4 font-bold text-label-lg text-on-surface">@lang('messages.footer_services_title')</p>
                <ul class="space-y-2">
                    @foreach ([
                        __('messages.service_driver'),
                        __('messages.service_selfdrive'),
                        __('messages.service_delivery'),
                        __('messages.service_transfer'),
                    ] as $service)
                        <li class="text-body-sm">
                            <a href="#booking-form" class="text-on-surface-variant transition-colors hover:text-primary">{{ $service }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <nav aria-label="{{ __('messages.nav_area') }}">
                <p class="mb-4 font-bold text-label-lg text-on-surface">@lang('messages.footer_area_title')</p>
                <ul class="space-y-2">
                    @foreach ([
                        __('messages.area_tanjungpandan'),
                        __('messages.area_airport'),
                        __('messages.area_manggar'),
                        __('messages.area_island'),
                    ] as $area)
                        <li class="text-body-sm">
                            <a href="#area" class="text-on-surface-variant transition-colors hover:text-primary">{{ $area }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="space-y-4">
                {{-- TODO-10: operating hours pending owner confirmation — only the honest no-office note is shown. --}}
                <div>
                    <p class="mb-1 font-bold text-label-lg text-on-surface">@lang('messages.footer_ops_title')</p>
                    <p class="text-body-sm text-on-surface-variant">@lang('messages.footer_ops_note')</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center justify-between gap-4 border-t border-outline-variant/50 pt-8 text-body-sm text-on-surface-variant md:flex-row">
            <p>&copy; {{ date('Y') }} Let's Ride Belitung</p>
            <p class="text-center text-label-sm md:text-right">@lang('messages.footer_legal')</p>
        </div>
    </div>
</footer>
