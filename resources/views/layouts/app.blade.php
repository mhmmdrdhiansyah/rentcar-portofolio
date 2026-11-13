<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-type="place">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('business.name'))</title>
    @include('partials.meta')
    <meta name="theme-color" content="#006367">
    <link rel="icon" type="image/png" href="{{ asset('images/just-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Plus Jakarta Sans + Material Symbols (design.md §2) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface font-sans text-body-md text-on-surface antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-full focus:bg-primary focus:px-5 focus:py-2.5 focus:text-white">
        @lang('messages.skip_to_content')
    </a>

    <main id="main" class="w-full">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.floating-whatsapp')

    @stack('head_scripts')
    @if ($ga4 = env('GA4_ID'))
        {{-- GA4 only when configured; deferred so it never blocks render (design.md §8, antislop R-40). --}}
        <script defer src="https://www.googletagmanager.com/gtag/js?id={{ $ga4 }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $ga4 }}');
        </script>
    @endif
    @stack('scripts')
</body>
</html>
