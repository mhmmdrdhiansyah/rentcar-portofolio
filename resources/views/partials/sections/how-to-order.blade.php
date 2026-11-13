<section id="how-to-order" class="bg-surface" aria-labelledby="how-to-title">
    <div class="mx-auto max-w-7xl px-4 py-20 md:px-8">
        <h2 id="how-to-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.howto_title')</h2>

        <ol class="mt-10 grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['title' => __('messages.howto_1_title'), 'desc' => __('messages.howto_1_desc')],
                ['title' => __('messages.howto_2_title'), 'desc' => __('messages.howto_2_desc')],
                ['title' => __('messages.howto_3_title'), 'desc' => __('messages.howto_3_desc')],
                ['title' => __('messages.howto_4_title'), 'desc' => __('messages.howto_4_desc')],
            ] as $i => $step)
                <li class="flex gap-4">
                    <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-full bg-primary text-label-lg font-bold text-white" aria-hidden="true">{{ $i + 1 }}</span>
                    <div>
                        <h3 class="text-headline-sm">{{ $step['title'] }}</h3>
                        <p class="mt-1 text-body-sm text-on-surface-variant">{{ $step['desc'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>
