<section id="area" class="bg-warm-sand-light" aria-labelledby="area-title">
    <div class="mx-auto max-w-7xl px-4 py-20 md:px-8">
        <h2 id="area-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.area_title')</h2>
        <p class="mt-3 max-w-2xl text-body-md text-on-surface-variant">@lang('messages.area_sub')</p>

        {{-- No office address exists: area descriptions only (PRD §6). --}}
        <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-border-soft bg-pure-white p-6">
                <span class="material-symbols-outlined text-[24px] text-primary" aria-hidden="true">location_on</span>
                <h3 class="mt-3 text-headline-sm">@lang('messages.area_tanjungpandan')</h3>
                <p class="mt-2 text-body-sm text-on-surface-variant">@lang('messages.area_tanjungpandan_desc')</p>
            </div>
            <div class="rounded-xl border border-border-soft bg-pure-white p-6">
                <span class="material-symbols-outlined text-[24px] text-primary" aria-hidden="true">flight_land</span>
                <h3 class="mt-3 text-headline-sm">@lang('messages.area_airport')</h3>
                <p class="mt-2 text-body-sm text-on-surface-variant">@lang('messages.area_airport_desc')</p>
            </div>
            <div class="rounded-xl border border-border-soft bg-pure-white p-6">
                <span class="material-symbols-outlined text-[24px] text-primary" aria-hidden="true">terrain</span>
                <h3 class="mt-3 text-headline-sm">@lang('messages.area_island')</h3>
                <p class="mt-2 text-body-sm text-on-surface-variant">@lang('messages.area_island_desc')</p>
            </div>
            <div class="rounded-xl border border-border-soft bg-pure-white p-6">
                <span class="material-symbols-outlined text-[24px] text-primary" aria-hidden="true">signpost</span>
                <h3 class="mt-3 text-headline-sm">@lang('messages.area_manggar')</h3>
                <p class="mt-2 text-body-sm text-on-surface-variant">@lang('messages.area_manggar_desc')</p>
            </div>
        </div>
    </div>
</section>
