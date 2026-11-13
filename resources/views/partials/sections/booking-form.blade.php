<section id="booking-form" class="bg-warm-sand-light" aria-labelledby="booking-form-title">
    <div class="mx-auto max-w-3xl px-4 py-20 md:px-8">
        <h2 id="booking-form-title" class="text-headline-lg-mobile md:text-headline-lg">@lang('messages.form_title')</h2>
        <p class="mt-3 text-body-md text-on-surface-variant">@lang('messages.form_sub')</p>

        <form id="rentalForm" method="POST" action="{{ route('rental-inquiry', app()->getLocale()) }}" class="mt-8 space-y-5 rounded-xl border border-border-soft bg-pure-white p-6">
            @csrf

            <div>
                <label for="fullName" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_name') <span class="text-error" aria-hidden="true">*</span></label>
                <input id="fullName" name="name" type="text" required maxlength="100" autocomplete="name"
                       class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                <p class="mt-1 hidden text-body-sm text-error" data-error-for="name"></p>
            </div>

            <div>
                <label for="serviceType" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_service') <span class="text-error" aria-hidden="true">*</span></label>
                <select id="serviceType" name="service" required
                        class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                    <option value="">@lang('messages.field_service_placeholder')</option>
                    <option value="driver">@lang('messages.service_driver')</option>
                    <option value="selfdrive">@lang('messages.service_selfdrive')</option>
                    <option value="delivery">@lang('messages.service_delivery')</option>
                    <option value="transfer">@lang('messages.service_transfer')</option>
                </select>
                <p class="mt-1 hidden text-body-sm text-error" data-error-for="service"></p>
            </div>

            <div>
                <label for="vehicleChoice" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_vehicle')</label>
                <select id="vehicleChoice" name="vehicle"
                        class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                    <option value="">@lang('messages.field_vehicle_placeholder')</option>
                    @foreach ($vehicles as $vehicle)
                        <option value="{{ $vehicle->slug }}">{{ $vehicle->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <label for="startDate" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_date') <span class="text-error" aria-hidden="true">*</span></label>
                    <input id="startDate" name="date" type="date" required
                           class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                    <p class="mt-1 hidden text-body-sm text-error" data-error-for="date"></p>
                </div>
                <div>
                    <label for="startTime" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_time') <span class="text-error" aria-hidden="true">*</span></label>
                    <input id="startTime" name="time" type="time" required
                           class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                    <p class="mt-1 hidden text-body-sm text-error" data-error-for="time"></p>
                </div>
            </div>

            <fieldset>
                <legend class="text-label-lg font-bold text-on-surface">@lang('messages.field_duration') <span class="text-error" aria-hidden="true">*</span></legend>
                <div class="mt-2 flex gap-4">
                    <label class="flex items-center gap-2 rounded-full border border-outline px-4 py-2.5 text-body-md has-checked:border-primary has-checked:bg-sea-foam">
                        <input type="radio" name="duration" value="12" checked class="accent-primary"> @lang('messages.duration_12')
                    </label>
                    <label class="flex items-center gap-2 rounded-full border border-outline px-4 py-2.5 text-body-md has-checked:border-primary has-checked:bg-sea-foam">
                        <input type="radio" name="duration" value="24" class="accent-primary"> @lang('messages.duration_24')
                    </label>
                </div>
            </fieldset>

            <div>
                <label for="pickupLocation" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_pickup') <span class="text-error" aria-hidden="true">*</span></label>
                <input id="pickupLocation" name="pickup" type="text" required maxlength="200"
                       class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                <p class="mt-1 hidden text-body-sm text-error" data-error-for="pickup"></p>
            </div>

            {{-- Conditional: driver service → route --}}
            <div id="routeField" class="hidden">
                <label for="travelRoute" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_route') <span class="text-error" aria-hidden="true">*</span></label>
                <input id="travelRoute" name="route" type="text" maxlength="200"
                       class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                <p class="mt-1 hidden text-body-sm text-error" data-error-for="route"></p>
            </div>

            {{-- Conditional: transfer service → flight details --}}
            <div id="flightFields" class="hidden space-y-5 rounded-lg bg-secondary-container/40 p-4">
                <div>
                    <label for="flightNumber" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_flight_number') <span class="text-error" aria-hidden="true">*</span></label>
                    <input id="flightNumber" name="flight_number" type="text" maxlength="20"
                           class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                    <p class="mt-1 hidden text-body-sm text-error" data-error-for="flight_number"></p>
                </div>
                <div>
                    <label for="flightTime" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_flight_time') <span class="text-error" aria-hidden="true">*</span></label>
                    <input id="flightTime" name="flight_time" type="time"
                           class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam">
                    <p class="mt-1 hidden text-body-sm text-error" data-error-for="flight_time"></p>
                </div>
            </div>

            {{-- Conditional: self-drive → S&K notice only (PRD §5.2) --}}
            <div id="lepasKunciNotice" class="hidden rounded-lg bg-sea-foam p-4 text-body-sm text-deep-teal" role="note">
                <span class="material-symbols-outlined mr-1 align-[-4px] text-[18px]" aria-hidden="true">info</span>
                @lang('messages.selfdrive_notice')
            </div>

            <div>
                <label for="extraNotes" class="block text-label-lg font-bold text-on-surface">@lang('messages.field_notes')</label>
                <textarea id="extraNotes" name="notes" rows="3" maxlength="500"
                          class="mt-1 w-full rounded-lg border border-outline bg-surface px-4 py-3 text-body-md focus:border-primary focus:outline-none focus:ring-2 focus:ring-sea-foam"></textarea>
                <p class="mt-1 text-body-sm text-on-surface-variant">@lang('messages.field_notes_hint')</p>
                <p class="mt-1 hidden text-body-sm text-error" data-error-for="notes"></p>
            </div>

            <button type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-whatsapp-green px-5 py-3.5 text-label-lg font-bold text-white shadow-[0_4px_16px_rgba(37,211,102,0.25)] transition-all hover:-translate-y-0.5 hover:bg-whatsapp-green-hover active:translate-y-0 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-50">
                <span class="material-symbols-outlined text-[20px]" aria-hidden="true">send</span>
                @lang('messages.form_submit')
            </button>

            {{-- Mandatory send-step notice (PRD §10.6): never implies a confirmed booking. --}}
            <p class="rounded-lg bg-surface-container p-4 text-body-sm text-on-surface-variant" role="note">
                <span class="material-symbols-outlined mr-1 align-[-4px] text-[18px] text-warning-amber" aria-hidden="true">privacy_tip</span>
                @lang('messages.form_notice')
            </p>
            <p class="text-body-sm text-on-surface-variant">@lang('messages.form_privacy')</p>
        </form>
    </div>
</section>
