@extends('layouts.app')

@section('title', 'About Us - RoyalWay Media')

@section('content')
    @php
        $companyProfilePdf = setting_file_url('company_profile_pdf');
        $companyProfileUrl = setting('company_profile_url');
        $companyProfileLink = $companyProfilePdf ?: $companyProfileUrl;
    @endphp

    <!-- Page Header -->
    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">About Us</h1>
                    @if($companyProfileLink)
                        <a href="{{ $companyProfileLink }}" class="btn btn-outline-light mt-3" target="_blank" rel="noopener">
                            <i class="fas fa-file-pdf me-2"></i>Download Company Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- About Intro Section -->
    <section class="about-intro-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-12 mb-3">
                    <span class="badge bg-light text-burgundy">ABOUT US</span>
                </div>
                <div class="col-lg-10 col-12">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <p class="text-muted">
                                RoyalWay Media Ltd is a premier integrated communications firm based in Kampala, Uganda,
                                dedicated to elevating brands and transforming ambitions into lasting communications impact.
                                With more than 15 years of proven expertise, we deliver 360-degree solutions that seamlessly
                                blend strategic public relations, powerful branding, innovative marketing, behavioral change
                                communications, digital engagement, advertising, experiential events, and more. Our in-house
                                team of creative strategists, storytellers, and industry specialists approaches every project with
                                creativity, reliability, and unmatched speed of delivery—building meaningful connections
                                between organizations and their audiences.
                            </p>
                            <p class="text-muted">
                                We partner closely with corporate entities, development organizations, and ambitious brands
                                across East Africa and beyond, helping them navigate complex communication landscapes,
                                amplify their voice, and achieve measurable results. Whether crafting compelling narratives,
                                managing high-profile events, driving behavioral transformation, or executing integrated
                                campaigns, we bring passion, precision, and a deep understanding of local and regional
                                dynamics to every engagement.
                            </p>
                            <p class="text-muted">
                                At RoyalWay Media Ltd, communication is more than a service—it&#39;s <strong>the bridge to influence,
                                    trust, and growth. We don&#39;t just tell your story; we make it resonate.</strong>
                            </p>
                        </div>
{{--                        <div class="col-md-6 mb-3">--}}
{{--                            <p class="text-muted">--}}
{{--                                Delivering communications campaigns &amp; conversations to clients across all sectors--}}
{{--                            </p>--}}
{{--                            <ul class="list-unstyled">--}}
{{--                                <li class="mb-2"><i class="fas fa-check text-burgundy me-2"></i>Telecoms</li>--}}
{{--                                <li class="mb-2"><i class="fas fa-check text-burgundy me-2"></i>Banking</li>--}}
{{--                                <li class="mb-2"><i class="fas fa-check text-burgundy me-2"></i>Beverages</li>--}}
{{--                                <li class="mb-2"><i class="fas fa-check text-burgundy me-2"></i>Health Promotions</li>--}}
{{--                                <li class="mb-2"><i class="fas fa-check text-burgundy me-2"></i>Development Partners- UN Agencies, EU, aBi Development and others</li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Vision Section -->
    <section class="mission-vision-section py-5">
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col-lg-6 col-12">
                    <img src="{{ asset('assets/img/mission-vision.png') }}" alt="Team Meeting" class="img-fluid w-100 mission-image">
                </div>
                <div class="col-lg-6 col-12 mission-content">
                    <div class="p-5">
                        <div class="mb-5">
                            <h3 class="text-white mb-3">Mission</h3>
                            <p class="text-white">
                                Our mission is to transform communication offerings into an integrated delivery model that
                                provides our clients with one single point of contact for their entire communication programs and
                                all strategic perspectives of their brands.
                            </p>
                        </div>
                        <div class="mb-5">
                            <h3 class="text-white mb-3">Vision</h3>
                            <p class="text-white">
                                To become a world-class communications service provider through the provision of innovative
                                and superior service and total client attachment.
                            </p>
                        </div>
                        <div>
                            <h3 class="text-white mb-3">Our Purpose</h3>
                            <p class="text-white">
                                Our Purpose is to power and deliver superior value to our clients through integrated
                                communication solutions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Purpose Section -->
    <section class="purpose-section py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <span class="badge bg-light text-burgundy mb-3">Our Strengths</span>
                    <p class="section-intro fw-semibold text-dark">Our Purpose is to power and deliver superior value to our clients through integrated communication solutions.</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="purpose-card">
                        <div class="purpose-icon mb-3">
                            <i class="fa-solid fa-circle-nodes fa-2x text-burgundy"></i>
                        </div>
                        <h4 class="text-dark-emphasis mb-3">Integrated 360-Degree communications &amp; marketing approach</h4>
                        <p class="text-muted">
                            RoyalWay excels at providing comprehensive, end-to-end communications
                            solutions—seamlessly blending PR, branding, advertising, digital marketing, behavioral change
                            communications, experiential events, media management, and more—under one roof for
                            maximum impact and consistency.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="purpose-card">
                        <div class="purpose-icon mb-3">
                            <i class="fa-solid fa-award fa-2x text-burgundy"></i>
                        </div>
                        <h4 class="text-dark-emphasis mb-3">Proven Expertise and Track Record</h4>
                        <p class="text-muted">
                            With over a decade of experience we have successfully partnered with major multinational
                            corporations (e.g., MTN Uganda, Standard Chartered Bank, ABSA,Airtel Uganda, Total E&amp;P),
                            development organizations (e.g., European Union, aBi Finance,UNDP, UNICEF, UN Women),
                            and government bodies across East Africa, delivering measurable results in complex markets.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="purpose-card">
                        <div class="purpose-icon mb-3">
                            <i class="fa-solid fa-bolt fa-2x text-burgundy"></i>
                        </div>
                        <h4 class="text-dark-emphasis mb-3">Creativity Combined with Reliability and Speed</h4>
                        <p class="text-muted">Royalway Media is widely recognized for its creative storytelling, innovative strategies, and
                            unmatched speed of delivery—qualities that set them apart in high-stakes campaigns,
                            activations, and time-sensitive projects while maintaining consistent quality and professionalism.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 col-md-6">
                    <div class="purpose-card">
                        <div class="purpose-icon mb-3">
                            <i class="fa-solid fa-map-location-dot fa-2x text-burgundy"></i>
                        </div>
                        <h4 class="text-dark-emphasis mb-3">Deep Local and Regional Insight</h4>
                        <p class="text-muted">
                            Based in Kampala with strong East African roots, RoyalWay brings nuanced understanding of
                            local dynamics, cultural contexts, and audience behaviors—essential for effective behavioral
                            change, community engagements and nationwide activations covering 137 districts in Uganda
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="purpose-card">
                        <div class="purpose-icon mb-3">
                            <i class="fa-solid fa-handshake fa-2x text-burgundy"></i>
                        </div>
                        <h4 class="text-dark-emphasis mb-3">Passion-Driven, Client-Centric Collaboration</h4>
                        <p class="text-muted">
                            They emphasize building meaningful partnerships, aligning communication strategies tightly to
                            client goals, and infusing projects with passion, insight, knowledge, experience, curiosity, and
                            vision—transforming ambitions into thriving outcomes and fostering long-term trust
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
{{--    @if($teamMembers->count() > 0)--}}
{{--        <section class="team-section py-5">--}}
{{--            <div class="container-fluid">--}}
{{--                <div class="container mb-5">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12">--}}
{{--                            <span class="badge bg-light text-burgundy mb-3">Our Team</span>--}}
{{--                            <p class="section-intro fw-semibold text-white">Meet the engine of our organization — a diverse group of experts, innovators, and problem-solvers.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="team-scroll-wrapper">--}}
{{--                    <div class="team-scroll-container" id="teamScroll">--}}
{{--                        @foreach($teamMembers as $member)--}}
{{--                            <div class="team-card">--}}
{{--                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="team-image">--}}
{{--                                <div class="team-info">--}}
{{--                                    <h5 class="text-white mb-1">{{ $member->name }}</h5>--}}
{{--                                    <p class="text-white-50 mb-0">{{ $member->position }}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}

{{--                        <!-- Duplicate for seamless scroll only if more than 3 members -->--}}
{{--                        @if($teamMembers->count() > 3)--}}
{{--                            @foreach($teamMembers as $member)--}}
{{--                                <div class="team-card">--}}
{{--                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="team-image">--}}
{{--                                    <div class="team-info">--}}
{{--                                        <h5 class="text-white mb-1">{{ $member->name }}</h5>--}}
{{--                                        <p class="text-white-50 mb-0">{{ $member->position }}</p>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}
{{--    @endif--}}
@endsection
