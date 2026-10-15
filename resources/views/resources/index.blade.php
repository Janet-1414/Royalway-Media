@extends('layouts.app')

@section('title', 'Resources - RoyalWay Media')

@section('content')

    <!-- Page Header -->

    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">Resources</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->

    <section class="filter-section py-4">
        <div class="container">
            <form action="{{ route('resources.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-4 col-md-6 col-12">
                        <select class="form-select" name="type" id="typeFilter" onchange="this.form.submit()">
                            <option value="">All Types</option>
                            @foreach($types as $key => $label)
                                <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="search-wrapper">
                            <input type="text" name="search" class="form-control" placeholder="Search resources..." value="{{ request('search') }}">
                            <button class="search-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Resources Grid -->

    <section class="projects-grid-section py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($resources as $resource)
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="project-card h-100">
                            @if($resource->show_cover && $resource->image_url)
                                <div class="project-image">
                                    <img src="{{ $resource->image_url }}" alt="{{ $resource->title }}" class="img-fluid">
                                </div>
                            @endif
                            <div class="project-content d-flex flex-column flex-grow-1">
                        <span class="project-tag">
                            @switch($resource->type)
                                @case('blog') Blog Post @break
                                @case('publication') Publication @break
                                @case('communication_asset') Communication Asset @break
                                @default {{ ucfirst($resource->type) }}
                            @endswitch
                        </span>
                                <h4 class="text-dark-emphasis mt-3 mb-2">{{ $resource->title }}</h4>
                                @if($resource->excerpt)
                                    <p class="text-muted mb-3">{{ Str::limit($resource->excerpt, 100) }}</p>
                                @endif


                                @if($resource->author)
                                    <p class="text-muted mb-2"><small><i class="fas fa-user me-1"></i>{{ $resource->author }}</small></p>
                                @endif

                                @if($resource->published_at)
                                    <p class="text-muted mb-3"><small><i class="fas fa-calendar me-1"></i>{{ $resource->formatted_published_date }}</small></p>
                                @endif

                                <div class="d-flex gap-2">
                                    @if($resource->content)
                                        <a href="{{ route('resources.show', $resource->slug) }}" class="cta-link">
                                            Read More <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    @endif

                                    @if($resource->file)
                                        <a href="{{ asset('storage/' . $resource->file) }}" class="cta-link ms-auto" download>
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>No resources found. Try adjusting your filters.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($resources->hasPages())
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            {{ $resources->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>


    </section>
@endsection
