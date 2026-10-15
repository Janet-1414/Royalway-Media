{{-- Service Tile Component - Square hover card --}}
@props(['service'])

<a href="{{ route('services.show', $service->slug) }}"
   class="service-tile"
   aria-label="{{ $service->title }}">
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
