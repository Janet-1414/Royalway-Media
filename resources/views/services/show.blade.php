{{-- File Path: resources/views/services/show.blade.php --}}

@extends('layouts.app')

@section('title', $service->title . ' - RoyalWay Media')

@section('content')

    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">{{ $service->title }}</h1>
                    @if($service->category)
                        <p class="text-white-50 mb-0">{{ $service->category }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Service Intro Section -->
    <section class="service-intro-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-12 mb-4 mb-lg-0">
                    @if($service->category)
                        <span class="badge bg-light text-burgundy mb-3">{{ $service->category }}</span>
                    @endif

                    @if($service->headline)
                        <h2 class="mb-3">{{ $service->headline }}</h2>
                    @endif

                    @if($service->intro)
                        <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.7;">{{ $service->intro }}</p>
                    @elseif($service->short_description)
                        <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.7;">{{ $service->short_description }}</p>
                    @endif

                    @if($service->checklist && count($service->checklist) > 0)
                        <ul class="service-checklist">
                            @foreach($service->checklist as $item)
                                <li><i class="fas fa-check text-burgundy me-2"></i>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-4">
                        <a href="{{ route('contact.index') }}" class="btn btn-burgundy me-2">Start a Project</a>
                        <a href="{{ route('event-brief.index') }}" class="btn btn-outline-burgundy">Event Brief</a>
                    </div>
                </div>
                <div class="col-lg-5 col-12">
                    @if($service->poster_image_url)
                        <img src="{{ $service->poster_image_url }}"
                             alt="{{ $service->title }}"
                             class="img-fluid service-poster-image">
                    @elseif($service->image_url)
                        <img src="{{ $service->image_url }}"
                             alt="{{ $service->title }}"
                             class="img-fluid service-poster-image">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Full Description -->
    @if($service->full_description)
        <section class="service-description-section py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-12 mx-auto">
                        <div class="service-content-body">
                            {!! $service->full_description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Related Projects -->
    @if($projects->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="section-header mb-4">
                    <h2>Projects Under This Service</h2>
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
                                        <p class="fw-700 text-dark-emphasis mt-3 mb-2">{{ $project->title }}</p>
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

    <!-- Materials Gallery -->
    @if($service->gallery && count($service->gallery) > 0)
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="mb-4">Materials We Have Produced</h2>
                <div class="service-gallery-grid">
                    @foreach(array_slice($service->gallery, 0, 4) as $image)
                        <div class="service-gallery-item">
                            <img src="{{ asset('storage/' . $image) }}"
                                 alt="Work sample"
                                 loading="lazy">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Other Services -->
    @if($otherServices->count() > 0)
        <section class="py-5">
            <div class="container">
                <div class="section-header mb-4">
                    <h2>Other Services</h2>
                </div>
                <div class="other-services-scroll">
                    <div class="other-services-track">
                        @foreach($otherServices as $otherService)
                            @include('components.service-tile', ['service' => $otherService])
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

    <!-- CTA Section -->
    <section class="event-cta-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-12 mb-3 mb-lg-0">
                    <h2 class="text-white mb-0">Ready to Start Your Project?</h2>
                    <p class="text-white-50 mb-0">Let's discuss how we can help elevate your brand</p>
                </div>
                <div class="col-lg-4 col-12 text-lg-end">
                    <a href="{{ route('contact.index') }}" class="btn btn-burgundy me-2">Contact Us</a>
                    <a href="{{ route('event-brief.index') }}" class="btn btn-outline-light">Event Brief</a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Other services scroll navigation
    const scrollContainer = document.querySelector('.other-services-track');
    const prevBtn = document.querySelector('.scroll-prev');
    const nextBtn = document.querySelector('.scroll-next');

    if (scrollContainer && prevBtn && nextBtn) {
        const scrollAmount = 320;

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
