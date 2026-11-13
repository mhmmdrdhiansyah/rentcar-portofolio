<section id="hero" class="relative flex min-h-screen flex-col items-center overflow-hidden bg-surface text-on-surface">
    {{-- Soft backdrop: the hero artwork blurred into a colour field. --}}
    <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden" aria-hidden="true">
        <picture>
            <source media="(max-width: 767px)" srcset="{{ asset('images/hero/hero-section-mobile.webp') }}" type="image/webp">
            <source media="(max-width: 767px)" srcset="{{ asset('images/hero/hero-section-mobile.png') }}" type="image/png">
            <source srcset="{{ asset('images/hero/hero-section.webp') }}" type="image/webp">
            <img
                src="{{ asset('images/hero/hero-section.png') }}"
                alt=""
                width="1376"
                height="768"
                decoding="async"
                class="h-full w-full scale-110 object-cover opacity-40 blur-2xl"
            >
        </picture>
    </div>

    {{-- Blurred accent bars (prompt layout, brand colours). --}}
    <svg
        width="358"
        height="483"
        viewBox="0 0 358 483"
        class="pointer-events-none absolute left-0 top-0 z-0"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
        aria-hidden="true"
    >
        <g filter="url(#heroBlurA)">
            <rect x="-86.9961" y="-33.114" width="72" height="541" rx="36" transform="rotate(-30.8182 -86.9961 -33.114)" fill="url(#heroBarA)" />
        </g>
        <g filter="url(#heroBlurB)">
            <rect x="-17" y="-135.113" width="50.0937" height="541" rx="25.0469" transform="rotate(-30.8182 -17 -135.113)" fill="url(#heroBarB)" />
        </g>
        <defs>
            <filter id="heroBlurA" x="-137.641" y="-120.646" width="440.285" height="602.787" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                <feGaussianBlur stdDeviation="32" result="effect1_foregroundBlur_0_1" />
            </filter>
            <filter id="heroBlurB" x="-71.707" y="-215.486" width="429.598" height="599.69" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                <feFlood flood-opacity="0" result="BackgroundImageFix" />
                <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape" />
                <feGaussianBlur stdDeviation="32" result="effect1_foregroundBlur_0_1" />
            </filter>
            <linearGradient id="heroBarA" x1="-50.9961" y1="-33.114" x2="-50.9961" y2="507.886" gradientUnits="userSpaceOnUse">
                <stop stop-color="#087E83" />
                <stop offset="1" stop-color="#E6F1FF" />
            </linearGradient>
            <linearGradient id="heroBarB" x1="8.04686" y1="-135.113" x2="8.04686" y2="405.887" gradientUnits="userSpaceOnUse">
                <stop stop-color="#3D5E67" />
                <stop offset="1" stop-color="#D9F0EA" />
            </linearGradient>
        </defs>
    </svg>

    {{-- Gradient wash over the artwork. --}}
    <div class="pointer-events-none absolute inset-x-0 top-0 z-0 h-[600px] bg-linear-to-b from-sea-foam via-surface to-transparent" aria-hidden="true"></div>

    @include('partials.header')

    <div class="relative z-10 flex flex-col items-center gap-6 px-4 pb-16 pt-20 text-center">
        <div class="inline-flex w-fit items-center gap-2 rounded-full border-2 border-pure-white bg-pure-white px-1.5 py-1 shadow-lg shadow-primary/20" data-hero-item="2">
            <span class="rounded-full bg-linear-to-br from-primary to-primary-container px-2 py-0.5 text-label-sm font-semibold uppercase tracking-widest text-white">
                @lang('messages.hero_badge_chip')
            </span>
            <span class="hidden pr-2 text-body-sm font-medium sm:inline">
                @lang('messages.hero_badge')
            </span>
            <span class="pr-2 text-body-sm font-medium sm:hidden">
                @lang('messages.hero_badge_short')
            </span>
        </div>

        <h1 class="max-w-6xl text-5xl font-extrabold tracking-tight text-on-surface sm:text-6xl md:text-7xl xl:text-8xl" data-hero-item="3">
            @lang('messages.hero_h1')
        </h1>

        <p class="mx-auto max-w-3xl px-4 text-body-lg font-medium leading-relaxed text-on-surface-variant md:text-2xl" data-hero-item="4">
            @lang('messages.hero_sub')
        </p>

        <div class="flex flex-wrap justify-center gap-4">
            <x-wa-button placement="hero" data-hero-item="5" />
            <a
                href="#fleet"
                data-hero-item="6"
                class="inline-flex items-center justify-center gap-2 rounded-full border border-neutral-300 bg-linear-to-br from-neutral-50 via-neutral-100 to-neutral-300 px-5 py-2.5 text-label-lg font-bold text-on-surface shadow-sm transition-all hover:-translate-y-0.5 hover:bg-neutral-100 active:translate-y-0 active:scale-[0.98]"
            >
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">directions_car</span>
                @lang('messages.cta_fleet')
            </a>
        </div>
    </div>

    {{-- Framed hero artwork. --}}
    <div class="relative z-10 mt-4 w-full max-w-7xl px-4 pb-0" data-hero-item="7">
        <div class="rounded-2xl bg-pure-white/50 p-4 backdrop-blur-lg">
            <picture>
                <source media="(max-width: 767px)" srcset="{{ asset('images/hero/hero-section-mobile.webp') }}" type="image/webp">
                <source media="(max-width: 767px)" srcset="{{ asset('images/hero/hero-section-mobile.png') }}" type="image/png">
                <source srcset="{{ asset('images/hero/hero-section.webp') }}" type="image/webp">
                <img
                    src="{{ asset('images/hero/hero-section.png') }}"
                    alt="@lang('messages.hero_img_alt')"
                    width="1376"
                    height="768"
                    fetchpriority="high"
                    decoding="async"
                    class="aspect-[768/1376] w-full rounded-2xl object-cover md:aspect-[1376/768]"
                >
            </picture>
        </div>
    </div>
</section>
