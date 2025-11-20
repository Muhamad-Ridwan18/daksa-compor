@php
    $seo = $seoData ?? [];
@endphp

{{-- Basic Meta Tags --}}
<title>{{ $seo['meta_title'] ?? 'Daksa Company Profile' }}</title>
<meta name="description" content="{{ $seo['meta_description'] ?? 'Website Company Profile Daksa' }}">
@if(!empty($seo['meta_keywords']))
    <meta name="keywords" content="{{ $seo['meta_keywords'] }}">
@endif
<meta name="robots" content="{{ $seo['meta_robots'] ?? 'index,follow' }}">
@if(!empty($seo['canonical_url']))
    <link rel="canonical" href="{{ $seo['canonical_url'] }}">
@endif

{{-- Open Graph Tags --}}
<meta property="og:type" content="{{ $seo['og_type'] ?? 'website' }}">
<meta property="og:title" content="{{ $seo['og_title'] ?? $seo['meta_title'] ?? 'Daksa Company Profile' }}">
<meta property="og:description" content="{{ $seo['og_description'] ?? $seo['meta_description'] ?? 'Website Company Profile Daksa' }}">
@if(!empty($seo['og_image']))
    <meta property="og:image" content="{{ $seo['og_image'] }}">
@endif
@if(!empty($seo['og_url']))
    <meta property="og:url" content="{{ $seo['og_url'] }}">
@endif
@if(!empty($seo['og_site_name']))
    <meta property="og:site_name" content="{{ $seo['og_site_name'] }}">
@endif

{{-- Twitter Card Tags --}}
<meta name="twitter:card" content="{{ $seo['twitter_card'] ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $seo['twitter_title'] ?? $seo['meta_title'] ?? 'Daksa Company Profile' }}">
<meta name="twitter:description" content="{{ $seo['twitter_description'] ?? $seo['meta_description'] ?? 'Website Company Profile Daksa' }}">
@if(!empty($seo['twitter_image']))
    <meta name="twitter:image" content="{{ $seo['twitter_image'] }}">
@endif
@if(!empty($seo['twitter_site']))
    <meta name="twitter:site" content="{{ $seo['twitter_site'] }}">
@endif
@if(!empty($seo['twitter_creator']))
    <meta name="twitter:creator" content="{{ $seo['twitter_creator'] }}">
@endif

{{-- Schema.org JSON-LD --}}
@if(!empty($seo['schema_json']))
    <script type="application/ld+json">
        {!! json_encode($seo['schema_json'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endif
