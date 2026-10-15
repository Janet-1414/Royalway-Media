{{-- Structured Data (JSON-LD) --}}
@php
    $siteName = setting('site_name', 'RoyalWay Media');
    $siteUrl = config('app.url', 'https://royalwaymedia.com');
    $logo = setting_file_url('logo', asset('assets/img/logo.svg'));
    $email = setting('contact_email', 'sales@royalwaymedia.com');
    $address = setting('address', 'Plot 23, Cooper Road, Kisementi-Kololo, Kampala, Uganda');
    $phones = setting_phones();
    $phone = !empty($phones) ? ($phones[0]['number'] ?? '+256 772 464 686') : '+256 772 464 686';
    $hours = setting('office_hours', 'Mon – Fri: 8:00am – 6:00pm');

    // Social URLs
    $socialUrls = array_filter([
        setting('social_facebook'),
        setting('social_twitter'),
        setting('social_linkedin'),
        setting('social_instagram'),
        setting('social_youtube'),
    ]);

    // Organization Schema
    $organization = [
        '@context' => 'https://schema.org',
        '@type' => ['Organization', 'LocalBusiness', 'MarketingAgency'],
        '@id' => $siteUrl . '/#organization',
        'name' => $siteName,
        'url' => $siteUrl,
        'logo' => $logo,
        'email' => $email,
        'telephone' => $phone,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => 'Plot 23, Cooper Road, Kisementi-Kololo',
            'addressLocality' => 'Kampala',
            'addressCountry' => 'UG',
            'postalCode' => '70348',
        ],
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => 0.3390889,
            'longitude' => 32.5882796,
        ],
        'openingHours' => 'Mo-Fr 08:00-18:00',
        'sameAs' => $socialUrls,
        'description' => setting('seo_description', 'RoyalWay Media is Uganda\'s 360° integrated marketing and communications agency.'),
    ];
@endphp

{{-- Organization + LocalBusiness Schema --}}
<script type="application/ld+json">
{!! json_encode($organization, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

{{-- Breadcrumb Schema (if breadcrumbs provided) --}}
@if(isset($breadcrumbs) && count($breadcrumbs) > 0)
@php
    $breadcrumbList = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [],
    ];
    foreach ($breadcrumbs as $index => $crumb) {
        $breadcrumbList['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $crumb['name'],
            'item' => $crumb['url'] ?? null,
        ];
    }
@endphp
<script type="application/ld+json">
{!! json_encode($breadcrumbList, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif

{{-- Service Schema --}}
@if(isset($service) && $service)
@php
    $serviceSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Service',
        'name' => $service->title,
        'description' => $service->short_description ?? $service->intro ?? '',
        'provider' => [
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => $siteUrl,
        ],
        'areaServed' => 'Uganda',
        'url' => route('services.show', $service->slug),
    ];
    if ($service->image_url) {
        $serviceSchema['image'] = $service->image_url;
    }
@endphp
<script type="application/ld+json">
{!! json_encode($serviceSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif

{{-- CreativeWork Schema for Projects --}}
@if(isset($project) && $project)
@php
    $projectSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CreativeWork',
        'name' => $project->title,
        'description' => $project->description ?? '',
        'creator' => [
            '@type' => 'Organization',
            'name' => $siteName,
        ],
        'url' => route('projects.show', $project->slug),
    ];
    if ($project->image_url) {
        $projectSchema['image'] = $project->image_url;
    }
    if ($project->client) {
        $projectSchema['about'] = $project->client;
    }
    if ($project->project_date) {
        $projectSchema['dateCreated'] = $project->project_date->format('Y-m-d');
    }
@endphp
<script type="application/ld+json">
{!! json_encode($projectSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endif
