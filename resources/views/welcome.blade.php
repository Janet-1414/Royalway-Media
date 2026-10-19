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

        // About section images
        $aboutSliderImages = json_decode(setting('about_slider_images', '[]'), true) ?: [];
        $aboutImage2 = setting('about_image_2');

        // CTA section
        $ctaTitle = setting('cta_title', 'Ready to tell your story?');
        $ctaSubtitle = setting('cta_subtitle', 'From strategy to events and media, one team delivers your communication from brief to results.');
        $ctaButtonText = setting('cta_button_text', 'Start a Project');
        $ctaButtonLink = setting('cta_button_link', '/contact');
        $ctaShowWhatsapp = setting('cta_show_whatsapp') === '1';

        // WhatsApp for CTA
        $waNumber = setting('whatsapp_number', '256772464686');
        $waPrefill = setting('whatsapp_prefill', 'Hello RoyalWay Media, I\'d like to enquire about your services.');
        $waLink = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $waNumber) . '?text=' . urlencode($waPrefill);
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

    <!-- Partners Section with Marquee -->
    <section class="partners-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                    <h2 class="fw-bold fs-4 text-dark mb-2">Trusted by our Partners</h2>
                    <p class="text-muted">Driven by our purpose of creating better outcomes for our clients &amp; their customers.</p>
                </div>
                <div class="col-lg-8 col-12">
                    <div class="partners-marquee-wrapper">
                        <div class="partners-marquee-track">
                            @foreach($partners as $partner)
                                <div class="partner-logo-slot">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" loading="lazy">
                                </div>
                            @endforeach
                            {{-- Duplicate for seamless loop --}}
                            @foreach($partners as $partner)
                                <div class="partner-logo-slot">
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" loading="lazy">
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
                <div class="col-12 mb-4">
                    <h2 class="section-heading">About Us</h2>
                    <p class="lead">Our mission is to transform communication offerings into an integrated delivery model that provides our clients with one single point of contact for their entire communication programs and all strategic perspectives of their brands.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-8">
                    @if(count($aboutSliderImages) > 0)
                        <div class="about-slider" id="aboutSlider">
                            @foreach($aboutSliderImages as $index => $image)
                                <img src="{{ asset('storage/' . $image) }}"
                                     alt="About RoyalWay Media"
                                     class="about-slider-image {{ $index === 0 ? 'active' : '' }}"
                                     loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                            @endforeach
                            @if(count($aboutSliderImages) > 1)
                                <div class="about-slider-dots">
                                    @foreach($aboutSliderImages as $index => $image)
                                        <button class="about-slider-dot {{ $index === 0 ? 'active' : '' }}"
                                                data-index="{{ $index }}"
                                                aria-label="Go to slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <img src="{{ asset('assets/img/about-1.png') }}" alt="About RoyalWay Media - Our team in action" class="img-fluid border-radius-lg shadow" loading="lazy" width="800" height="500">
                    @endif
                </div>
                <div class="col-lg-4">
                    @if($aboutImage2 && \Illuminate\Support\Facades\Storage::disk('public')->exists($aboutImage2))
                        <img src="{{ asset('storage/' . $aboutImage2) }}" alt="RoyalWay Media team collaboration" class="img-fluid border-radius-lg shadow" loading="lazy" width="400" height="500">
                    @else
                        <img src="{{ asset('assets/img/about-2.png') }}" alt="RoyalWay Media team collaboration" class="img-fluid border-radius-lg shadow" loading="lazy" width="400" height="500">
                    @endif
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
                    <h2 class="section-heading">What We Do</h2>
                    <p class="section-intro" style="white-space: normal; word-break: normal;">We help businesses solve their toughest communication and operational challenges — driving real, measurable returns.</p>
                </div>
            </div>
            <div class="row g-3">
                @php
                    $homeServices = [
                        [
                            'slug' => 'marketing-communications',
                            'title' => 'Marketing Communications',
                            'description' => 'We craft compelling marketing campaigns that connect your brand with the right audiences through strategic messaging and creative execution.',
                        ],
                        [
                            'slug' => 'experiential-marketing',
                            'title' => 'Experiential Marketing',
                            'description' => 'We design immersive brand experiences and activations that create lasting emotional connections between your brand and your audience.',
                        ],
                        [
                            'slug' => 'strategic-communications-visibility',
                            'title' => 'Strategic Communications & Visibility',
                            'description' => 'We build and protect your reputation through strategic communications planning that drives visibility and stakeholder engagement.',
                        ],
                        [
                            'slug' => 'pr-media-management',
                            'title' => 'PR & Media Management',
                            'description' => 'We manage your media relationships and press coverage to ensure your story is told accurately and reaches the right audiences.',
                        ],
                    ];
                @endphp
                @foreach($homeServices as $svc)
                    <div class="col-lg-3 col-md-6 col-6">
                        <a href="/services/{{ $svc['slug'] }}" class="project-card text-decoration-none d-block" aria-label="{{ $svc['title'] }}">
                            <div class="project-image position-relative overflow-hidden">
                                @php
                                    $imgPath = public_path('storage/services/' . $svc['slug'] . '.jpg');
                                @endphp
                                @if(file_exists($imgPath))
                                    <img src="{{ asset('storage/services/' . $svc['slug'] . '.jpg') }}" alt="{{ $svc['title'] }}" loading="lazy" style="width:100%; height:220px; object-fit:cover;">
                                @else
                                    <div style="width:100%; height:220px; background:#1a1a2e; display:flex; align-items:center; justify-content:center;">
                                        <i class="fas fa-concierge-bell fa-2x text-white opacity-25"></i>
                                    </div>
                                @endif
                                <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%); pointer-events:none;"></div>
                                <div style="position:absolute; bottom:0; left:0; right:0; padding:1rem;">
                                    <p class="text-white fw-semibold mb-0 small">{{ $svc['title'] }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('services.index') }}" class="btn btn-burgundy">View More Services</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="cta-title text-white mb-3">{{ $ctaTitle }}</h2>
                    <p class="cta-subtitle text-white mb-4">{{ $ctaSubtitle }}</p>
                    <div class="cta-buttons">
                        <a href="{{ $ctaButtonLink }}" class="btn btn-light btn-lg me-2 mb-2">{{ $ctaButtonText }}</a>
                        @if($ctaShowWhatsapp)
                            <a href="{{ $waLink }}" class="btn btn-outline-light btn-lg mb-2" target="_blank" rel="noopener">
                                <i class="fa-brands fa-whatsapp me-2"></i>Chat on WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
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
                        <h2 class="section-heading">Our Work</h2>
                        <p class="section-intro" style="white-space: normal; word-break: normal;">Effective communications and events solutions, delivered with impact.</p>
                    </div>
                </div>
            </div>
            <div class="projects-scroll-wrapper">
                <div class="projects-scroll-container">
                    @foreach($featuredProjects as $project)
                        <div class="project-card">
                            <div class="project-image">
                                @if($project->category)
                                    <span class="category-pill">{{ $project->category }}</span>
                                @endif
                                <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->title }}" class="img-fluid" loading="lazy" width="400" height="300">
                            </div>
                            <div class="project-content">
                                <p class="fw-700 text-dark-emphasis mt-3 mb-2 card-title">{{ $project->title }}</p>
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

