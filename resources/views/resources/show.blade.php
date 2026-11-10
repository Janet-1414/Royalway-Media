@extends('layouts.app')

@php
    $isArticle = $resource->type === 'blog';
    $listUrl = $isArticle ? route('insights.index') : route('assets.index');
    $listLabel = $isArticle ? 'News & Insights' : 'Communication Assets';
    $shareUrl = route('resources.show', $resource->slug);
    $description = $resource->meta_description
        ?: ($resource->excerpt ?: Str::limit(trim(strip_tags(html_entity_decode((string) $resource->content))), 160));
    $coverUrl = $resource->show_cover ? $resource->image_url : null;
    $hasContent = filled(trim(strip_tags((string) $resource->content)));
    $enc = fn ($v) => rawurlencode($v);
@endphp

@section('title', ($resource->meta_title ?: $resource->title) . ' - RoyalWay Media')
@section('seo_description', $description)
@section('og_type', 'article')
@if($resource->image_url)
    @section('seo_image', $resource->image_url)
@endif

@push('meta')
    @if($resource->published_at)
        <meta property="article:published_time" content="{{ $resource->published_at->toDateString() }}">
    @endif
    @if($resource->topic)
        <meta property="article:section" content="{{ $resource->topic }}">
    @endif
    @if($hasContent)
        <meta name="twitter:label1" content="Reading time">
        <meta name="twitter:data1" content="{{ $resource->reading_time }} min read">
    @endif
@endpush

