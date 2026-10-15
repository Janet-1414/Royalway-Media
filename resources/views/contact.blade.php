@extends('layouts.app')

@section('title', 'Contact Us - RoyalWay Media')
@section('seo_description', 'Get in touch with RoyalWay Media. Contact us for your marketing, PR, events, and communications needs in Uganda.')

@section('content')
    @php
        $email = setting('contact_email', 'sales@royalwaymedia.com');
        $phones = setting_phones();
        $address = setting('address', 'Plot 23, Cooper Road, Kisementi-Kololo, Kampala, Uganda');
        $mapsEmbed = setting('google_maps_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.748448252334!2d32.5882796!3d0.3390889!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbba674754169%3A0x8a9ed4e73dc4c5b3!2sRoyalWay%20Media!5e0!3m2!1sen!2sug!4v1761603434898!5m2!1sen!2sug');

        // Get primary/mobile phones
        $officePhone = null;
        $mobilePhones = [];
        foreach ($phones as $phone) {
            if (isset($phone['label']) && stripos($phone['label'], 'office') !== false) {
                $officePhone = $phone['number'] ?? '';
            } else {
                $mobilePhones[] = $phone['number'] ?? '';
            }
        }
        if (!$officePhone && !empty($phones)) {
            $officePhone = $phones[0]['number'] ?? '+256 312 284 552';
        }
    @endphp

    <!-- Page Header -->

    <section class="page-header-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="text-white">Contact Us</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->

    <section class="contact-form-section py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif


            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                    <span class="badge bg-light text-burgundy mb-3">Get in Touch</span>
                    <p class="fs-4 fw-700 text-dark mb-4">Feel free to send us a message</p>
                    <iframe src="{{ $mapsEmbed }}" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="RoyalWay Media office location"></iframe>
                </div>
                <div class="col-lg-6 col-12">
                    <form class="contact-form" id="contactForm" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label text-muted">Input Your Name</label>
                            <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" placeholder="Your name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted">Input Your E-mail</label>
                            <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" placeholder="Your email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted">Description Your Message</label>
                            <textarea name="message" class="form-control form-control-lg @error('message') is-invalid @enderror" rows="5" placeholder="Tell us about your project" required>{{ old('message') }}</textarea>
                            @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-burgundy btn-lg w-100">Send Message</button>
                    </form>
                </div>
            </div>
        </div>


    </section>

    <!-- Contact Info Section -->

    <section class="stats-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-12 mb-5 mb-lg-0">
                    <span class="badge bg-light text-white mb-3">Contact</span>
                    <p class="fs-4 fw-700 text-white mb-4">It's time to talk about your project</p>
                </div>
                <div class="col-lg-5 col-12">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="contact-info-item d-flex align-items-start">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <p class="text-white mb-2 fw-semibold">Email: <a href="mailto:{{ $email }}" class="text-white">{{ $email }}</a></p>
                                </div>
                            </div>
                        </div>
                        @if($officePhone)
                        <div class="col-12">
                            <div class="contact-info-item d-flex align-items-start">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-phone text-white"></i>
                                </div>
                                <div>
                                    <p class="text-white mb-2 fw-semibold">Telephone: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $officePhone) }}" class="text-white">{{ $officePhone }}</a></p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(!empty($mobilePhones))
                        <div class="col-12">
                            <div class="contact-info-item d-flex align-items-start">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-mobile-alt text-white"></i>
                                </div>
                                <div>
                                    <p class="text-white mb-2 fw-semibold">Mobile:
                                        @foreach($mobilePhones as $i => $mobile)
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $mobile) }}" class="text-white">{{ $mobile }}</a>@if($i < count($mobilePhones) - 1), @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="contact-info-item d-flex align-items-start">
                                <div class="contact-icon me-3">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <p class="text-white mb-2 fw-semibold">Location: {{ $address }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->

    <section class="faq-section py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <span class="badge bg-light text-burgundy mb-3">FREQUENTLY ASKED QUESTIONS</span>
                    <p class="section-intro fw-semibold text-dark">Quick and helpful answers to common queries</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 col-12">
                    <div class="faq-item">
                        <button class="faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            <span>What services does RoyalWay Media offer?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="collapse" id="faq1">
                            <div class="faq-answer">
                                <p>We provide integrated marketing and communications services including PR, Media Management, Advertising, Branding, Experiential Marketing, and Corporate Events Planning.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="faq-item">
                        <button class="faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            <span>How do I subscribe to your newsletter?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="collapse" id="faq2">
                            <div class="faq-answer">
                                <p>Stay informed by subscribing to our newsletter. Enter your email address in the subscription box on our homepage footer.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="faq-item">
                        <button class="faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            <span>How can I get in touch with your customer support?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="collapse" id="faq3">
                            <div class="faq-answer">
                                <p>You can reach us via phone at {{ $phones[0]['number'] ?? '+256 772 464 686' }}, email at {{ $email }}, or by filling out the contact form on this page.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="faq-item">
                        <button class="faq-question" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                            <span>What will be delivered? And When?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="collapse" id="faq4">
                            <div class="faq-answer">
                                <p>Our team delivers high-quality products and services tailored to your needs. Timeline varies by project scope, which we'll discuss during consultation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
