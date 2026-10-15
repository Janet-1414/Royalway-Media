@extends('layouts.app')

@section('title', 'Our Projects - RoyalWay Media')

@section('content')

    <!-- Page Header -->

    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">Our Work</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter Section -->

    <section class="filter-section py-4">
        <div class="container">
            <form action="{{ route('projects.index') }}" method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-3 col-md-4 col-12">
                        <select class="form-select" name="category" id="categoryFilter" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-4 col-12">
                        <select class="form-select" name="company" id="companyFilter">
                            <option value="">Type Company</option>
                            <option value="corporate" {{ request('company') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                            <option value="ngo" {{ request('company') == 'ngo' ? 'selected' : '' }}>NGO/Development</option>
                            <option value="government" {{ request('company') == 'government' ? 'selected' : '' }}>Government</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-md-4 col-12">
                        <div class="search-wrapper">
                            <input type="text" name="search" class="form-control" placeholder="Search something" value="{{ request('search') }}" id="searchInput">
                            <button class="search-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Projects Grid -->

    <section class="projects-grid-section py-5">
        <div class="container">
            <div class="row g-4">
                @forelse($projects as $project)
                    <div class="col-lg-4 col-md-6 col-12">
                        <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none">
                            <div class="project-card">
                                <div class="project-image">
                                    <img src="{{ asset('storage/' . $project->featured_image) }}" alt="{{ $project->title }}" class="img-fluid">
                                </div>
                                <div class="project-content">
                                    <span class="project-tag">{{ $project->category }}</span>
                                    <p class="fw-700 text-dark-emphasis mt-3 mb-2">{{ $project->title }}</p>
                                    <p class="text-muted mb-3">{{ Str::limit($project->description, 100) }}</p>
                                    <span class="cta-link">Learn More <i class="fas fa-arrow-right ms-2"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>No projects found. Try adjusting your filters.
                        </div>
                    </div>
                @endforelse
            </div>


            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="row mt-5">
                    <div class="col-12">
                        <nav aria-label="Page navigation">
                            {{ $projects->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>


    </section>
@endsection
