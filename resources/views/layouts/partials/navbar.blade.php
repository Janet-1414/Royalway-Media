<nav class="navbar navbar-expand-lg position-sticky top-0 z-index-sticky bg-white border-bottom" style="width: 100%;">
    <div class="container">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/img/logo.svg') }}" alt="RoyalWay Media" width="160px">
        </a>
        <button class="navbar-toggler shadow-none ms-md-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0" id="navigation">
            <ul class="navbar-nav navbar-nav-hover ms-auto">
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
                    @if($navServices->isNotEmpty())
                        <ul class="dropdown-menu">
                            @foreach($navServices as $service)
                                <li><a class="dropdown-item" href="{{ route('services.show', $service->slug) }}">{{ $service->title }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                <li class="nav-item mx-2">
                    <a href="{{ route('projects.index') }}" class="nav-link ps-2 d-flex cursor-pointer {{ request()->routeIs('projects.*') ? 'active' : '' }}">Projects</a>
                </li>
                @php
                    $resourcesActive = request()->routeIs('insights.*', 'assets.*', 'policies.*', 'resources.*');
                @endphp
                <li class="nav-item dropdown" id="resources-dropdown">
                    <a class="nav-link dropdown-toggle {{ $resourcesActive ? 'active' : '' }}" href="{{ route('insights.index') }}" role="button">
                        Resources
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('insights.index') }}">News &amp; Insights</a></li>
                        <li><a class="dropdown-item" href="{{ route('assets.index') }}">Communication Assets</a></li>
                        <li><a class="dropdown-item" href="{{ route('policies.index') }}">Policies</a></li>
                    </ul>
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
<script>
    (function () {
        var mobile = window.matchMedia('(max-width: 991.98px)');
        ['services-dropdown', 'resources-dropdown'].forEach(function (id) {
            var toggle = document.querySelector('#' + id + ' > .dropdown-toggle');
            var menu = document.querySelector('#' + id + ' > .dropdown-menu');
            if (!toggle || !menu) return;
            toggle.setAttribute('aria-expanded', 'false');
            toggle.addEventListener('click', function (e) {
                if (!mobile.matches) return;
                e.preventDefault();
                e.stopPropagation();
                var open = menu.classList.toggle('show');
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });
    })();
</script>
