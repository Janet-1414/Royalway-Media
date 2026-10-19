<div class="container-fluid position-sticky z-index-sticky top-0 bg-white">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 position-absolute my-3 py-2 start-0 end-0 border-burgundy">
                <div class="container-fluid px-0">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/logo.svg') }}" alt="RoyalWay Media" class="mx-3" width="160px">
                    </a>
                    <button class="navbar-toggler shadow-none ms-md-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                    <div class="collapse navbar-collapse w-60 pt-3 pb-2 py-lg-0" id="navigation">
                        <div class="me-auto"></div>
                        <ul class="navbar-nav navbar-nav-hover mx-0">
                            <li class="nav-item mx-2">
                                <a href="{{ route('home') }}" class="nav-link ps-2 d-flex cursor-pointer {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a href="{{ route('about') }}" class="nav-link ps-2 d-flex cursor-pointer {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                            </li>
                            <li class="nav-item dropdown" id="services-dropdown">
                                <a class="nav-link dropdown-toggle" href="{{ route('services.index') }}" role="button">
                                    Services
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('services.show', 'marketing-communications') }}">Marketing Communications</a></li>
                                    <li><a class="dropdown-item" href="{{ route('services.show', 'experiential-marketing') }}">Experiential Marketing</a></li>
                                    <li><a class="dropdown-item" href="{{ route('services.show', 'strategic-communications-visibility') }}">Strategic Communications & Visibility</a></li>
                                    <li><a class="dropdown-item" href="{{ route('services.show', 'pr-media-management') }}">PR & Media Management</a></li>
                                    <li><a class="dropdown-item" href="{{ route('services.show', 'corporate-events-planning-management') }}">Corporate Events Planning & Management</a></li>
                                    <li><a class="dropdown-item" href="{{ route('services.show', 'social-behavioral-change-communications') }}">Social & Behavioral Change Communications</a></li>
                                </ul>
                            </li>
                            <li class="nav-item mx-2">
                                <a href="{{ route('projects.index') }}" class="nav-link ps-2 d-flex cursor-pointer {{ request()->routeIs('projects.*') ? 'active' : '' }}">Projects</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a href="{{ route('resources.index') }}" class="nav-link ps-2 d-flex cursor-pointer {{ request()->routeIs('resources.*') ? 'active' : '' }}">Resources</a>
                            </li>
                            <li class="nav-item mx-2">
                                <a href="{{ route('contact.index') }}" class="nav-link ps-2 d-flex cursor-pointer {{ request()->routeIs('contact.*') ? 'active' : '' }}">Contact</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a href="{{ route('event-brief.index') }}" class="btn btn-sm btn-burgundy btn-round mb-0 ms-3">Start a Project</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
