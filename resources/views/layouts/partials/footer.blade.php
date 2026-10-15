@php
    $footerAbout = setting('footer_about', 'At RoyalWay Media, we redefine excellence in integrated marketing and communications. Specializing in PR, Branding, Marketing, and Behavioral Change Communications, we transform ambitions into thriving brands.');
    $copyrightName = setting('copyright_name', 'RoyalWay Media Ltd');
    $logoWhite = setting_file_url('logo_white', asset('assets/img/logo-white.png'));
    $facebook = setting('social_facebook', 'https://www.facebook.com/RoyalWayMediaLtd');
    $twitter = setting('social_twitter', 'https://twitter.com/RoyalWayMedia');
    $instagram = setting('social_instagram', 'https://www.instagram.com/royalwaymedia');
    $linkedin = setting('social_linkedin', 'https://www.linkedin.com/company/royalway-media/');
    $youtube = setting('social_youtube', 'https://www.youtube.com/channel/UC5292sL9n6DTH7p7Yh8HmOg/videos');
    $companyProfilePdf = setting_file_url('company_profile_pdf');
    $companyProfileUrl = setting('company_profile_url');
    $companyProfileLink = $companyProfilePdf ?: $companyProfileUrl;
@endphp

<footer class="footer py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="d-flex flex-column h-100">
                    <img src="{{ $logoWhite }}" width="137px" alt="{{ setting('site_name', 'RoyalWay Media') }}" class="mb-3" loading="lazy">
                    <p class="text-white mb-4">
                        {{ $footerAbout }}
                    </p>
                    <div class="mt-auto">
                        <div class="d-flex social-icons">
                            @if($facebook)
                            <a href="{{ $facebook }}" class="text-warning me-3" aria-label="Facebook" target="_blank" rel="noopener">
                                <i class="fa-brands fa-facebook-f fa-lg"></i>
                            </a>
                            @endif
                            @if($twitter)
                            <a href="{{ $twitter }}" class="text-warning me-3" aria-label="X (Twitter)" target="_blank" rel="noopener">
                                <i class="fa-brands fa-x-twitter fa-lg"></i>
                            </a>
                            @endif
                            @if($instagram)
                            <a href="{{ $instagram }}" class="text-warning me-3" aria-label="Instagram" target="_blank" rel="noopener">
                                <i class="fa-brands fa-instagram fa-lg"></i>
                            </a>
                            @endif
                            @if($linkedin)
                            <a href="{{ $linkedin }}" class="text-warning me-3" aria-label="LinkedIn" target="_blank" rel="noopener">
                                <i class="fa-brands fa-linkedin-in fa-lg"></i>
                            </a>
                            @endif
                            @if($youtube)
                            <a href="{{ $youtube }}" class="text-warning" aria-label="YouTube" target="_blank" rel="noopener">
                                <i class="fa-brands fa-youtube fa-lg"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-2 col-6 mb-4 mb-md-0">
                <p class="text-yellow fw-700 mb-3">Menu</p>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ route('services.index') }}">Services</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ route('projects.index') }}">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white p-0" href="{{ route('contact.index') }}">Contact</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-2 col-6 mb-4 mb-md-0">
                <p class="text-yellow fw-700 mb-3">Quick Links</p>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ route('resources.index') }}">Resources</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ route('resources.index', ['type' => 'blog']) }}">Blog</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ route('policies.index') }}">Policies</a>
                    </li>
                    @if($companyProfileLink)
                    <li class="nav-item mb-2">
                        <a class="nav-link text-white p-0" href="{{ $companyProfileLink }}" target="_blank" rel="noopener">Company Profile</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link text-white p-0" href="{{ route('resources.index', ['type' => 'publication']) }}">Publications</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6">
                <p class="text-yellow fw-700 mb-3">Newsletter</p>
                <p class="text-white mb-3">
                    Subscribe our newsletter to get our latest update & news
                </p>
                <form class="row g-2 newsletter-form" action="#" method="POST">
                    @csrf
                    <div class="col-8">
                        <div class="input-group">
                            <input type="email" name="email" class="form-control form-control-sm" placeholder="Enter your e-mail" aria-label="Email" required>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-outline-primary btn-sm">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <hr class="bg-white">
                <p class="small text-white mb-0">
                    Copyright &copy; {{ date('Y') }} {{ $copyrightName }}. All Rights Reserved.
                </p>
            </div>
        </div>
    </div>

</footer>
