{{-- File Path: resources/views/insights/index.blade.php --}}

@extends('layouts.app')

@section('title', 'News & Insights - RoyalWay Media')
@section('seo_description', $hero->intro)

@php
    // Article page when there is content, otherwise the attached file
    $postUrl = fn ($p) => $p->content
        ? route('resources.show', $p->slug)
        : ($p->file_url ?: route('resources.show', $p->slug));
    $hasImage = fn ($p) => $p->show_cover && $p->image_url;
    $filtering = $search !== '' || $topic !== '';
@endphp

@section('content')

    <!-- Hero (editable under Content Management > Page Heroes) -->
    @include('partials.page-hero', [
        'hero' => $hero,
        'eyebrow' => 'RoyalWay News & Insights',
        'icon' => 'fa-newspaper',
        'actions' => [
            ['label' => 'Read the latest', 'url' => $lead ? '#latest' : '#posts'],
            ['label' => 'Get in touch', 'url' => route('contact.index'), 'style' => 'ghost'],
        ],
    ])

    <!-- Lead story and latest headlines -->
    @if($lead)
        <section class="na-top" id="latest" aria-labelledby="na-lead-title">
            <div class="container">
                <div class="row g-4 g-xl-5">
                    <div class="col-lg-7">
                        <article class="na-lead">
                            <a href="{{ $postUrl($lead) }}" class="na-lead-img" tabindex="-1" aria-hidden="true">
                                @if($hasImage($lead))
                                    <img src="{{ $lead->image_url }}" alt="">
                                @else
                                    <span class="in-card-ph"><i class="fas fa-newspaper"></i></span>
                                @endif
                            </a>
                            <div class="na-lead-body">
                                <span class="na-topic">{{ $lead->topic ?: 'Featured' }}</span>
                                <h2 class="na-lead-title" id="na-lead-title"><a href="{{ $postUrl($lead) }}">{{ $lead->title }}</a></h2>
                                @if($lead->excerpt)
                                    <p class="na-lead-text">{{ Str::limit($lead->excerpt, 220) }}</p>
                                @endif
                                <p class="na-meta">
                                    @if($lead->published_at)
                                        <time datetime="{{ $lead->published_at->toDateString() }}">{{ $lead->formatted_published_date }}</time>
                                    @endif
                                    @if($lead->content)
                                        <span>{{ $lead->reading_time }} min read</span>
                                    @endif
                                </p>
                            </div>
                        </article>
                    </div>

                    @if($headlines->count())
                        <div class="col-lg-5">
                            <div class="na-stack">
                                <h2 class="na-stack-label">Latest headlines</h2>
                                <ul class="na-stack-list">
                                    @foreach($headlines as $item)
                                        <li>
                                            <a href="{{ $postUrl($item) }}" class="na-headline">
                                                <span class="na-headline-img">
                                                    @if($hasImage($item))
                                                        <img src="{{ $item->image_url }}" alt="" loading="lazy">
                                                    @else
                                                        <span class="in-card-ph"><i class="fas fa-newspaper"></i></span>
                                                    @endif
                                                </span>
                                                <span class="na-headline-body">
                                                    @if($item->topic)
                                                        <span class="na-topic">{{ $item->topic }}</span>
                                                    @endif
                                                    <span class="na-headline-title">{{ $item->title }}</span>
                                                    @if($item->published_at)
                                                        <span class="na-meta">{{ $item->formatted_published_date }}</span>
                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- All articles -->
    <section class="in-section na-browse" id="posts">
        <div class="container">
            <div class="na-browse-head">
                <div>
                    <span class="in-eyebrow">Browse</span>
                    <h2 class="section-heading mb-0">{{ $filtering ? 'Search results' : 'More news and insights' }}</h2>
                </div>
                <form action="{{ route('insights.index') }}#posts" method="GET" class="in-search na-search" role="search">
                    @if($topic !== '')
                        <input type="hidden" name="topic" value="{{ $topic }}">
                    @endif
                    <div class="search-wrapper">
                        <label for="insights-search" class="visually-hidden">Search news and insights</label>
                        <input type="text" id="insights-search" name="search" class="form-control" placeholder="Search insights..." value="{{ $search }}">
                        <button class="search-btn" type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>

            @if($topics->count())
                <nav class="na-chips" aria-label="Filter by topic">
                    <a href="{{ route('insights.index', array_filter(['search' => $search])) }}#posts"
                       class="na-chip{{ $topic === '' ? ' is-active' : '' }}"
                       @if($topic === '') aria-current="page" @endif>All topics</a>
                    @foreach($topics as $t)
                        <a href="{{ route('insights.index', array_filter(['topic' => $t, 'search' => $search])) }}#posts"
                           class="na-chip{{ $topic === $t ? ' is-active' : '' }}"
                           @if($topic === $t) aria-current="page" @endif>{{ $t }}</a>
                    @endforeach
                </nav>
            @endif

            @if($filtering)
                <p class="in-results">
                    {{ $posts->total() }} {{ Str::plural('result', $posts->total()) }}
                    @if($search !== '') for &ldquo;{{ $search }}&rdquo; @endif
                    @if($topic !== '') in {{ $topic }} @endif
                    <a href="{{ route('insights.index') }}#posts">Clear</a>
                </p>
            @endif

            <div class="row g-4 mt-1">
                @forelse($posts as $post)
                    @php $url = $postUrl($post); @endphp
                    <div class="col-lg-4 col-md-6 col-12">
                        <article class="in-card na-card">
                            <a href="{{ $url }}" class="in-card-img" tabindex="-1" aria-hidden="true">
                                @if($hasImage($post))
                                    <img src="{{ $post->image_url }}" alt="" loading="lazy">
                                @else
                                    <span class="in-card-ph"><i class="fas fa-newspaper"></i></span>
                                @endif
                            </a>
                            <div class="in-card-body">
                                @if($post->topic)
                                    <span class="na-topic">{{ $post->topic }}</span>
                                @endif
                                <h3 class="in-card-title"><a href="{{ $url }}">{{ $post->title }}</a></h3>
                                <p class="na-meta mt-auto">
                                    @if($post->published_at)
                                        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->formatted_published_date }}</time>
                                    @endif
                                    @if($post->author)
                                        <span>{{ $post->author }}</span>
                                    @endif
                                    @if($post->content)
                                        <span>{{ $post->reading_time }} min read</span>
                                    @endif
                                </p>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="in-empty">
                            <i class="fas fa-newspaper" aria-hidden="true"></i>
                            <p>
                                @if($filtering)
                                    No insights match your search.
                                @elseif($lead)
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
