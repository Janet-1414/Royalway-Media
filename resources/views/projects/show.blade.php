{{-- File Path: resources/views/projects/show.blade.php --}}

@extends('layouts.app')

@section('title', $project->title . ' - RoyalWay Media')

@section('content')
    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">{{ $project->title }}</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Project Intro Section -->
    <section class="project-intro-section py-5">
        <div class="container">
            {{-- Client Logo & Lead --}}
            <div class="row align-items-start mb-4 g-4">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="client-block">
                        @if($project->client_logo)
                            <img src="{{ asset('storage/' . $project->client_logo) }}"
                                 alt="{{ $project->client }}"
                                 class="img-fluid mb-2 client-logo">
                        @else
                            <div class="client-monogram">
                                {{ $project->client_initials }}
                            </div>
                        @endif
                        <span class="client-badge">{{ $project->client }}</span>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    @if($project->lead)
                        <p class="project-lead mb-0">{{ $project->lead }}</p>
                    @elseif($project->description)
                        <p class="project-lead mb-0">{{ $project->description }}</p>
                    @endif
                </div>
            </div>

            {{-- Meta Bar --}}
            <div class="project-meta-bar">
                <div class="meta-items">
                    <div class="meta-item">
                        <span class="meta-label">Category</span>
                        <span class="meta-value">{{ $project->category }}</span>
                    </div>
                    @if($project->project_date)
                        <div class="meta-item">
                            <span class="meta-label">Date</span>
                            <span class="meta-value">{{ $project->formatted_date }}</span>
                        </div>
                    @endif
                    @if($project->location)
                        <div class="meta-item">
                            <span class="meta-label">Location</span>
                            <span class="meta-value">{{ $project->location }}</span>
                        </div>
                    @endif
                </div>
                <div class="meta-actions">
                    @if($project->report_url)
                        <a href="{{ $project->report_url }}" target="_blank" class="btn btn-burgundy btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i> View Full Report
                        </a>
                    @endif
                    @if($project->summary_pdf)
                        <a href="{{ asset('storage/' . $project->summary_pdf) }}" class="btn btn-outline-burgundy btn-sm" download>
                            <i class="fas fa-download me-1"></i> Download Summary
                        </a>
                    @elseif($project->download_link)
                        <a href="{{ asset('storage/' . $project->download_link) }}" class="btn btn-outline-burgundy btn-sm" download>
                            <i class="fas fa-download me-1"></i> Download Summary
                        </a>
                    @endif
                    @if(!$project->report_url && !$project->summary_pdf && !$project->download_link)
                        <a href="{{ route('contact.index') }}" class="btn btn-burgundy btn-sm">
                            Discuss a Similar Project
                        </a>
                    @endif
                </div>
            </div>

            {{-- Headline Stats --}}
            @if($project->headline_stats && count($project->headline_stats) > 0)
                <div class="headline-stats">
                    @foreach($project->headline_stats as $stat)
                        <div class="stat-item">
                            <span class="stat-value">{{ $stat['value'] }}</span>
                            <span class="stat-label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Story Section with Side Card --}}
    @if($project->narrative_blocks || $project->challenge || $project->side_card_items)
        <section class="project-story-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12">
                        {{-- Narrative Blocks --}}
                        @if($project->narrative_blocks && count($project->narrative_blocks) > 0)
                            @foreach($project->narrative_blocks as $block)
                                <div class="narrative-block">
                                    <h3>{{ $block['heading'] }}</h3>
                                    <div class="narrative-body">{!! $block['body'] !!}</div>
                                </div>
                            @endforeach
                        @elseif($project->challenge)
                            <div class="narrative-block">
                                <h2>The Challenge</h2>
                                <div class="narrative-body">{!! $project->challenge !!}</div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-12">
                        {{-- Side Card --}}
                        @if($project->side_card_items && count($project->side_card_items) > 0)
                            <div class="project-side-card">
                                <h3>{{ $project->side_card_title ?? 'Services delivered' }}</h3>
                                <ul class="side-card-list">
                                    @foreach($project->side_card_items as $item)
                                        <li><i class="fas fa-check text-burgundy me-2"></i>{{ is_array($item) ? $item['item'] : $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif($project->services && $project->services->count() > 0)
                            <div class="project-side-card">
                                <h3>Services delivered</h3>
                                <ul class="side-card-list">
                                    @foreach($project->services as $service)
                                        <li>
                                            <a href="{{ route('services.show', $service->slug) }}" class="text-decoration-none">
                                                <i class="fas fa-check text-burgundy me-2"></i>{{ $service->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery Section -->
    @if($project->gallery && count($project->gallery) > 0)
        <section class="gallery-section py-5">
            <div class="container">
                <h2 class="mb-4">The Gallery</h2>
                <div class="row g-3">
                    @foreach($project->gallery as $index => $image)
                        <div class="col-lg-4 col-md-6 col-6">
                            <div class="gallery-card" data-gallery-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $image) }}"
                                     alt="Gallery Image {{ $index + 1 }}"
                                     loading="lazy">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Lightbox -->
        <div class="lightbox" id="galleryLightbox">
            <button class="lightbox-close" aria-label="Close">&times;</button>
            <button class="lightbox-prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
            <button class="lightbox-next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
            <div class="lightbox-content">
                <img src="" alt="Gallery Image" id="lightboxImage">
            </div>
            <div class="lightbox-counter">
                <span id="lightboxCurrent">1</span> / <span id="lightboxTotal">{{ count($project->gallery) }}</span>
            </div>
        </div>

        @push('scripts')
        <script>
        (function() {
            const galleryImages = @json($project->gallery);
            const lightbox = document.getElementById('galleryLightbox');
            const lightboxImg = document.getElementById('lightboxImage');
            const lightboxCurrent = document.getElementById('lightboxCurrent');
            const lightboxTotal = document.getElementById('lightboxTotal');
            let currentIndex = 0;

            function openLightbox(index) {
                currentIndex = index;
                updateLightboxImage();
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }

            function updateLightboxImage() {
                lightboxImg.src = '{{ asset("storage") }}/' + galleryImages[currentIndex];
                lightboxCurrent.textContent = currentIndex + 1;
            }

            function nextImage() {
                currentIndex = (currentIndex + 1) % galleryImages.length;
                updateLightboxImage();
            }

            function prevImage() {
                currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
                updateLightboxImage();
            }

            // Click handlers
            document.querySelectorAll('.gallery-card').forEach(card => {
                card.addEventListener('click', () => {
                    openLightbox(parseInt(card.dataset.galleryIndex));
                });
            });

            document.querySelector('.lightbox-close').addEventListener('click', closeLightbox);
            document.querySelector('.lightbox-prev').addEventListener('click', prevImage);
            document.querySelector('.lightbox-next').addEventListener('click', nextImage);

            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox) closeLightbox();
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (!lightbox.classList.contains('active')) return;
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowRight') nextImage();
                if (e.key === 'ArrowLeft') prevImage();
            });

            // Touch swipe support
            let touchStartX = 0;
            lightbox.addEventListener('touchstart', (e) => {
                touchStartX = e.touches[0].clientX;
            }, { passive: true });

            lightbox.addEventListener('touchend', (e) => {
                const diff = touchStartX - e.changedTouches[0].clientX;
                if (Math.abs(diff) > 50) {
                    diff > 0 ? nextImage() : prevImage();
                }
            }, { passive: true });
        })();
        </script>
        @endpush
    @endif

    {{-- Results & Impact (Variant A) --}}
    @if($project->has_results_data)
        <section class="project-results-section py-5 bg-light">
            <div class="container">
                <h2 class="mb-4">Results & Impact</h2>
                <div class="row g-4">
                    {{-- Progress Bars / Channels --}}
                    @if($project->result_channels && count($project->result_channels) > 0)
                        <div class="col-lg-5 col-12">
                            <div class="results-card">
                                <h4>Media Reach</h4>
                                <div class="progress-bars">
                                    @foreach($project->result_channels as $channel)
                                        <div class="progress-item">
                                            <div class="progress-label">
                                                <span>{{ $channel['label'] }}</span>
                                                <span>{{ $channel['percent'] }}%</span>
                                            </div>
                                            <div class="progress-bar-bg">
                                                <div class="progress-bar-fill" style="width: {{ $channel['percent'] }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- KPI Tiles --}}
                    @if($project->result_kpis && count($project->result_kpis) > 0)
                        <div class="col-lg-7 col-12">
                            <div class="kpi-grid">
                                @foreach($project->result_kpis as $kpi)
                                    <div class="kpi-tile">
                                        <span class="kpi-value">{{ $kpi['value'] }}</span>
                                        <span class="kpi-label">{{ $kpi['label'] }}</span>
                                        @if(!empty($kpi['note']))
                                            <span class="kpi-note">{{ $kpi['note'] }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if($project->results_footnote)
                    <p class="results-footnote mt-4">{{ $project->results_footnote }}</p>
                @endif
            </div>
        </section>
    @elseif($project->outcome_text || $project->results)
        {{-- Outcome Callout (Variant B) --}}
        <section class="project-outcome-section py-5">
            <div class="container">
                <div class="outcome-callout">
                    <span class="outcome-label">Outcome</span>
                    <p class="outcome-text">
                        {{ $project->outcome_text ?? strip_tags($project->results) }}
                    </p>
                </div>
            </div>
        </section>
    @endif

    {{-- Services Offered (if not shown in side card) --}}
    @if($project->services && $project->services->count() > 0 && !($project->side_card_items && count($project->side_card_items) > 0))
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="mb-4">Services Offered</h2>
                <div class="row g-3">
                    @foreach($project->services as $service)
                        <div class="col-lg-3 col-md-4 col-6">
                            <a href="{{ route('services.show', $service->slug) }}" class="text-decoration-none">
                                <div class="service-mini-card">
                                    @if($service->image_url)
                                        <img src="{{ $service->image_url }}"
                                             alt="{{ $service->title }}"
                                             class="img-fluid">
                                    @else
                                        @include('components.card-fallback', ['type' => 'service', 'icon' => 'fa-concierge-bell'])
                                    @endif
                                    <span class="service-mini-title">{{ $service->title }}</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- More Projects -->
    @if($relatedProjects->count() > 0)
        <section class="related-projects-section py-5">
            <div class="container">
                <div class="section-header mb-4">
                    <h2>More Projects</h2>
                </div>
                <div class="row g-4">
                    @foreach($relatedProjects as $related)
                        <div class="col-lg-4 col-md-6 col-12">
                            <a href="{{ route('projects.show', $related->slug) }}" class="text-decoration-none">
                                <div class="project-card">
                                    <div class="project-image">
                                        @if($related->category)
                                            <span class="category-pill">{{ $related->category }}</span>
                                        @endif
                                        @if($related->image_url)
                                            <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="img-fluid">
                                        @else
                                            @include('components.card-fallback', ['type' => 'project', 'icon' => 'fa-briefcase'])
                                        @endif
                                    </div>
                                    <div class="project-content">
                                        <p class="fw-700 text-dark-emphasis mt-3 mb-2 card-title">{{ $related->title }}</p>
                                        <p class="text-muted mb-3">{{ Str::limit($related->description, 80) }}</p>
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
@endsection
