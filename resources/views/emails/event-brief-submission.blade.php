@extends('emails.layout')

@section('title', 'New Event Brief Submission')

@section('content')
    <h1>New Event Brief Submission</h1>


    <p>A new event management brief has been submitted through the website.</p>

    <div class="info-box">
        <p><strong>Organization:</strong><br>{{ $brief->organization_name }}</p>
        <p><strong>Contact Person:</strong><br>{{ $brief->key_contact }}</p>
        <p><strong>Venue:</strong><br>{{ $brief->venue }}</p>
        <p><strong>Event Nature:</strong><br>{{ $brief->event_nature }}</p>
        <p><strong>Setup:</strong><br>{{ ucfirst($brief->setup) }}</p>
        <p><strong>Guest Count:</strong><br>{{ $brief->guest_count_label }}</p>
        <p><strong>Submitted:</strong><br>{{ $brief->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>

    <h3 style="color: #38558A; margin-top: 30px;">Selected Services</h3>

    @if($brief->venue_setup)
        <div style="margin: 15px 0;">
            <strong style="color: #018DB1;">Venue Setup:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                @foreach($brief->venue_setup as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($brief->sound_visuals)
        <div style="margin: 15px 0;">
            <strong style="color: #018DB1;">Sound & Visuals:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                @foreach($brief->sound_visuals as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($brief->decoration)
        <div style="margin: 15px 0;">
            <strong style="color: #018DB1;">Decoration:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                @foreach($brief->decoration as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($brief->hospitality)
        <div style="margin: 15px 0;">
            <strong style="color: #018DB1;">Hospitality & Entertainment:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                @foreach($brief->hospitality as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($brief->branding)
        <div style="margin: 15px 0;">
            <strong style="color: #018DB1;">Branding & Communication:</strong>
            <ul style="margin: 5px 0; padding-left: 20px;">
                @foreach($brief->branding as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($brief->additional_info)
        <div style="margin: 25px 0;">
            <strong style="color: #38558A;">Additional Information:</strong>
            <div style="background-color: #f8f9fa; padding: 15px; margin-top: 10px; border-radius: 5px;">
                {!! nl2br(e($brief->additional_info)) !!}
            </div>
        </div>
    @endif

    <a href="{{ url('/admin/event-briefs/' . $brief->id) }}" class="button">View in Admin Panel</a>

    <div class="divider"></div>

    <p style="font-size: 13px; color: #888888;">
        <strong>IP Address:</strong> {{ $brief->ip_address }}<br>
        <strong>User Agent:</strong> {{ $brief->user_agent }}
    </p>


@endsection
