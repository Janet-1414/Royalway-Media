{{-- Service Tile Component - Square hover card with category pill and View Service button --}}
@props(['service'])

<div class="service-tile-wrapper">
    <a href="{{ route('services.show', $service->slug) }}"
       class="service-tile"
       aria-label="{{ $service->title }}">
        @if($service->category)
            <span class="category-pill">{{ $service->category }}</span>
        @endif
        @if($service->image_url)
            <img src="{{ $service->image_url }}"
                 alt="{{ $service->title }}"
                 loading="lazy">
        @else
            <div class="service-tile-fallback">
                <i class="fas fa-concierge-bell"></i>
                <span class="fallback-chip">{{ $service->category ?? 'Service' }}</span>
            </div>
        @endif
        <div class="service-tile-overlay">
            <span class="service-tile-title">{{ $service->title }}</span>
            <i class="fas fa-arrow-right"></i>
        </div>
    </a>
    <a href="{{ route('services.show', $service->slug) }}" class="btn btn-burgundy btn-view-service w-100 mt-2">
        View Service <i class="fas fa-arrow-right ms-2"></i>
    </a>
</div>
