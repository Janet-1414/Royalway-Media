@extends('emails.layout')

@section('title', $replySubject)

@section('content')
    <h1>Hello {{ $recipientName }},</h1>

    <div style="white-space: pre-wrap; line-height: 1.8; color: #333;">{!! nl2br(e($replyMessage)) !!}</div>

    <div class="divider"></div>

    <div class="info-box" style="background-color: #f5f5f5; border-left-color: #999;">
        <p style="margin: 0 0 10px 0; font-size: 13px; color: #666;"><strong>{{ $originalLabel }}:</strong></p>
        <p style="margin: 0; font-size: 14px; color: #555; white-space: pre-wrap;">{{ $originalContent }}</p>
    </div>

    <p style="margin-top: 30px;">
        Best regards,<br>
        <strong>The RoyalWay Media Team</strong>
    </p>
@endsection
