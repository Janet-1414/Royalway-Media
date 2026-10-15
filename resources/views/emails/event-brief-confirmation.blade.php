@extends('emails.layout')

@section('title', 'Event Brief Received')

@section('content')
    <h1>Event Brief Received!</h1>


    <p>Dear {{ $brief->key_contact }},</p>

    <p>Thank you for submitting your event management brief to RoyalWay Media Ltd. We have received your request and our events team is reviewing the details.</p>

    <div class="info-box">
        <p><strong>Event Details Summary:</strong></p>
        <p style="margin-top: 10px;">
            <strong>Organization:</strong> {{ $brief->organization_name }}<br>
            <strong>Event Nature:</strong> {{ $brief->event_nature }}<br>
            <strong>Venue:</strong> {{ $brief->venue }}<br>
            <strong>Setup:</strong> {{ ucfirst($brief->setup) }}<br>
            <strong>Expected Guests:</strong> {{ $brief->guest_count_label }}
        </p>
    </div>

    <p>Our team will prepare a detailed quote based on your requirements and contact you within 24-48 hours to discuss your event in detail.</p>

    <h3 style="color: #38558A; margin-top: 25px;">What Happens Next?</h3>
    <ol style="line-height: 1.8;">
        <li>Our events team reviews your brief</li>
        <li>We prepare a customized quote for your event</li>
        <li>We contact you to discuss details and finalize arrangements</li>
        <li>We bring your event vision to life!</li>
    </ol>

    <a href="{{ url('/projects') }}" class="button">View Our Past Events</a>

    <div class="divider"></div>

    <p><strong>Need to Discuss Urgently?</strong></p>
    <p>
        Call us: <a href="tel:+256772464686" style="color: #018DB1;">+256 772 464 686</a><br>
        Email: <a href="mailto:sales@royalwaymedia.com" style="color: #018DB1;">sales@royalwaymedia.com</a>
    </p>

    <p style="margin-top: 30px;">
        We look forward to creating an amazing event with you!<br>
        <strong style="color: #38558A;">The RoyalWay Media Events Team</strong>
    </p>


@endsection
