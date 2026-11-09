{{-- File Path: resources/views/insights/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Insights - RoyalWay Media')

@php
    // Article page when there is content, otherwise the attached file
    $postUrl = fn ($p) => $p->content
        ? route('resources.show', $p->slug)
        : ($p->file ? asset('storage/' . $p->file) : '#');
@endphp

@section('content')

    <!-- Hero -->
    <section class="in-hero">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-center">
                <div class="col-lg-5">
                    @if($featured)
                        <a href="{{ $postUrl($featured) }}" class="in-feature">
                            @if($featured->show_cover && $featured->image_url)
                                <img src="{{ $featured->image_url }}" alt="{{ $featured->title }}">
                            @endif
                            <span class="in-feature-cap">
                                <span class="in-pill">Latest</span>
                                <span class="in-feature-title">{{ Str::limit($featured->title, 90) }}</span>
                            </span>
                        </a>
                    @else
                        <div class="in-feature"></div>
                    @endif
                </div>
                <div class="col-lg-7">
                    <div class="in-hero-text">
                        <h1 class="in-hero-title">Insights on communication that moves people</h1>
                        <div class="in-rule"></div>
                        <p>Industry perspectives, campaign lessons and thought leadership from the RoyalWay Media team.</p>
                        <div class="in-hero-actions">
                            <a href="#posts" class="btn btn-burgundy fw-semibold px-4 py-2">Read the latest</a>
                            <a href="{{ route('contact.index') }}" class="in-ghost">Get in touch <i class="fas fa-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Articles -->
    <section class="in-section" id="posts">
        <div class="container">
            <div class="text-center">
                <span class="in-eyebrow">RoyalWay Insights</span>
                <h2 class="section-heading">Industry perspectives</h2>

                <form action="{{ route('insights.index') }}" method="GET" class="in-search">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="form-control" placeholder="Search insights..." value="{{ $search }}">
                        <button class="search-btn" type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
                    </div>
                </form>

                @if($search !== '')
                    <p class="in-results">Showing results for &ldquo;{{ $search }}&rdquo; <a href="{{ route('insights.index') }}#posts">Clear</a></p>
                @endif
            </div>

            <div class="row g-4 mt-2">
                @forelse($posts as $post)
                    @php $url = $postUrl($post); @endphp
                    <div class="col-lg-4 col-md-6 col-12">
                        <article class="in-card">
                            <a href="{{ $url }}" class="in-card-img" aria-label="{{ $post->title }}">
                                @if($post->show_cover && $post->image_url)
                                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" loading="lazy">
                                @else
                                    <span class="in-card-ph"><i class="fas fa-newspaper"></i></span>
                                @endif
                            </a>
                            <div class="in-card-body">
                                @if($post->published_at || $post->author)
                                    <div class="in-meta">
                                        @if($post->published_at)
                                            <span><i class="fas fa-calendar"></i>{{ $post->formatted_published_date }}</span>
                                        @endif
                                        @if($post->author)
                                            <span><i class="fas fa-user"></i>{{ $post->author }}</span>
                                        @endif
                                    </div>
                                @endif
                                <h3 class="in-card-title"><a href="{{ $url }}">{{ $post->title }}</a></h3>
                                @if($post->excerpt)
                                    <p class="in-card-text">{{ Str::limit($post->excerpt, 130) }}</p>
                                @endif
                                <a href="{{ $url }}" class="in-more">Read more <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="in-empty">
                            <i class="fas fa-newspaper"></i>
                            <p>
                                @if($search !== '')
                                    No insights match your search.
                                @elseif($featured)
                                    More insights are coming soon.
                                @else
                                    No insights have been published yet. Please check back soon.
                                @endif
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($posts->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $posts->fragment('posts')->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    <!-- Closing banner -->
    <section class="cta-section text-white py-5">
        <div class="container text-center position-relative py-lg-3">
            <h2 class="cta-title text-white mb-3">Communication is the bridge to influence, trust and growth</h2>
            <p class="cta-subtitle text-white mb-4">Talk to our team about your next campaign, event or brand story.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-warning btn-lg fw-semibold px-5">Contact Us Today</a>
        </div>
    </section>
@endsection
