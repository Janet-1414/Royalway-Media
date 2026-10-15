@extends('layouts.app')

@section('title', $resource->title . ' - RoyalWay Media')

@section('content')

    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">{{ $resource->title }}</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Resource Content Section -->
    <section class="resource-content-section py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Main Content -->
                <div class="col-lg-8 col-12">
                    @if($resource->show_cover && $resource->image_url)
                        <div class="mb-4">
                            <img src="{{ $resource->image_url }}"
                                 alt="{{ $resource->title }}"
                                 class="img-fluid rounded">
                        </div>
                    @endif

                    <!-- Resource Meta Info -->
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        @if($resource->category)
                            <span class="badge bg-burgundy">{{ $resource->category }}</span>
                        @endif
                        @if($resource->published_at)
                            <span class="text-muted">
                                <i class="far fa-calendar me-2"></i>
                                {{ $resource->published_at->format('F d, Y') }}
                            </span>
                        @endif
                        @if($resource->author)
                            <span class="text-muted">
                                <i class="far fa-user me-2"></i>
                                {{ $resource->author }}
                            </span>
                        @endif
                    </div>

                    <!-- Resource Content -->
                    <div class="resource-body">
                        {!! $resource->content !!}
                    </div>

                    <!-- Download/Attachments -->
                    @if($resource->attachments && count($resource->attachments) > 0)
                        <div class="resource-attachments mt-5 p-4 bg-light rounded">
                            <p class="fw-700 text-dark mb-3">Downloads & Attachments</p>
                            <div class="list-group">
                                @foreach($resource->attachments as $attachment)
                                    <a href="{{ asset('storage/' . $attachment['file']) }}"
                                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                                       download>
                                        <div>
                                            <i class="fas fa-file-download me-2"></i>
                                            {{ $attachment['name'] ?? 'Download File' }}
                                        </div>
                                        <span class="badge bg-burgundy">
                                            {{ $attachment['size'] ?? '' }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Tags -->
                    @if($resource->tags)
                        <div class="resource-tags mt-4">
                            <p class="fw-700 text-dark mb-3">Tags:</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $resource->tags) as $tag)
                                    <span class="badge bg-light text-dark border">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-12">
                    <!-- Resource Details Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fw-700 text-dark mb-3">Resource Details</p>

                            @if($resource->category)
                                <div class="mb-3">
                                    <p class="fw-semibold text-dark-emphasis mb-1">Category</p>
                                    <p class="text-muted mb-0">{{ $resource->category }}</p>
                                </div>
                            @endif

                            @if($resource->type)
                                <div class="mb-3">
                                    <p class="fw-semibold text-dark-emphasis mb-1">Type</p>
                                    <p class="text-muted mb-0">{{ $resource->type }}</p>
                                </div>
                            @endif

                            @if($resource->published_at)
                                <div class="mb-3">
                                    <p class="fw-semibold text-dark-emphasis mb-1">Published</p>
                                    <p class="text-muted mb-0">{{ $resource->published_at->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Share Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <p class="fw-700 text-dark mb-3">Share This Resource</p>
                            <div class="d-flex gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fa-brands res fa-facebook-f fa-lg"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($resource->title) }}"
                                   target="_blank"
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fa-brands res fa-x-twitter fa-lg"></i>
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($resource->title) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fa-brands res fa-linkedin-in fa-lg"></i>
                                </a>
                                <a href="mailto:?subject={{ urlencode($resource->title) }}&body={{ urlencode(request()->url()) }}"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="fa res fa-envelope fa-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Related Resources -->
                    @if(isset($relatedResources) && $relatedResources->count() > 0)
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <p class="fw-700 text-dark mb-3">Related Resources</p>
                                <div class="list-group list-group-flush">
                                    @foreach($relatedResources as $related)
                                        <a href="{{ route('resources.show', $related->slug) }}"
                                           class="list-group-item list-group-item-action border-0 px-0">
                                            <div class="d-flex align-items-start">
                                                @if($related->show_cover && $related->image_url)
                                                    <img src="{{ $related->image_url }}"
                                                         alt="{{ $related->title }}"
                                                         class="rounded me-3"
                                                         style="width: 60px; height: 60px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <p class="fw-semibold mb-1 text-dark">{{ Str::limit($related->title, 50) }}</p>
                                                    <small class="text-muted">{{ $related->category }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .resource-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        .resource-body h2,
        .resource-body h3,
        .resource-body h4 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #1a1a1a;
        }

        .resource-body p {
            margin-bottom: 1.5rem;
        }

        .resource-body ul,
        .resource-body ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
        }

        .resource-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 2rem 0;
        }

        .resource-body blockquote {
            border-left: 4px solid #8B0000;
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            color: #666;
        }

        /* Share buttons styling */
        .btn i {
            font-size: 1.25rem !important;
            line-height: 1;
        }

        .res {
            color: #38558a;
        }
    </style>
@endpush
