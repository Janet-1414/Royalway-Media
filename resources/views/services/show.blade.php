{{-- File Path: resources/views/services/show.blade.php --}}

@extends('layouts.app')

@section('title', $service->title . ' - RoyalWay Media')

@php
    // Rich text editors can save "<p></p>" for an empty field, so test for visible content
    $isBlank = fn ($html) => trim(strip_tags((string) $html, '<img><iframe><video>')) === '';

    $fullDescription = $isBlank($service->full_description) ? null : $service->full_description;
    $cta = \App\Models\Service::splitCta($service->content);

    $checklistItems = $service->checklist_items;
    $offerItems = $service->offer_items;
    $heroImages = $service->hero_images;
    $videoEmbed = $service->video_embed_url;

    // Desktop column classes that keep the last row of the 3-column grid full
    $offerCount = count($offerItems);
    $offerRemainder = $offerCount % 3;
    $offerWideFrom = match (true) {
        $offerCount === 1 => 0,
        $offerRemainder === 2 => $offerCount - 2,
        $offerRemainder === 1 => $offerCount - 4,
        default => $offerCount,
    };
@endphp

@section('content')

    <!-- A. HERO -->
    <section class="service-hero{{ $videoEmbed ? ' has-video' : '' }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 service-hero-text">
                    @if($service->category)
                        <p class="text-uppercase text-warning fw-semibold mb-2 small">{{ $service->category }}</p>
                    @endif
                    <h1 class="service-hero-title">{{ $service->title }}</h1>
                    @if($service->tagline)
                        <p class="service-hero-tagline">{{ $service->tagline }}</p>
                    @endif
                    @if($service->short_description)
                        <p class="service-hero-summary">{{ $service->short_description }}</p>
                    @endif
                    <a href="{{ route('contact.index') }}" class="btn btn-warning mt-2 fw-semibold px-4">Get In Touch</a>
                </div>
                <div class="col-lg-6">
                    <div class="service-hero-media">
                        @if($videoEmbed)
                            <div class="service-hero-video">
                                <iframe src="{{ $videoEmbed }}"
                                        title="{{ $service->title }} video"
                                        loading="lazy"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                                        allowfullscreen></iframe>
                            </div>
                        @elseif(count($heroImages) > 0)
                            <div class="service-hero-slides" @if(count($heroImages) > 1) data-slideshow @endif>
                                @foreach($heroImages as $i => $imageUrl)
                                    <img src="{{ $imageUrl }}"
                                         alt="{{ $service->title }}{{ count($heroImages) > 1 ? ' - work sample ' . ($i + 1) : '' }}"
                                         class="{{ $i === 0 ? 'is-active' : '' }}"
                                         @if($i > 0) loading="lazy" @endif>
                                @endforeach
                            </div>
                        @else
                            <div class="service-hero-placeholder"></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- B. INTRODUCTION + CHECKLIST -->
    @if($service->intro || count($checklistItems) > 0)
        <section class="service-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        @if($service->intro)
                            <p class="section-intro service-lead">{!! nl2br(e($service->intro)) !!}</p>
                        @endif
                        @if(count($checklistItems) > 0)
                            <ul class="service-checklist">
                                @foreach($checklistItems as $item)
                                    <li><i class="fas fa-check"></i><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- C. WHAT WE OFFER -->
    @if($offerCount > 0)
        <section class="service-section bg-light">
            <div class="container">
                <h2 class="service-section-title text-center mb-4">What We Offer</h2>
                <div class="row g-3 g-lg-4 justify-content-center">
                    @foreach($offerItems as $i => $item)
                        <div class="col-md-6 {{ $i >= $offerWideFrom ? 'col-lg-6' : 'col-lg-4' }}">
                            <div class="offer-card">
                                <span class="offer-card-icon"><i class="fas fa-check"></i></span>
                                <div>
                                    <h3 class="offer-card-title">{{ $item['title'] }}</h3>
                                    @if($item['description'])
                                        <p class="offer-card-text">{{ $item['description'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- D. FULL DESCRIPTION -->
    @if($fullDescription)
        <section class="service-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="service-body">{!! $fullDescription !!}</div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- E. EXTENDED CONTENT CTA -->
    @if($cta)
        <section class="service-section">
            <div class="container">
                <div class="service-cta-panel">
                    <h2 class="service-cta-heading">{{ $cta['heading'] }}</h2>
                    @if($cta['body'])
                        <div class="service-cta-text">{!! $cta['body'] !!}</div>
                    @endif
                    <a href="{{ route('contact.index') }}" class="btn btn-burgundy btn-lg fw-semibold px-4">
                        Talk to Our Team <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- F. RELATED PROJECTS -->
    @if($projects->count() > 0)
        <section class="service-section bg-light">
            <div class="container">
                <div class="section-header mb-4">
                    <h2 class="service-section-title">Projects Under This Service</h2>
                    <a href="{{ route('projects.index') }}" class="cta-link">View all projects <i class="fas fa-arrow-right ms-2"></i></a>
                </div>
                <div class="row g-4">
                    @foreach($projects->take(3) as $project)
                        <div class="col-lg-4 col-md-6 col-12">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none">
                                <div class="project-card">
                                    <div class="project-image">
                                        @if($project->image_url)
                                            <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="img-fluid">
                                        @else
                                            @include('components.card-fallback', ['type' => 'project', 'icon' => 'fa-briefcase'])
                                        @endif
                                    </div>
                                    <div class="project-content">
                                        <span class="project-tag">{{ $project->category }}</span>
                                        <p class="fw-700 text-dark-emphasis mb-2">{{ $project->title }}</p>
                                        <p class="text-muted mb-3">{{ Str::limit($project->description, 100) }}</p>
                                        <span class="cta-link">Learn More <i class="fas fa-arrow-right ms-2"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- G. OTHER SERVICES -->
    @if($otherServices->count() > 0)
        <section class="service-section">
            <div class="container">
                <div class="section-header mb-3">
                    <h2 class="service-section-title">Other Services</h2>
                </div>
                <div class="other-services-scroll">
                    <div class="other-services-track">
                        @foreach($otherServices as $otherService)
                            <a href="{{ route('services.show', $otherService->slug) }}" class="text-decoration-none">
                                <div class="project-card">
                                    <div class="project-image">
                                        <img src="{{ asset('storage/' . $otherService->image) }}" alt="{{ $otherService->title }}" class="img-fluid" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('assets/img/about-1.png') }}';">
                                    </div>
                                    <div class="project-content">
                                        <p class="fw-700 text-dark-emphasis mb-2 card-title">{{ $otherService->title }}</p>
                                        <span class="cta-link">View Service <i class="fas fa-arrow-right ms-2"></i></span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <button class="scroll-nav-btn scroll-prev" aria-label="Previous">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="scroll-nav-btn scroll-next" aria-label="Next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </section>
    @endif

    <!-- H. CALL TO ACTION -->
    <section class="py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);">
        <div class="container text-center">
            <h2 class="text-white fw-bold mb-3">Ready to Get Started?</h2>
            <p class="text-white-50 mb-4">Let's work together to achieve your communications and marketing goals.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-warning btn-lg fw-semibold px-5">Contact Us Today</a>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hero slideshow: cross-fade every 4s, paused on hover or while the tab is hidden
    const slideshow = document.querySelector('[data-slideshow]');
    if (slideshow && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const slides = slideshow.querySelectorAll('img');
        let current = 0;
        let paused = false;

        slideshow.addEventListener('mouseenter', () => { paused = true; });
        slideshow.addEventListener('mouseleave', () => { paused = false; });

        setInterval(() => {
            if (paused || document.hidden) return;
            slides[current].classList.remove('is-active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('is-active');
        }, 4000);
    }

    // Other services scroll navigation
    const scrollContainer = document.querySelector('.other-services-track');
    const prevBtn = document.querySelector('.scroll-prev');
    const nextBtn = document.querySelector('.scroll-next');

    if (scrollContainer && prevBtn && nextBtn) {
        const scrollAmount = 324;

        prevBtn.addEventListener('click', () => {
            scrollContainer.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            scrollContainer.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }
});
</script>
@endpush
