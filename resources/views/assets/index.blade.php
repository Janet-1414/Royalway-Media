{{-- File Path: resources/views/assets/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Communication Assets - RoyalWay Media')
@section('seo_description', $hero->intro)

@php
    $filtering = $search !== '' || $format !== '' || $activeProject;
@endphp

@section('content')

    <!-- Hero (editable under Content Management > Page Heroes) -->
    @include('partials.page-hero', [
        'hero' => $hero,
        'eyebrow' => 'Communication Assets',
        'icon' => 'fa-photo-film',
        'actions' => [
            ['label' => 'Browse materials', 'url' => '#assets'],
            ['label' => 'Start a project', 'url' => route('event-brief.index'), 'style' => 'ghost'],
        ],
    ])

    <section class="in-section ca-section" id="assets">
        <div class="container">
            <form action="{{ route('assets.index') }}#assets" method="GET" class="ca-filters" role="search" aria-label="Filter communication assets">
                <div class="ca-filter ca-filter--search">
                    <label for="ca-search" class="ca-filter-label">Search</label>
                    <div class="search-wrapper">
                        <input type="text" id="ca-search" name="search" class="form-control" placeholder="Search materials..." value="{{ $search }}">
                        <button class="search-btn" type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="ca-filter">
                    <label for="ca-format" class="ca-filter-label">File type</label>
                    <select id="ca-format" name="format" class="form-select" data-autosubmit>
                        <option value="">All file types</option>
                        @foreach(\App\Models\Resource::FILE_GROUP_LABELS as $key => $label)
                            <option value="{{ $key }}" @selected($format === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @if($projects->count())
                    <div class="ca-filter">
                        <label for="ca-project" class="ca-filter-label">Project</label>
                        <select id="ca-project" name="project" class="form-select" data-autosubmit>
                            <option value="">All projects</option>
                            @foreach($projects as $p)
                                <option value="{{ $p->slug }}" @selected($activeProject && $activeProject->slug === $p->slug)>{{ $p->title }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <noscript><button type="submit" class="btn btn-burgundy mb-0">Apply</button></noscript>
            </form>

            @if($filtering)
                <p class="in-results">
                    {{ $assets->total() }} {{ Str::plural('item', $assets->total()) }}
                    @if($activeProject) from <a href="{{ route('projects.show', $activeProject->slug) }}" class="ms-0">{{ $activeProject->title }}</a> @endif
                    <a href="{{ route('assets.index') }}#assets">Clear filters</a>
                </p>
            @endif

            <div class="row g-4 mt-1">
                @forelse($assets as $asset)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                        @include('partials.asset-card', ['asset' => $asset])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="in-empty">
                            <i class="fas fa-folder-open" aria-hidden="true"></i>
                            <p>{{ $filtering ? 'No materials match these filters.' : 'Communication assets will be shared here soon.' }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($assets->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $assets->fragment('assets')->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    <!-- Closing banner -->
    <section class="cta-section text-white py-5">
        <div class="container text-center position-relative py-lg-3">
            <h2 class="cta-title text-white mb-3">Need materials like these for your campaign?</h2>
            <p class="cta-subtitle text-white mb-4">Our team creates reports, visuals, videos and campaign kits that people remember.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-warning btn-lg fw-semibold px-5">Talk to Us</a>
        </div>
    </section>

    @include('partials.asset-preview-modal', ['autoOpen' => $previewAsset, 'syncUrl' => true])
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.ca-filters [data-autosubmit]').forEach(function (select) {
        select.addEventListener('change', function () { select.form.submit(); });
    });
</script>
@endpush
