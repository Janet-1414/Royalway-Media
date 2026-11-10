@extends('emails.layout')

@section('title', 'New Comment')

@section('content')
    <h1>New comment waiting for approval</h1>

    <p>A reader left a comment on <strong>{{ $comment->resource->title }}</strong>. It will not appear on the website until it is approved.</p>

    <div class="info-box">
        <p><strong>Name:</strong><br>{{ $comment->name }}</p>
        <p><strong>Email:</strong><br>{{ $comment->email }}</p>
        <p><strong>Submitted:</strong><br>{{ $comment->created_at->format('F d, Y \a\t h:i A') }}</p>
    </div>

    <div style="margin: 25px 0;">
        <strong style="color: #38558A;">Comment:</strong>
        <div style="background-color: #f8f9fa; padding: 15px; margin-top: 10px; border-radius: 5px;">
            {!! nl2br(e($comment->body)) !!}
        </div>
    </div>

    <a href="{{ url('/admin/resource-comments') }}" class="button">Review in Admin Panel</a>
@endsection
