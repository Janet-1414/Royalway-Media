@extends('layouts.app')

@section('title', setting('seo_title', 'RoyalWay Media - Elevating Brands, Transforming Ambitions'))

@section('content')

    <!-- Hero Section with Video -->
    @php
        $videoPoster = $heroPoster ?? asset('assets/img/about-1.png');
        $videoSrc = $heroVideo ?? asset('assets/video/hero-video.mp4');
        $heroTitle = setting('hero_title', 'RoyalWay Media: Where Communications is catalyst for growth');
        $heroSubtitle = setting('hero_subtitle', 'We work with ambitious people and companies to help through creation, reinvention, or transformation of their brand.');
        $btn1Label = setting('hero_button1_label', 'Start a Project');
        $btn1Link = setting('hero_button1_link') ?: route('contact.index');
        $btn2Label = setting('hero_button2_label', 'Our Work');
        $btn2Link = setting('hero_button2_link') ?: route('projects.index');

        // Social URLs
        $instagram = setting('social_instagram', 'https://www.instagram.com/royalwaymedia');
        $facebook = setting('social_facebook', 'https://www.facebook.com/RoyalWayMediaLtd');
        $linkedin = setting('social_linkedin', 'https://www.linkedin.com/company/royalway-media/');
        $youtube = setting('social_youtube', 'https://www.youtube.com/channel/UC5292sL9n6DTH7p7Yh8HmOg/videos');
        $twitter = setting('social_twitter', 'https://twitter.com/RoyalWayMedia');

        // Stats from settings
        $statsList = setting_stats();
        if (empty($statsList)) {
            $statsList = [
                ['number' => '10+', 'label' => 'Years of Experience'],
                ['number' => '10+', 'label' => 'Awards Won'],
                ['number' => '150+', 'label' => 'Satisfied Customers'],
            ];
        }
    @endphp

    <section class="hero-video-section">
        <div class="hero-video-container" style="background-image: url('{{ $videoPoster }}'); background-size: cover; background-position: center;">
            <video class="hero-video" muted loop playsinline preload="metadata" poster="{{ $videoPoster }}" data-src="{{ $videoSrc }}">
                <source src="{{ $videoSrc }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="hero-overlay"></div>
            <div class="hero-content-wrapper">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <h1 class="hero-title text-white mb-1" style="font-family:'Montserrat',sans-serif;">{{ $heroTitle }}</h1>
                            <p class="hero-subtitle text-white mb-4">{{ $heroSubtitle }}</p>
                            <div class="hero-buttons">
                                <a href="{{ $btn1Link }}" class="btn btn-burgundy me-3">{{ $btn1Label }}</a>
                                <a href="{{ $btn2Link }}" class="btn btn-outline-light">{{ $btn2Label }}</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="social-sidebar">
                                @if($instagram)<a href="{{ $instagram }}" class="social-icon" aria-label="Instagram" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>@endif
                                @if($facebook)<a href="{{ $facebook }}" class="social-icon" aria-label="Facebook" target="_blank" rel="noopener"><i class="fa-brands fa-facebook-f"></i></a>@endif
                                @if($linkedin)<a href="{{ $linkedin }}" class="social-icon" aria-label="LinkedIn" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a>@endif
                                @if($youtube)<a href="{{ $youtube }}" class="social-icon" aria-label="YouTube" target="_blank" rel="noopener"><i class="fa-brands fa-youtube"></i></a>@endif
                                @if($twitter)<a href="{{ $twitter }}" class="social-icon" aria-label="X (Twitter)" target="_blank" rel="noopener"><i class="fa-brands fa-x-twitter"></i></a>@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->

    <section class="partners-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                    <p class="fw-700 fs-5 text-dark">Trusted by our Partners</p>
                    <p class="text-muted">Driven by our purpose of creating better outcomes for our clients &amp; their customers.</p>
                </div>


                <div class="col-lg-8 col-12">
                    <div id="logoCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
                        <div class="carousel-inner">
                            @foreach($partners->chunk(6) as $index => $partnerChunk)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="row justify-content-center">
                                        @foreach($partnerChunk as $partner)
                                            <div class="col-lg-2 col-md-3 col-4 mb-2">
                                                <img class="w-100 opacity-9" src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" loading="lazy" width="120" height="60">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->

    <section class="about-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4">
                    <span class="badge bg-light text-burgundy mb-3">ABOUT US</span>
                </div>
                <div class="col-lg-9 mb-4">
                    <p class="lead">Our mission is to transform communication offerings into an integrated delivery model that provides our clients with one single point of contact for their entire communication programs and all strategic perspectives of their brands.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-8">
                    <img src="{{ asset('assets/img/about-1.png') }}" alt="About RoyalWay Media - Our team in action" class="img-fluid border-radius-lg shadow" loading="lazy" width="800" height="500">
                </div>
                <div class="col-lg-4">
                    <img src="{{ asset('assets/img/about-2.png') }}" alt="RoyalWay Media team collaboration" class="img-fluid border-radius-lg shadow" loading="lazy" width="400" height="500">
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->

    <section class="stats-section py-5 bg-black">
        <div class="container">
            <div class="row text-center text-white align-items-center">
                @foreach($statsList as $stat)
                <div class="col-lg-{{ 12 / max(count($statsList), 1) }} col-6 mb-4">
                    <span class="text-white hero-title d-inline mb-0">{{ $stat['number'] ?? '' }}</span>
                    <span class="d-inline">{{ $stat['label'] ?? '' }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <span class="badge bg-light text-burgundy mb-3">OUR SERVICES</span>
                    <p class="section-intro" style="white-space: normal; word-break: normal;">We help businesses solve their toughest communication and operational challenges — driving real, measurable returns.</p>
                </div>
            </div>
            <div class="row g-3">
                @php
                    // Get 4 services: featured first, then top up with other active services by order
                    $featuredServices = $services->where('is_featured', true)->take(4);
                    $remainingCount = 4 - $featuredServices->count();
                    $nonFeatured = $remainingCount > 0 ? $services->where('is_featured', '!=', true)->take($remainingCount) : collect();
                    $homeServices = $featuredServices->concat($nonFeatured)->take(4);
                @endphp
                @foreach($homeServices as $service)
                    <div class="col-lg-3 col-md-6 col-6">
                        @include('components.service-tile', ['service' => $service])
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('services.index') }}" class="btn btn-burgundy">View More Services</a>
            </div>
        </div>
    </section>

    <!-- Projects Section -->

    <section class="projects-section py-5">
        <div class="container-fluid">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-12">
                        <span class="badge bg-light text-burgundy mb-3">Best Projects</span>
                        <p class="section-intro" style="white-space: normal; word-break: normal;">Effective communications and events solutions, delivered with impact.</p>
                    </div>
                </div>
            </div>
            <div class="projects-scroll-wrapper">
                <div class="projects-scroll-container">
                    @foreach($featuredProjects as $project)
                        <div class="project-card">
                            <div class="project-image">
                                <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->title }}" class="img-fluid" loading="lazy" width="400" height="300">
                            </div>
                            <div class="project-content">
                                <span class="project-tag">{{ $project->category }}</span>
                                <p class="fw-700 text-dark-emphasis mt-3 mb-2">{{ $project->title }}</p>
                                <p class="text-muted mb-3">{{ Str::limit($project->description, 100) }}</p>
                                <a href="{{ route('projects.show', $project->slug) }}" class="cta-link">Learn More <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="container mt-4">
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="{{ route('projects.index') }}" class="btn btn-burgundy">Explore More of Our Best Projects</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .hero-video {
        opacity: 0;
        transition: opacity 0.6s ease-in-out;
    }
    .hero-video.is-playing {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
(function() {
    'use strict';

    var video = document.querySelector('.hero-video');
    if (!video) return;

    // Check for reduced motion preference or data saver
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    var saveData = connection && connection.saveData;

    if (prefersReducedMotion || saveData) {
        // Don't load video, keep poster only
        video.preload = 'none';
        video.removeAttribute('src');
        var source = video.querySelector('source');
        if (source) source.removeAttribute('src');
        return;
    }

    function playVideo() {
        video.play().then(function() {
            video.classList.add('is-playing');
        }).catch(function(err) {
            // Play was prevented, keep poster visible
            console.log('Video autoplay prevented:', err);
        });
    }

    // Listen for canplaythrough event
    video.addEventListener('canplaythrough', playVideo, { once: true });

    // Fallback to loadeddata if canplaythrough doesn't fire
    video.addEventListener('loadeddata', function() {
        if (video.readyState >= 3) {
            playVideo();
        }
    }, { once: true });

    // Ensure video stays muted (some browsers may unmute)
    video.muted = true;
})();
</script>
@endpush