@section('content')

    <article class="na-article">
        <header class="na-article-head">
            <div class="container">
                <div class="na-read">
                    <nav class="na-crumbs" aria-label="Breadcrumb">
                        <a href="{{ $listUrl }}">{{ $listLabel }}</a>
                    </nav>
                    <span class="na-topic">{{ $resource->topic ?: ($isArticle ? 'Insight' : 'Communication asset') }}</span>
                    <h1 class="na-article-title">{{ $resource->title }}</h1>
                    @if($resource->excerpt)
                        <p class="na-standfirst">{{ $resource->excerpt }}</p>
                    @endif
                    <p class="na-meta">
                        @if($resource->author)
                            <span>By {{ $resource->author }}</span>
                        @endif
                        @if($resource->published_at)
                            <time datetime="{{ $resource->published_at->toDateString() }}">{{ $resource->formatted_published_date }}</time>
                        @endif
                        @if($hasContent)
                            <span>{{ $resource->reading_time }} min read</span>
                        @endif
                        @if(!$isArticle && $resource->file_badge)
                            <span>{{ $resource->file_badge }} file</span>
                        @endif
                    </p>
                </div>
            </div>
        </header>

        @if($coverUrl)
            <div class="container">
                <figure class="na-cover">
                    <img src="{{ $coverUrl }}" alt="{{ $resource->title }}">
                </figure>
            </div>
        @endif

        <div class="container">
            <div class="na-read">
                @if($hasContent)
                    <div class="na-body">
                        {!! $resource->content !!}
                    </div>
                @endif

                @if($resource->file_url)
                    <div class="na-file">
                        <span class="na-file-icon" aria-hidden="true"><i class="fas {{ $resource->file_icon }}"></i></span>
                        <div class="na-file-text">
                            <p class="na-file-title">{{ $isArticle ? 'Attached file' : 'Get this asset' }}</p>
                            <p class="na-file-sub">{{ $resource->file_badge }} file</p>
                        </div>
                        <div class="na-file-actions">
                            @if(!$isArticle && $resource->preview_kind !== 'none')
                                <a href="{{ route('assets.index', ['preview' => $resource->slug]) }}" class="btn btn-outline-burgundy btn-sm mb-0">Preview</a>
                            @endif
                            <a href="{{ $resource->file_url }}" class="btn btn-burgundy btn-sm mb-0" download>
                                <i class="fas fa-download me-1" aria-hidden="true"></i> Download
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Share -->
                <div class="na-share" role="group" aria-label="Share this {{ $isArticle ? 'article' : 'asset' }}">
                    <span class="na-share-label">Share</span>
                    <button type="button" class="na-share-btn na-share-copy" data-copy-link="{{ $shareUrl }}">
                        <i class="fas fa-link" aria-hidden="true"></i><span>Copy link</span>
                    </button>
                    <a class="na-share-btn" href="https://www.linkedin.com/sharing/share-offsite/?url={{ $enc($shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn">
                        <i class="fa-brands fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                    <a class="na-share-btn" href="https://twitter.com/intent/tweet?url={{ $enc($shareUrl) }}&text={{ $enc($resource->title) }}" target="_blank" rel="noopener" aria-label="Share on X">
                        <i class="fa-brands fa-x-twitter" aria-hidden="true"></i>
                    </a>
                    <a class="na-share-btn" href="https://www.facebook.com/sharer/sharer.php?u={{ $enc($shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on Facebook">
                        <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                    </a>
                    <a class="na-share-btn" href="https://wa.me/?text={{ $enc($resource->title . ' ' . $shareUrl) }}" target="_blank" rel="noopener" aria-label="Share on WhatsApp">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
                    </a>
                    <a class="na-share-btn" href="mailto:?subject={{ $enc($resource->title) }}&body={{ $enc($description . "\n\n" . $shareUrl) }}" aria-label="Share by email">
                        <i class="fas fa-envelope" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="na-share-btn na-share-native" data-share-title="{{ $resource->title }}" data-share-url="{{ $shareUrl }}" hidden>
                        <i class="fas fa-share-nodes" aria-hidden="true"></i><span>Share</span>
                    </button>
                    <span class="na-copied" role="status" aria-live="polite"></span>
                </div>

                <!-- Reactions -->
                @if($reactionsEnabled)
                    <section class="na-react" aria-labelledby="na-react-title"
                             data-react-url="{{ route('resources.react', $resource->slug) }}"
                             data-token="{{ csrf_token() }}">
                        <h2 class="na-section-label" id="na-react-title">How did you find this?</h2>
                        <div class="na-react-btns">
                            @foreach(\App\Models\ResourceReaction::TYPES as $type => $meta)
                                <button type="button" class="na-react-btn{{ $myReaction === $type ? ' is-active' : '' }}"
                                        data-type="{{ $type }}" aria-pressed="{{ $myReaction === $type ? 'true' : 'false' }}">
                                    <i class="fas {{ $meta['icon'] }}" aria-hidden="true"></i>
                                    <span>{{ $meta['label'] }}</span>
                                    <span class="na-react-count" data-count-for="{{ $type }}">{{ $reactionCounts[$type] ?? 0 }}</span>
                                </button>
                            @endforeach
                        </div>
                        <p class="na-react-msg" role="status" aria-live="polite"></p>
                    </section>
                @endif

                <!-- Comments -->
                @if($commentsEnabled)
                    <section class="na-comments" id="comments" aria-labelledby="na-comments-title">
                        <h2 class="na-section-label" id="na-comments-title">
                            Comments @if($comments->count())<span class="na-count">{{ $comments->count() }}</span>@endif
                        </h2>

                        @forelse($comments as $comment)
                            <div class="na-comment">
                                <span class="na-avatar" aria-hidden="true">{{ Str::upper(Str::substr($comment->name, 0, 1)) }}</span>
                                <div>
                                    <p class="na-comment-meta">
                                        <strong>{{ $comment->name }}</strong>
                                        <time datetime="{{ $comment->created_at->toDateString() }}">{{ $comment->created_at->format('F d, Y') }}</time>
                                    </p>
                                    <div class="na-comment-body">{!! nl2br(e($comment->body)) !!}</div>
                                </div>
                            </div>
                        @empty
                            <p class="na-muted">No comments yet. Be the first to share your thoughts.</p>
                        @endforelse

                        @if(session('comment_status'))
                            <div class="alert alert-success text-white mt-4" role="status">{{ session('comment_status') }}</div>
                        @endif

                        <form class="na-comment-form" id="commentForm" action="{{ route('resources.comments.store', $resource->slug) }}" method="POST">
                            @csrf
                            {{-- Spam protection: honeypot (hidden from real users) --}}
                            <div style="position: absolute; left: -9999px;" aria-hidden="true">
                                <label for="website">Leave this empty</label>
                                <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                            </div>
                            <input type="hidden" name="form_started_at" value="{{ $formTimestamp }}">
                            <input type="hidden" name="g-recaptcha-response" id="commentRecaptchaToken">

                            <p class="na-form-title">Leave a comment</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="comment-name" class="form-label">Name</label>
                                    <input type="text" id="comment-name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" maxlength="100" required autocomplete="name">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="comment-email" class="form-label">Email</label>
                                    <input type="email" id="comment-email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="255" required autocomplete="email" aria-describedby="comment-note">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="comment-body" class="form-label">Comment</label>
                                    <textarea id="comment-body" name="body" rows="5" class="form-control @error('body') is-invalid @enderror" maxlength="3000" required>{{ old('body') }}</textarea>
                                    @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-burgundy mt-3 mb-0">Post comment</button>
                            <p class="na-note" id="comment-note">Your email will not be published. Comments are reviewed before they appear.</p>
                            @if(config('services.recaptcha.site_key'))
                                <p class="recaptcha-notice">
                                    This site is protected by reCAPTCHA and the Google
                                    <a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and
                                    <a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.
                                </p>
                            @endif
                        </form>
                    </section>
                @endif
            </div>
        </div>
    </article>

    <!-- Related -->
    @if($relatedResources->count())
        <section class="na-related">
            <div class="container">
                <span class="in-eyebrow">Keep reading</span>
                <h2 class="section-heading">{{ $isArticle ? 'Related articles' : 'More communication assets' }}</h2>
                <div class="row g-4 mt-1">
                    @foreach($relatedResources as $related)
                        @php
                            $relUrl = route('resources.show', $related->slug);
                        @endphp
                        <div class="col-lg-4 col-md-6 col-12">
                            <article class="in-card na-card">
                                <a href="{{ $relUrl }}" class="in-card-img" tabindex="-1" aria-hidden="true">
                                    @if($related->show_cover && $related->image_url)
                                        <img src="{{ $related->image_url }}" alt="" loading="lazy">
                                    @else
                                        <span class="in-card-ph"><i class="fas {{ $isArticle ? 'fa-newspaper' : $related->file_icon }}"></i></span>
                                    @endif
                                </a>
                                <div class="in-card-body">
                                    @if($related->topic)
                                        <span class="na-topic">{{ $related->topic }}</span>
                                    @endif
                                    <h3 class="in-card-title"><a href="{{ $relUrl }}">{{ $related->title }}</a></h3>
                                    <p class="na-meta mt-auto">
                                        @if($related->published_at)
                                            <time datetime="{{ $related->published_at->toDateString() }}">{{ $related->formatted_published_date }}</time>
                                        @endif
                                        @if($isArticle && $related->content)
                                            <span>{{ $related->reading_time }} min read</span>
                                        @endif
                                    </p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('scripts')
