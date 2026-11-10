{{--
    Shared CMS hero for News & Insights, Communication Assets and Policies.
    Usage: @include('partials.page-hero', ['hero' => $hero, 'eyebrow' => '...', 'icon' => 'fa-newspaper', 'actions' => [...]])
    Each action: ['label' => '...', 'url' => '...', 'style' => 'primary' or 'ghost']
--}}
@php
    $heroImage = $hero->image_url;
    $actions = $actions ?? [];
@endphp

<section class="in-hero ph-hero">
    <div class="container">
        <div class="row g-4 g-lg-5 align-items-center">
            <div class="col-lg-5">
                <div class="ph-media{{ $heroImage ? '' : ' ph-media--fallback' }}">
                    @if($heroImage)
                        <img src="{{ $heroImage }}" alt="{{ $hero->heading }}">
                    @else
                        <span class="ph-mark" aria-hidden="true"><i class="fas {{ $icon ?? 'fa-feather-pointed' }}"></i></span>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="in-hero-text">
                    @if(!empty($eyebrow))
                        <span class="in-eyebrow">{{ $eyebrow }}</span>
                    @endif
                    <h1 class="in-hero-title">{{ $hero->heading }}</h1>
                    <div class="in-rule"></div>
                    @if(filled($hero->intro))
                        <p>{{ $hero->intro }}</p>
                    @endif
                    @if(count($actions))
                        <div class="in-hero-actions">
                            @foreach($actions as $action)
                                @if(($action['style'] ?? 'primary') === 'ghost')
                                    <a href="{{ $action['url'] }}" class="in-ghost">{{ $action['label'] }} <i class="fas fa-arrow-right ms-1" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{ $action['url'] }}" class="btn btn-burgundy fw-semibold px-4 py-2 mb-0">{{ $action['label'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
