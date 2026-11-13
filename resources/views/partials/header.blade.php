@php
    // One shared nav list for desktop and mobile menus.
    $navItems = [
        'hero' => __('messages.nav_home'),
        'services' => __('messages.nav_services'),
        'fleet' => __('messages.nav_fleet'),
        'area' => __('messages.nav_area'),
        'about' => __('messages.nav_about'),
        'faq' => __('messages.nav_faq'),
    ];
@endphp
<header class="relative z-20 mt-4 w-full max-w-7xl px-3 sm:px-2" data-hero-item="1">
    <div class="flex items-center justify-between gap-3 rounded-xl border border-pure-white bg-pure-white/80 p-2 shadow-sm backdrop-blur-xl">
        <a href="{{ url('/'.app()->getLocale()) }}" class="flex min-w-0 shrink items-center pl-1">
            <span class="whitespace-nowrap text-base font-bold tracking-tight text-deep-teal sm:text-xl">@lang('messages.brand_name')</span>
        </a>

        <nav class="hidden items-center gap-10 whitespace-nowrap text-label-lg font-semibold text-on-surface-variant xl:flex" aria-label="{{ __('messages.nav_label') }}">
            @foreach ($navItems as $anchor => $label)
                <a
                    href="#{{ $anchor }}"
                    class="transition-colors hover:text-primary"
                >{{ $label }}</a>
            @endforeach
        </nav>

        <div class="flex shrink-0 items-center gap-2">
            {{-- Language switch: same route, other locale prefix. --}}
            <div class="hidden items-center rounded-full bg-surface-container/80 px-2 py-1 text-label-sm xl:flex">
                @foreach (config('business.supported_locales') as $loc)
                    @if ($loc === app()->getLocale())
                        <span class="rounded-full bg-pure-white px-2 py-0.5 font-bold text-primary shadow-[0_1px_4px_rgba(24,59,67,0.08)]">{{ strtoupper($loc) }}</span>
                    @else
                        <a href="{{ str_replace('/'.app()->getLocale(), '/'.$loc, url()->current()) }}" class="px-2 py-0.5 text-on-surface-variant transition-colors hover:text-on-surface" hreflang="{{ $loc }}">{{ strtoupper($loc) }}</a>
                    @endif
                @endforeach
            </div>

            <button
                type="button"
                class="inline-flex size-11 items-center justify-center rounded-xl xl:hidden"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="{{ __('messages.menu_open') }}"
                data-menu-button
            >
                <span class="material-symbols-outlined text-[24px]" aria-hidden="true">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile drawer: slides in from the left (prompt layout). --}}
    <div id="mobile-menu" class="fixed inset-0 z-[60] xl:hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-deep-teal/40 backdrop-blur-sm" data-menu-backdrop></div>
        <div
            class="absolute inset-y-0 left-0 flex w-[300px] max-w-[85vw] flex-col bg-pure-white shadow-2xl"
            role="dialog"
            aria-modal="true"
            aria-label="{{ __('messages.nav_label') }}"
            data-menu-panel
        >
            <div class="flex items-center justify-between gap-3 border-b border-neutral-200 p-4">
                <span class="text-base font-bold tracking-tight text-deep-teal">@lang('messages.brand_name')</span>
                <button
                    type="button"
                    class="inline-flex size-9 items-center justify-center rounded-full bg-neutral-800 text-pure-white"
                    aria-label="{{ __('messages.menu_close') }}"
                    data-menu-close
                >
                    <span class="material-symbols-outlined text-[20px]" aria-hidden="true">close</span>
                </button>
            </div>

            <nav class="flex flex-1 flex-col gap-1 overflow-y-auto p-4" aria-label="{{ __('messages.nav_label') }}">
                @foreach ($navItems as $anchor => $label)
                    <a
                        href="#{{ $anchor }}"
                        class="rounded-sm p-2 text-headline-sm text-on-surface transition-colors hover:bg-neutral-200"
                        data-menu-link
                    >{{ $label }}</a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2 border-t border-neutral-200 p-4">
                @foreach (config('business.supported_locales') as $loc)
                    @if ($loc === app()->getLocale())
                        <span class="rounded-full bg-primary px-3 py-1 text-label-sm font-bold text-white">{{ strtoupper($loc) }}</span>
                    @else
                        <a href="{{ str_replace('/'.app()->getLocale(), '/'.$loc, url()->current()) }}" class="rounded-full border border-outline-variant px-3 py-1 text-label-sm font-bold text-on-surface-variant" hreflang="{{ $loc }}">{{ strtoupper($loc) }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</header>
