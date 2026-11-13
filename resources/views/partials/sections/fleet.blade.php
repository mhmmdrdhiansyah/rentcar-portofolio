<section id="fleet" class="bg-warm-sand-light" aria-labelledby="fleet-title">
    <div class="mx-auto max-w-7xl px-4 py-20 md:px-8">
        <h2 id="fleet-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.fleet_title')</h2>
        <div class="mt-10 flex items-start justify-between gap-4">
            <div class="min-w-0 flex-1">
                <p class="max-w-2xl text-body-md text-on-surface-variant">@lang('messages.fleet_sub')</p>
            </div>
            {{-- Rail scroll controls (Material Symbols, template card language) --}}
            <div class="flex shrink-0 gap-2">
                <button
                    type="button"
                    data-fleet-prev
                    aria-label="@lang('messages.fleet_prev')"
                    class="fleet-rail-button inline-flex size-11 items-center justify-center rounded-full border border-border-soft bg-pure-white text-deep-teal shadow-sm transition-all hover:-translate-y-0.5 hover:text-primary"
                >
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">chevron_left</span>
                </button>
                <button
                    type="button"
                    data-fleet-next
                    aria-label="@lang('messages.fleet_next')"
                    class="fleet-rail-button inline-flex size-11 items-center justify-center rounded-full border border-border-soft bg-pure-white text-deep-teal shadow-sm transition-all hover:-translate-y-0.5 hover:text-primary"
                >
                    <span class="material-symbols-outlined text-[22px]" aria-hidden="true">chevron_right</span>
                </button>
            </div>
        </div>

        {{-- Horizontal scroll-snap browse: cards scroll as one rail (design.md §5.5). --}}
        <div
            id="fleet-rail"
            class="fleet-rail mt-10"
            role="region"
            tabindex="0"
            aria-label="@lang('messages.fleet_title')"
        >
            @forelse ($vehicles as $vehicle)
                {{-- TODO-05: no unit photo yet — honest category placeholder, never a wrong-unit photo. --}}
                <article class="fleet-card group flex flex-col overflow-hidden rounded-xl border border-border-soft bg-pure-white transition-transform hover:-translate-y-0.5 hover:shadow-[0_4px_16px_rgba(24,59,67,0.08)]">
                    @php
                        // Photo per unit in public/images/fleet/{slug}.png; honest placeholder when no photo exists (TODO-05).
                        $photo = 'images/fleet/'.$vehicle->slug.'.png';
                    @endphp
                    @if (file_exists(public_path($photo)))
                        <img src="{{ asset($photo) }}" alt="{{ $vehicle->name }}" class="aspect-[16/10] w-full object-cover" loading="lazy">
                    @else
                        <div class="flex aspect-[16/10] items-center justify-center bg-surface-container">
                            <span class="material-symbols-outlined text-[48px] text-outline-variant" aria-hidden="true">directions_car</span>
                        </div>
                    @endif
                    <div class="flex flex-1 flex-col p-5">
                        <p class="text-label-md text-on-surface-variant">{{ $vehicle->vehicleCategory->name }}</p>
                        <h3 class="mt-1 text-headline-md">{{ $vehicle->name }}</h3>

                        <div class="mt-3 flex flex-wrap gap-2">
                            @if ($vehicle->with_driver)
                                <span class="rounded-full bg-secondary-container px-3 py-1 text-label-sm text-on-secondary-container">@lang('messages.mode_driver')</span>
                            @endif
                            @if ($vehicle->self_drive)
                                <span class="rounded-full bg-sea-foam px-3 py-1 text-label-sm text-deep-teal">@lang('messages.mode_selfdrive')</span>
                            @endif
                        </div>

                        <a
                            href="#booking-form"
                            data-vehicle="{{ $vehicle->slug }}"
                            class="mt-5 inline-flex items-center justify-center gap-2 rounded-full bg-primary px-5 py-2.5 text-label-lg font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-surface-tint active:translate-y-0 active:scale-[0.98]"
                        >
                            @lang('messages.cta_ask_vehicle')
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-body-md text-on-surface-variant">@lang('messages.fleet_empty')</p>
            @endforelse
        </div>
    </div>
</section>
