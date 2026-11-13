<meta name="description" content="@yield('meta_description', __('messages.meta_description'))">
<link rel="canonical" href="{{ \App\Support\Seo::canonical() }}">
@foreach (\App\Support\Seo::alternates() as $locale => $url)
    <link rel="alternate" hreflang="{{ $locale }}" href="{{ $url }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ \App\Support\Seo::canonical() }}">
@yield('structured_data')
