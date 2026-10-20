{{-- File Path: resources/views/services/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Our Services - RoyalWay Media')

@section('content')

    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">Our Services</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="services-tiles-section py-5">
        <div class="container">
            @if($services->count() > 0)
                <div class="row g-4">
                    @foreach($services as $service)
                        <div class="col-lg-4 col-md-6 col-12">
                            <a href="{{ route('services.show', $service->slug) }}" class="text-decoration-none">
                                <div class="project-card">
                                    <div class="project-image">
                                        <img src="{{ $service->image ? asset('storage/' . $service->image) : asset('assets/img/about-1.png') }}" alt="{{ $service->title }}" class="img-fluid" onerror="this.onerror=null;this.src='{{ asset('assets/img/about-1.png') }}';">
                                    </div>
                                    <div class="project-content">
                                        <p class="fw-700 text-dark-emphasis mb-2 card-title">{{ $service->title }}</p>
                                        <span class="cta-link">Learn More <i class="fas fa-arrow-right ms-2"></i></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No services available at the moment.
                </div>
            @endif
        </div>
    </section>

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
