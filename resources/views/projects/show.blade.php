{{-- File Path: resources/views/projects/show.blade.php --}}

@extends('layouts.app')

@section('title', $project->title . ' - RoyalWay Media')

@php
    // Rich text editors can save "<p></p>" for an empty field, so test for visible content
    $isBlank = fn ($html) => trim(strip_tags((string) $html, '<img><iframe><video>')) === '';

    $heroImg = $project->image_url;
    $logoOk = $project->client_logo && file_exists(storage_path('app/public/' . $project->client_logo));
    // Only the Lead field goes under the title, so the description is not repeated right below it
    $subtitle = filled($project->lead) ? $project->lead : null;

    $tags = collect(explode(',', (string) $project->tags))
        ->map(fn ($t) => str_replace(' ', '', ltrim(trim($t), '#')))
        ->filter()
        ->values();

    $stats = collect($project->headline_stats ?? [])
        ->filter(fn ($s) => filled($s['value'] ?? null) && filled($s['label'] ?? null))
        ->values()
        ->take(4);

    $challenge = $isBlank($project->challenge) ? null : $project->challenge;

    $narrative = collect($project->narrative_blocks ?? [])
        ->filter(fn ($b) => filled($b['heading'] ?? null))
        ->values();

    // A short, plain challenge is shown as a callout box. A long one (headings or lists inside)
    // is the full story, so it is hidden when Story Blocks exist to avoid showing it twice
    $challengeShort = $challenge
        && mb_strlen(trim(strip_tags($challenge))) <= 450
        && ! preg_match('/<(h[1-6]|ul|ol)\b/i', $challenge);

    $sideItems = collect($project->side_card_items ?? [])
        ->map(fn ($i) => is_array($i) ? ($i['item'] ?? '') : $i)
        ->filter()
        ->values();

    $services = $project->services ?? collect();
    $summaryFile = $project->summary_pdf ?: $project->download_link;
    $hasDownloads = $project->report_url || $summaryFile;

    $gallery = array_values(array_filter((array) ($project->gallery ?? [])));
    $gCount = count($gallery);

    $outcome = filled($project->outcome_text)
        ? $project->outcome_text
        : (! $project->has_results_data && ! $isBlank($project->results) ? strip_tags((string) $project->results) : null);
@endphp