// About section slider
(function() {
    'use strict';

    var slider = document.getElementById('aboutSlider');
    if (!slider) return;

    var images = slider.querySelectorAll('.about-slider-image');
    var dots = slider.querySelectorAll('.about-slider-dot');
    if (images.length <= 1) return;

    var currentIndex = 0;
    var interval = null;
    var isPaused = false;
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function showSlide(index) {
        images.forEach(function(img, i) {
            img.classList.toggle('active', i === index);
        });
        dots.forEach(function(dot, i) {
            dot.classList.toggle('active', i === index);
        });
        currentIndex = index;
    }

    function nextSlide() {
        if (isPaused) return;
        var next = (currentIndex + 1) % images.length;
        showSlide(next);
    }

    function startAutoplay() {
        if (prefersReducedMotion) return;
        interval = setInterval(nextSlide, 5000);
    }

    function stopAutoplay() {
        if (interval) {
            clearInterval(interval);
            interval = null;
        }
    }

    // Dot click handlers
    dots.forEach(function(dot) {
        dot.addEventListener('click', function() {
            var index = parseInt(this.getAttribute('data-index'), 10);
            showSlide(index);
            stopAutoplay();
            startAutoplay();
        });
    });

    // Pause on hover
    slider.addEventListener('mouseenter', function() {
        isPaused = true;
    });

    slider.addEventListener('mouseleave', function() {
        isPaused = false;
    });

    // Start autoplay
    startAutoplay();
})();
</script>
@endpush
