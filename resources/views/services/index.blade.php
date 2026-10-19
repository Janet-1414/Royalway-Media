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
                <div class="row g-3">
                    @foreach($services as $service)
                        <div class="col-lg-3 col-md-6 col-6">
                            <a href="{{ route('services.show', $service->slug) }}" class="project-card text-decoration-none d-block" aria-label="{{ $service->title }}">
                                <div class="project-image position-relative overflow-hidden">
                                    @if($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}" loading="lazy" style="width:100%; height:220px; object-fit:cover;">
                                    @else
                                        <div style="width:100%; height:220px; background:#1a1a2e; display:flex; align-items:center; justify-content:center;">
                                            <i class="fas fa-concierge-bell fa-2x text-white opacity-25"></i>
                                        </div>
                                    @endif
                                    <div style="position:absolute; inset:0; background:linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 60%); pointer-events:none;"></div>
                                    <div style="position:absolute; bottom:0; left:0; right:0; padding:1rem;">
                                        <p class="text-white fw-semibold mb-0 small">{{ $service->title }}</p>
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
