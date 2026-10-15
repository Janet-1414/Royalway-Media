@extends('emails.layout')

@section('title', 'New Contact Submission')

@section('content')
    <h1>New Contact Form Submission</h1>


    <p>You have received a new message from the RoyalWay Media website contact form.</p>

    <div class="info-box">
        <p><strong>Name:</strong><br>{{ $submission->name }}</p>
        <p><strong>Email:</strong><br><a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a></p>
        <p><strong>Submitted:</strong><br>{{ $submission->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>

    <div style="margin: 25px 0;">
        <strong style="color: #38558A;">Message:</strong>
        <div style="background-color: #f8f9fa; padding: 15px; margin-top: 10px; border-radius: 5px;">
            {!! nl2br(e($submission->message)) !!}
        </div>
    </div>

    <a href="{{ url('/admin/contact-submissions/' . $submission->id) }}" class="button">View in Admin Panel</a>

    <div class="divider"></div>

    <p style="font-size: 13px; color: #888888;">
        <strong>IP Address:</strong> {{ $submission->ip_address }}<br>
        <strong>User Agent:</strong> {{ $submission->user_agent }}
    </p>


@endsection
