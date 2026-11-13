<section id="faq" class="bg-warm-sand-light" aria-labelledby="faq-title">
    <div class="mx-auto max-w-3xl px-4 py-20 md:px-8">
        <h2 id="faq-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.faq_title')</h2>

        <div id="faqAccordion" class="mt-10 divide-y divide-outline-variant/50 rounded-xl border border-border-soft bg-pure-white">
            @foreach ([
                ['q' => __('messages.faq_1_q'), 'a' => __('messages.faq_1_a')],
                ['q' => __('messages.faq_2_q'), 'a' => __('messages.faq_2_a')],
                ['q' => __('messages.faq_3_q'), 'a' => __('messages.faq_3_a')],
                ['q' => __('messages.faq_4_q'), 'a' => __('messages.faq_4_a')],
                ['q' => __('messages.faq_5_q'), 'a' => __('messages.faq_5_a')],
            ] as $item)
                <div>
                    <h3>
                        <button
                            type="button"
                            class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left text-headline-sm font-semibold text-on-surface transition-colors hover:text-primary"
                            aria-expanded="false"
                            data-faq-button
                        >
                            <span>{{ $item['q'] }}</span>
                            <span class="material-symbols-outlined shrink-0 text-[22px] text-primary transition-transform" aria-hidden="true">expand_more</span>
                        </button>
                    </h3>
                    <div class="faq-panel px-6 text-body-md text-on-surface-variant" data-faq-panel>
                        <div class="faq-panel-clip">
                            <div class="pb-5">{{ $item['a'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
