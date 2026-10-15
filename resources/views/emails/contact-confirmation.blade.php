@extends('emails.layout')

@section('title', 'Thank You for Contacting Us')

@section('content')
    <h1>Thank You for Contacting Us!</h1>


    <p>Dear {{ $submission->name }},</p>

    <p>We have received your message and appreciate you reaching out to RoyalWay Media Ltd. Our team will review your inquiry and get back to you as soon as possible, typically within 24 hours.</p>

    <div class="info-box">
        <p><strong>Your Message:</strong></p>
        <p style="margin-top: 10px;">{!! nl2br(e($submission->message)) !!}</p>
    </div>

    <p>In the meantime, feel free to explore our services and recent projects on our website.</p>

    <a href="{{ url('/') }}" class="button">Visit Our Website</a>

    <div class="divider"></div>

    <p><strong>Need Immediate Assistance?</strong></p>
    <p>
        Call us: <a href="tel:+256772464686" style="color: #018DB1;">+256 772 464 686</a><br>
        Email: <a href="mailto:sales@royalwaymedia.com" style="color: #018DB1;">sales@royalwaymedia.com</a>
    </p>

    <p style="margin-top: 30px;">
        Best regards,<br>
        <strong style="color: #38558A;">The RoyalWay Media Team</strong>
    </p>


@endsection
