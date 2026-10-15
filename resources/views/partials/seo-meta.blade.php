{{-- SEO Meta Tags Partial --}}
@php
    $seoTitle = $__env->yieldContent('seo_title') ?: $__env->yieldContent('title') ?: setting('seo_title', 'RoyalWay Media — Integrated Marketing, PR & Events Agency in Uganda');
    $seoDescription = $__env->yieldContent('seo_description') ?: $__env->yieldContent('description') ?: setting('seo_description', 'RoyalWay Media is Uganda\'s 360° integrated marketing and communications agency specializing in PR, branding, events, experiential marketing and behavioral change communications.');
    $seoImage = $__env->yieldContent('seo_image') ?: setting_file_url('seo_og_image', asset('assets/img/about-1.png'));
    $canonicalUrl = $__env->yieldContent('canonical') ?: url()->current();
    $siteName = setting('site_name', 'RoyalWay Media');
@endphp

<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ Str::limit($seoDescription, 160) }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ Str::limit($seoDescription, 160) }}">
<meta property="og:url" content="{{ $canonicalUrl }}">
<meta property="og:site_name" content="{{ $siteName }}">
@if($seoImage)
<meta property="og:image" content="{{ $seoImage }}">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ Str::limit($seoDescription, 160) }}">
@if($seoImage)
<meta name="twitter:image" content="{{ $seoImage }}">
@endif

{{-- Google Search Console Verification --}}
@if($gsc = setting('google_search_console'))
<meta name="google-site-verification" content="{{ $gsc }}">
@endif

{{-- Google Analytics --}}
@if($gaId = setting('google_analytics_id'))
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ $gaId }}');
</script>
@endif