<script>
(function () {
    // Readership: one small beacon per page view, counted once per visitor per day
    var viewUrl = @json(route('resources.view', $resource->slug));
    try {
        if (navigator.sendBeacon) {
            navigator.sendBeacon(viewUrl);
        } else {
            fetch(viewUrl, { method: 'POST', keepalive: true, credentials: 'same-origin' });
        }
    } catch (e) {}

    // Copy link with a fallback for older browsers
    var copyBtn = document.querySelector('.na-share-copy');
    var copied = document.querySelector('.na-copied');
    function showCopied(text) {
        if (!copied) return;
        copied.textContent = text;
        copied.classList.add('is-visible');
        clearTimeout(showCopied.t);
        showCopied.t = setTimeout(function () { copied.classList.remove('is-visible'); copied.textContent = ''; }, 2500);
    }
    function fallbackCopy(text) {
        var field = document.createElement('textarea');
        field.value = text;
        field.setAttribute('readonly', '');
        field.style.position = 'fixed';
        field.style.opacity = '0';
        document.body.appendChild(field);
        field.select();
        var ok = false;
        try { ok = document.execCommand('copy'); } catch (e) {}
        document.body.removeChild(field);
        return ok;
    }
    if (copyBtn) {
        copyBtn.addEventListener('click', function () {
            var link = copyBtn.getAttribute('data-copy-link');
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(link).then(function () { showCopied('Copied'); }, function () {
                    showCopied(fallbackCopy(link) ? 'Copied' : 'Press Ctrl+C to copy: ' + link);
                });
            } else {
                showCopied(fallbackCopy(link) ? 'Copied' : 'Press Ctrl+C to copy: ' + link);
            }
        });
    }

    // Native share sheet where supported
    var nativeBtn = document.querySelector('.na-share-native');
    if (nativeBtn && navigator.share) {
        nativeBtn.hidden = false;
        nativeBtn.addEventListener('click', function () {
            navigator.share({
                title: nativeBtn.getAttribute('data-share-title'),
                url: nativeBtn.getAttribute('data-share-url')
            }).catch(function () {});
        });
    }

    // Reactions
    var react = document.querySelector('.na-react');
    if (react) {
        var msg = react.querySelector('.na-react-msg');
        var buttons = react.querySelectorAll('.na-react-btn');
        var busy = false;
        function render(data) {
            Object.keys(data.counts || {}).forEach(function (type) {
                var el = react.querySelector('[data-count-for="' + type + '"]');
                if (el) el.textContent = data.counts[type];
            });
            buttons.forEach(function (btn) {
                var on = btn.getAttribute('data-type') === data.current;
                btn.classList.toggle('is-active', on);
                btn.setAttribute('aria-pressed', on ? 'true' : 'false');
            });
        }
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                if (busy) return;
                busy = true;
                msg.textContent = '';
                var body = new FormData();
                body.append('type', btn.getAttribute('data-type'));
                fetch(react.getAttribute('data-react-url'), {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: { 'X-CSRF-TOKEN': react.getAttribute('data-token'), 'Accept': 'application/json' },
                    body: body
                }).then(function (res) {
                    return res.json().then(function (data) { return { ok: res.ok, data: data }; });
                }).then(function (r) {
                    if (r.data && r.data.counts) render(r.data);
                    msg.textContent = r.ok ? (r.data.current ? 'Thanks for your reaction.' : 'Reaction removed.') : (r.data.message || 'Please try again in a moment.');
                }).catch(function () {
                    msg.textContent = 'Please try again in a moment.';
                }).then(function () { busy = false; });
            });
        });
    }
})();
</script>

@if($commentsEnabled && config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('commentForm');
    if (!form) return;
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', { action: 'comment' }).then(function (token) {
                document.getElementById('commentRecaptchaToken').value = token;
                form.submit();
            });
        });
    });
});
</script>
@endif
@endpush