@section('content')

    <!-- Hero -->
    <section class="pj-hero-wrap">
        <div class="container">
            <div class="pj-hero{{ $stats->count() ? '' : ' pj-hero--flat' }}"@if($heroImg) style="background-image: linear-gradient(180deg, rgba(10, 18, 40, .55), rgba(10, 18, 40, .85)), url('{{ $heroImg }}');"@endif>
                <div class="pj-hero-top">
                    @if(filled($project->client))
                        <span class="pj-chip">
                            @if($logoOk)
                                <img src="{{ asset('storage/' . $project->client_logo) }}" alt="" class="pj-chip-logo">
                            @else
                                <span class="pj-chip-mono">{{ $project->client_initials }}</span>
                            @endif
                            {{ $project->client }}
                        </span>
                    @else
                        <span></span>
                    @endif

                    @if($project->is_featured)
                        <span class="pj-featured"><i class="fas fa-star"></i> Featured project</span>
                    @endif
                </div>

                <div class="pj-hero-body">
                    @if($project->category)
                        <span class="pj-hero-cat">{{ $project->category }}</span>
                    @endif
                    <h1 class="pj-hero-title">{{ $project->title }}</h1>
                    @if(filled($subtitle))
                        <p class="pj-hero-sub">{{ $subtitle }}</p>
                    @endif

                    @if($project->project_date || $project->location)
                        <div class="pj-meta">
                            @if($project->project_date)
                                <span>{{ $project->formatted_date }}</span>
                            @endif
                            @if($project->location)
                                <span>{{ $project->location }}</span>
                            @endif
                        </div>
                    @endif

                    @if($tags->count())
                        <div class="pj-tags">
                            @foreach($tags as $tag)
                                <span>#{{ $tag }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if($stats->count())
                <div class="pj-stats" style="--c: {{ $stats->count() }}">
                    @foreach($stats as $stat)
                        <div class="pj-stat">
                            <b>{{ $stat['value'] }}</b>
                            <span>{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Description, story and side cards -->
    <section class="pj-main">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    @if(filled($project->description))
                        <span class="pj-label">Description</span>
                        <h2 class="pj-h2">About this project</h2>
                        <div class="pj-text">{!! nl2br(e($project->description)) !!}</div>
                    @endif

                    @if($challenge && $challengeShort)
                        <div class="pj-challenge">
                            <span class="pj-challenge-label">The challenge</span>
                            <div class="pj-challenge-body">{!! $challenge !!}</div>
                        </div>
                    @elseif($challenge && $narrative->isEmpty())
                        <div class="pj-text pj-story">{!! $challenge !!}</div>
                    @endif

                    @if($narrative->count())
                        <ol class="pj-timeline">
                            @foreach($narrative as $i => $block)
                                <li>
                                    <span class="pj-step">{{ $i + 1 }}</span>
                                    <h3>{{ $block['heading'] }}</h3>
                                    <div class="pj-text">{!! $block['body'] ?? '' !!}</div>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="pj-aside">
                        @if($sideItems->count())
                            <div class="pj-card">
                                <span class="pj-card-label">{{ $project->side_card_title ?: 'Services delivered' }}</span>
                                <ul class="pj-check">
                                    @foreach($sideItems as $item)
                                        <li><i class="fas fa-check"></i><span>{{ $item }}</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($hasDownloads)
                            <div class="pj-card">
                                <span class="pj-card-label">Downloads</span>
                                @if($project->report_url)
                                    <a href="{{ $project->report_url }}" class="pj-dl" target="_blank" rel="noopener">
                                        <span>Full report</span>
                                        <em>Open link <i class="fas fa-external-link-alt"></i></em>
                                    </a>
                                @endif
                                @if($summaryFile)
                                    <a href="{{ asset('storage/' . $summaryFile) }}" class="pj-dl" download>
                                        <span>Summary PDF</span>
                                        <em>Download <i class="fas fa-download"></i></em>
                                    </a>
                                @endif
                            </div>
                        @endif

                        <div class="pj-card">
                            @if(filled($project->client))
                                <div class="pj-kv">
                                    <span>Client</span>
                                    <b>{{ $project->client }}</b>
                                </div>
                            @endif
                            @if($project->category)
                                <div class="pj-kv">
                                    <span>Category</span>
                                    <b>{{ $project->category }}</b>
                                </div>
                            @endif
                            <a href="{{ route('contact.index') }}" class="pj-btn">Discuss a Similar Project</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Outcome -->
    @if($outcome)
        <section class="pj-outcome-wrap">
            <div class="container">
                <div class="pj-outcome">
                    <span class="pj-pill">Outcome</span>
                    <p>{{ $outcome }}</p>
                </div>
            </div>
        </section>
    @endif

    {{-- Results & Impact (quantitative results) --}}
    @if($project->has_results_data)
        <section class="project-results-section py-5 bg-light">
            <div class="container">
                <h2 class="mb-4">Results & Impact</h2>
                <div class="row g-4">
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
    @endif

    <!-- What we delivered -->
    @if($services->count() > 0)
        <section class="pj-delivered">
            <div class="container">
                <span class="pj-label">What we delivered</span>
                <h2 class="pj-h2">How RoyalWay brought it to life</h2>
                <div class="row g-3 g-lg-4 mt-1">
                    @foreach($services as $service)
                        @php
                            $svcIcon = ($service->icon && file_exists(storage_path('app/public/' . $service->icon)))
                                ? asset('storage/' . $service->icon)
                                : null;
                        @endphp
                        <div class="col-6 col-lg-3">
                            <a href="{{ route('services.show', $service->slug) }}" class="pj-svc">
                                <span class="pj-svc-icon">
                                    @if($svcIcon)
                                        <img src="{{ $svcIcon }}" alt="">
                                    @else
                                        <i class="fas fa-circle-check"></i>
                                    @endif
                                </span>
                                <h3>{{ $service->title }}</h3>
                                @if($service->short_description)
                                    <p>{{ Str::limit($service->short_description, 90) }}</p>
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Gallery -->
    @if($gCount > 0)
        <section class="pj-gallery">
            <div class="container">
                <span class="pj-label">The gallery</span>
                <div class="pj-gal pj-gal-{{ min($gCount, 5) }}">
                    @foreach(array_slice($gallery, 0, 5) as $index => $image)
                        <div class="pj-gal-item" data-gallery-index="{{ $index }}" role="button" tabindex="0" aria-label="Open photo {{ $index + 1 }}">
                            <img src="{{ asset('storage/' . $image) }}" alt="{{ $project->title }} photo {{ $index + 1 }}" loading="lazy">
                            @if($index === 4 && $gCount > 5)
                                <span class="pj-gal-more"><i class="fas fa-images"></i> + View full gallery</span>
                            @endif
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
                <span id="lightboxCurrent">1</span> / <span id="lightboxTotal">{{ $gCount }}</span>
            </div>
        </div>

        @push('scripts')
            <script>
                (function() {
                    const galleryImages = @json($gallery);
                    const lightbox = document.getElementById('galleryLightbox');
                    const lightboxImg = document.getElementById('lightboxImage');
                    const lightboxCurrent = document.getElementById('lightboxCurrent');
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

                    document.querySelectorAll('.pj-gal-item').forEach(card => {
                        card.addEventListener('click', () => openLightbox(parseInt(card.dataset.galleryIndex)));
                        card.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.preventDefault();
                                openLightbox(parseInt(card.dataset.galleryIndex));
                            }
                        });
                    });

                    document.querySelector('.lightbox-close').addEventListener('click', closeLightbox);
                    document.querySelector('.lightbox-prev').addEventListener('click', prevImage);
                    document.querySelector('.lightbox-next').addEventListener('click', nextImage);

                    lightbox.addEventListener('click', (e) => {
                        if (e.target === lightbox) closeLightbox();
                    });

                    document.addEventListener('keydown', (e) => {
                        if (!lightbox.classList.contains('active')) return;
                        if (e.key === 'Escape') closeLightbox();
                        if (e.key === 'ArrowRight') nextImage();
                        if (e.key === 'ArrowLeft') prevImage();
                    });

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

    <!-- More projects -->
    @if($relatedProjects->count() > 0)
        <section class="pj-related">
            <div class="container">
                <span class="pj-label">More projects</span>
                <h2 class="pj-h2">Keep exploring our work</h2>
                <div class="row g-4 mt-1">
                    @foreach($relatedProjects as $related)
                        <div class="col-lg-4 col-md-6 col-12">
                            <a href="{{ route('projects.show', $related->slug) }}" class="pj-rel">
                                <div class="pj-rel-img">
                                    @if($related->image_url)
                                        <img src="{{ $related->image_url }}" alt="{{ $related->title }}" loading="lazy">
                                    @else
                                        <div class="pj-rel-ph"><i class="fas fa-briefcase"></i></div>
                                    @endif
                                </div>
                                <div class="pj-rel-body">
                                    @if($related->category)
                                        <span class="pj-rel-cat">{{ $related->category }}</span>
                                    @endif
                                    <h3>{{ $related->title }}</h3>
                                    <span class="cta-link">Learn more <i class="fas fa-arrow-right ms-2"></i></span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Closing banner -->
    <section class="pj-cta-wrap">
        <div class="container">
            <div class="pj-cta">
                <h2>Planning something like this?</h2>
                <p>Tell us about your idea and we will bring it to life.</p>
                <div class="pj-cta-btns">
                    <a href="{{ route('contact.index') }}" class="pj-btn-white">Discuss a Similar Project</a>
                    <a href="{{ route('contact.index') }}" class="pj-btn-ghost">Start a Project</a>
                </div>
            </div>
        </div>
    </section>
@endsection
