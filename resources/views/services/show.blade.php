{{-- File Path: resources/views/services/show.blade.php --}}

@extends('layouts.app')

@section('title', $service->title . ' - RoyalWay Media')

@section('content')

    <!-- A. HERO SECTION -->
    <section class="page-header-section py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <p class="text-uppercase text-warning fw-semibold mb-2 small">Our Services</p>
                    <h1 class="text-white fw-bold mb-3">{{ $service->title }}</h1>
                    <p class="text-white-50 fs-5">{{ $service->tagline ?? $service->short_description ?? 'Strategic. Impactful. Results-driven.' }}</p>
                    <a href="{{ route('contact.index') }}" class="btn btn-warning mt-3 fw-semibold px-4">Get In Touch</a>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-end">
                    @if($service->poster_image_url)
                        <img src="{{ $service->poster_image_url }}" alt="{{ $service->title }}" class="img-fluid rounded" style="max-height:320px; object-fit:cover; width:100%;">
                    @elseif($service->image_url)
                        <img src="{{ $service->image_url }}" alt="{{ $service->title }}" class="img-fluid rounded" style="max-height:320px; object-fit:cover; width:100%;">
                    @else
                        <div style="height:320px; background:rgba(255,255,255,0.05); border-radius:8px;"></div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- B. INTRODUCTION -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <p class="section-intro">{{ $service->intro ?? $service->full_description ?? $service->short_description ?? 'Full introduction coming soon.' }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- C. SERVICE FEATURES -->
    @php
        $featuresList = $service->features ?? $service->checklist ?? [];
    @endphp
    @if($featuresList && count($featuresList) > 0)
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold mb-4 text-center">What We Offer</h2>
            <div class="row g-4">
                @foreach($featuresList as $feature)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm p-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                    <i class="fas fa-check text-dark fw-bold"></i>
                                </span>
                            </div>
                            <p class="fw-semibold mb-1">{{ is_array($feature) ? ($feature['title'] ?? '') : $feature }}</p>
                            @if(is_array($feature) && isset($feature['description']))
                                <p class="text-muted small mb-0">{{ $feature['description'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- D. FULL SERVICE DESCRIPTION -->
    @if($service->content || $service->full_description)
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="prose">{!! $service->content ?? $service->full_description !!}</div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Related Projects -->
    @if($projects->count() > 0)
        <section class="py-5 bg-light">
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

    <!-- Materials Gallery -->
    @if($service->gallery && count($service->gallery) > 0)
        <section class="py-5">
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
        <section class="py-5 bg-light">
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

    <!-- E. CALL TO ACTION -->
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
