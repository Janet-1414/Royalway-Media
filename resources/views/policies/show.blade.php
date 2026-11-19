@extends('layouts.app')

@section('title', $policy->title . ' - RoyalWay Media')

@section('content')

    <!-- Hero: background image (Filament "Hero background image", default banner when unset) behind a dark overlay -->
    <section class="ph-overlay policy-hero" style="background-image: url('{{ $policy->hero_image_url }}');">
        <div class="container">
            <div class="ph-overlay-text">
                <span class="ph-overlay-eyebrow">Our Policies</span>
                <h1 class="ph-overlay-title">{{ $policy->title }}</h1>
                <div class="in-rule"></div>
                @if(!empty($policy->subtitle))
                    <p>{{ $policy->subtitle }}</p>
                @elseif(!empty($policy->badge_text))
                    <p>{{ $policy->badge_text }}</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Policy Meta Info -->
    @if(!empty($policy->category) || !empty($policy->effective_date) || !empty($policy->version))
        <section class="section-tint policy-meta">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        @if(!empty($policy->category))
                            <span class="badge bg-burgundy mb-2">{{ $policy->category }}</span>
                        @endif
                        @if(!empty($policy->effective_date))
                            <div class="policy-meta-item">
                                <i class="far fa-calendar me-2"></i>
                                Effective Date: {{ is_object($policy->effective_date) ? $policy->effective_date->format('F d, Y') : $policy->effective_date }}
                            </div>
                        @endif
                    </div>
                    @if(!empty($policy->version))
                        <div class="policy-meta-item">
                            Version {{ $policy->version }}
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- Policy Content Section -->
    <section class="policy-content-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Main Content -->
                <div class="col-lg-9 col-12">

                    <!-- Table of Contents (if sections exist) -->
                    @if(!empty($policy->sections) && is_array($policy->sections) && count($policy->sections) > 0)
                        <div class="card border-0 bg-light mb-5">
                            <div class="card-body">
                                <p class="fw-700 text-dark mb-3">Table of Contents</p>
                                <ol class="mb-0">
                                    @foreach($policy->sections as $index => $section)
                                        <li class="mb-2">
                                            <a href="#section-{{ $index }}" class="text-decoration-none text-burgundy">
                                                {{ is_array($section) ? ($section['title'] ?? 'Section ' . ($index + 1)) : 'Section ' . ($index + 1) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    @endif

                    <!-- Policy Introduction -->
                    @if(!empty($policy->introduction))
                        <div class="policy-introduction mb-5">
                            <h3 class="text-dark mb-3">Introduction</h3>
                            <div class="policy-text">
                                {!! $policy->introduction !!}
                            </div>
                        </div>
                    @endif

                    <!-- Policy Sections -->
                    @if(!empty($policy->sections) && is_array($policy->sections) && count($policy->sections) > 0)
                        <div class="policy-sections">
                            @foreach($policy->sections as $index => $section)
                                <div id="section-{{ $index }}" class="policy-section mb-5">
                                    <h3 class="text-dark mb-3">
                                        {{ $index + 1 }}. {{ is_array($section) ? ($section['title'] ?? 'Section ' . ($index + 1)) : 'Section ' . ($index + 1) }}
                                    </h3>
                                    <div class="policy-text">
                                        {!! is_array($section) ? ($section['content'] ?? '') : $section !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @elseif(!empty($policy->content))
                        <!-- Full Content (if no sections) -->
                        <div class="policy-content mb-5">
                            {!! $policy->content !!}
                        </div>
                    @endif

                    <!-- Policy Footer/Additional Info -->
                    @if(!empty($policy->additional_info))
                        <div class="card border-0 bg-light mt-5">
                            <div class="card-body">
                                <p class="fw-700 text-dark mb-3">Additional Information</p>
                                <div class="policy-text">
                                    {!! $policy->additional_info !!}
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Contact Information -->
                    @if(!empty($policy->contact_info) && is_array($policy->contact_info))
                        <div class="alert alert-burgundy text-white mt-5">
                            <p class="fw-700 text-white mb-3">Questions or Concerns?</p>
                            <div>{!! $policy->contact_info !!}</div>
                        </div>
                    @endif

                    <!-- Download PDF -->
                    @if(!empty($policy->pdf_file))
                        <div class="text-center mt-5">
                            <a href="{{ asset('storage/' . $policy->pdf_file) }}"
                               class="btn btn-burgundy btn-lg"
                               download>
                                <i class="fas fa-download me-2"></i>
                                Download PDF Version
                            </a>
                        </div>
                    @endif

                </div>

                <!-- Sidebar (Optional) -->
                <div class="col-lg-3 col-12 mt-5 mt-lg-0">
                    <!-- Sidebar Image -->
                    @if(!empty($policy->sidebar_image))
                        <div class="card border-0 shadow-sm mb-4">
                            <img src="{{ asset('storage/' . $policy->sidebar_image) }}"
                                 alt="{{ $policy->title }}"
                                 class="card-img-top rounded">
                        </div>
                    @endif
                    <!-- Quick Links -->
                    <div class="card border-0 shadow-sm mb-4 sticky-sidebar">
                        <div class="card-body">
                            <p class="fw-700 text-dark mb-3">Related Policies</p>
                            @if(isset($relatedPolicies) && $relatedPolicies->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($relatedPolicies as $related)
                                        <a href="{{ route('policies.show', $related->slug) }}"
                                           class="list-group-item list-group-item-action border-0 px-0 py-2">
                                            <small class="text-dark">{{ $related->title }}</small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <a href="{{ route('policies.index') }}" class="text-burgundy text-decoration-none">
                                            <i class="fas fa-file-alt me-2"></i>All Policies
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('contact') }}" class="text-burgundy text-decoration-none">
                                            <i class="fas fa-envelope me-2"></i>Contact Us
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Print/Share -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <p class="fw-700 text-dark mb-3">Actions</p>
                            <div class="d-grid gap-2">
                                <button onclick="window.print()" class="btn btn-outline-burgundy btn-sm">
                                    <i class="fas fa-print me-2"></i>Print Policy
                                </button>
                                <a href="mailto:?subject={{ urlencode($policy->title) }}&body={{ urlencode(request()->url()) }}"
                                   class="btn btn-outline-burgundy btn-sm">
                                    <i class="fas fa-share me-2"></i>Share via Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to Policies -->
    <section class="section-tint py-5">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <p class="fs-5 fw-700 text-dark mb-1">Questions about this policy?</p>
                    <p class="text-muted mb-0">We're here to help. Contact us for any clarifications.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('policies.index') }}" class="btn btn-outline-burgundy mb-0">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to All Policies
                    </a>
                    <a href="{{ route('contact.index') }}" class="btn btn-burgundy mb-0">Contact Us</a>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .policy-text {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #444;
        }

        .policy-text h4,
        .policy-text h5,
        .policy-text h6 {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            color: #1a1a1a;
            font-weight: 600;
        }

        .policy-text p {
            margin-bottom: 1.2rem;
        }

        .policy-text ul,
        .policy-text ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .policy-text li {
            margin-bottom: 0.5rem;
        }

        .policy-text strong {
            color: #1a1a1a;
            font-weight: 600;
        }

        .policy-section {
            padding-bottom: 2rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .policy-section:last-child {
            border-bottom: none;
        }

        .alert-burgundy {
            background-color: #8B0000;
            border-color: #700000;
        }

        @media print {
            .navbar,
            .footer,
            .btn,
            .card:last-child,
            .alert {
                display: none !important;
            }

            .policy-text {
                font-size: 12pt;
                color: #000;
            }
        }
    </style>
@endpush
