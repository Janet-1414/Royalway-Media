@extends('layouts.app')

@section('title', 'About Us - RoyalWay Media')

@section('content')
    @php
        $fileUrl = fn ($path) => \App\Models\AboutPage::fileUrl($path);

        $heroImg = $fileUrl($about->hero_image);
        $introImages = collect($about->intro_images ?? [])->map($fileUrl)->filter()->values()->all();
        $hasImgs = count($introImages) > 0;
        $mvpImg = $fileUrl($about->mission_image) ?: asset('assets/img/mission-vision.png');

        $stats = collect($about->stats ?? [])
            ->filter(fn ($s) => filled($s['value'] ?? null) && filled($s['label'] ?? null))
            ->values();

        $strengths = collect($about->strengths ?? [])
            ->filter(fn ($s) => filled($s['title'] ?? null))
            ->values();

        // Desktop column classes that keep the last row of the 3-column grid full
        $sCount = $strengths->count();
        $sRemainder = $sCount % 3;
        $sWideFrom = match (true) {
            $sCount === 1 => 0,
            $sRemainder === 2 => $sCount - 2,
            $sRemainder === 1 => $sCount - 4,
            default => $sCount,
        };

        $hasIntroBody = trim(strip_tags((string) $about->intro_body)) !== '';
        $hasMvp = filled($about->mission) || filled($about->vision) || filled($about->purpose);
    @endphp

        <!-- Banner -->
    <section class="ab-hero"@if($heroImg) style="background-image: linear-gradient(rgba(15, 26, 51, .78), rgba(27, 58, 109, .7)), url('{{ $heroImg }}');"@endif>
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1 class="ab-hero-title">{{ $about->hero_title }}</h1>
                </div>
                @if(filled($about->hero_subtitle))
                    <div class="col-lg-6">
                        <p class="ab-hero-sub">{{ $about->hero_subtitle }}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Who we are -->
    <section class="about-intro-section py-5">
        <div class="container py-lg-3">
            <div class="row g-5 align-items-center {{ $hasImgs ? '' : 'justify-content-center' }}">
                <div class="{{ $hasImgs ? 'col-lg-6' : 'col-lg-10' }}">
                    @if(filled($about->intro_badge))
                        <span class="badge bg-light text-burgundy mb-3">{{ $about->intro_badge }}</span>
                    @endif
                    @if(filled($about->intro_heading))
                        <h2 class="section-heading mb-3">{{ $about->intro_heading }}</h2>
                    @endif
                    @if($hasIntroBody)
                        <div class="ab-prose">{!! $about->intro_body !!}</div>
                    @endif
                </div>

                @if($hasImgs)
                    <div class="col-lg-6">
                        <div class="ab-collage ab-collage-{{ count($introImages) }}">
                            @foreach($introImages as $url)
                                <img src="{{ $url }}" alt="RoyalWay Media" loading="lazy">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            @if($stats->count())
                <div class="row g-3 justify-content-center mt-4 mt-lg-5">
                    @foreach($stats as $stat)
                        <div class="col-6 col-md-{{ intdiv(12, $stats->count()) }}">
                            <div class="ab-stat">
                                <div class="ab-stat-value">{{ $stat['value'] }}</div>
                                <p class="ab-stat-label">{{ $stat['label'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Mission, vision, purpose -->
    @if($hasMvp)
        <section class="mission-vision-section py-5">
            <div class="container py-lg-3">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-5">
                        <img src="{{ $mvpImg }}" alt="RoyalWay Media" class="ab-mvp-img" loading="lazy">
                    </div>
                    <div class="col-lg-7">
                        <div class="d-flex flex-column gap-3">
                            @foreach([
                                ['fa-bullseye', 'Mission', $about->mission],
                                ['fa-eye', 'Vision', $about->vision],
                                ['fa-compass', 'Our Purpose', $about->purpose],
                            ] as [$icon, $label, $text])
                                @if(filled($text))
                                    <div class="ab-mvp-item">
                                        <span class="ab-mvp-icon"><i class="fa-solid {{ $icon }}"></i></span>
                                        <div>
                                            <h3>{{ $label }}</h3>
                                            <p>{!! nl2br(e($text)) !!}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Strengths -->
    @if($sCount > 0)
        @php $stImg = $fileUrl($about->strengths_image); @endphp
        <section class="st-section{{ $stImg ? ' has-img' : '' }}">
            @if($stImg)
                <div class="st-bg" style="background-image: url('{{ $stImg }}');"></div>
            @endif
            <div class="container">
                <div class="st-head">
                    @if(filled($about->strengths_badge))
                        <span class="st-badge">{{ $about->strengths_badge }}</span>
                    @endif
                    @if(filled($about->strengths_intro))
                        <h2 class="st-intro">{{ $about->strengths_intro }}</h2>
                    @endif
                </div>
                <div class="st-list">
                    @foreach($strengths as $i => $item)
                        <div class="st-row">
                            <span class="st-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="st-icon"><i class="fa-solid {{ $item['icon'] ?? 'fa-star' }}"></i></span>
                            <h3 class="st-title">{{ $item['title'] }}</h3>
                            @if(filled($item['body'] ?? null))
                                <p class="st-body">{{ $item['body'] }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Closing banner -->
    @if(filled($about->cta_title))
        <section class="cta-section text-white py-5">
            <div class="container text-center position-relative py-lg-3">
                <h2 class="cta-title text-white mb-3">{{ $about->cta_title }}</h2>
                @if(filled($about->cta_text))
                    <p class="cta-subtitle text-white mb-4">{{ $about->cta_text }}</p>
                @endif
                <a href="{{ route('contact.index') }}" class="btn btn-warning btn-lg fw-semibold px-5">Contact Us Today</a>
            </div>
        </section>
    @endif
@endsection
