<!-- File Path: resources/views/policies/index.blade.php -->

@extends('layouts.app')

@section('title', 'Our Policies - RoyalWay Media')

@section('content')

    <!-- Page Header -->

    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">Our Policies</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Policies List Section -->

    <section class="policies-section py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <p class="lead text-muted">
                        At RoyalWay Media, we are committed to maintaining the highest standards of integrity, transparency, and professionalism in all our operations.
                    </p>
                </div>
            </div>


            <div class="row g-4">
                @forelse($policies as $policy)
                    <div class="col-lg-6 col-12">
                        <div class="purpose-card h-100">
                            <div class="d-flex align-items-start mb-3">
                                <div class="purpose-icon me-3">
                                    <i class="fa fa-shield fa-2x text-burgundy"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="fw-700 text-dark-emphasis mb-2">{{ $policy->title }}</p>
                                    @if($policy->badge_text)
                                        <span class="badge bg-light text-burgundy mb-2">{{ $policy->badge_text }}</span>
                                    @endif
                                </div>
                            </div>

                            @if($policy->effective_date)
                                <p class="text-muted mb-2">
                                    <small><i class="fas fa-calendar-alt me-1"></i>Effective: {{ $policy->formatted_effective_date }}</small>
                                </p>
                            @endif

                            <p class="text-muted mb-3">{{ Str::limit(strip_tags($policy->content), 150) }}</p>

                            <a href="{{ route('policies.show', $policy->slug) }}" class="btn btn-outline-burgundy">
                                Read Full Policy <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>No policies available at the moment.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>


    </section>

    <!-- Contact CTA Section -->

    <section class="event-cta-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-12 mb-3 mb-lg-0">
                    <p class="fs-4 fw-700 text-white mb-0">Questions About Our Policies?</p>
                    <p class="text-white-50 mb-0">We're here to help. Contact us for any clarifications.</p>
                </div>
                <div class="col-lg-4 col-12 text-lg-end">
                    <a href="{{ route('contact.index') }}" class="btn btn-burgundy">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
@endsection
