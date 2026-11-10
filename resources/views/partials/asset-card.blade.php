{{--
    Communication asset card with Preview and Download buttons.
    Usage: @include('partials.asset-card', ['asset' => $asset, 'compact' => false])
    Needs partials.asset-preview-modal on the same page for the Preview button.
--}}
@php
    $compact = $compact ?? false;
    $fileUrl = $asset->file_url;
    $thumb = $asset->show_cover ? $asset->image_url : null;
    $pageUrl = route('resources.show', $asset->slug);
@endphp

<article class="ca-card{{ $compact ? ' ca-card--compact' : '' }}">
    <a href="{{ $pageUrl }}" class="ca-thumb ca-thumb--{{ $asset->file_group }}" tabindex="-1" aria-hidden="true">
        @if($thumb)
            <img src="{{ $thumb }}" alt="" loading="lazy">
        @else
            <span class="ca-thumb-icon"><i class="fas {{ $asset->file_icon }}"></i></span>
        @endif
        @if($asset->file_badge)
            <span class="ca-badge">{{ $asset->file_badge }}</span>
        @endif
    </a>
    <div class="ca-body">
        <h3 class="ca-title"><a href="{{ $pageUrl }}">{{ $asset->title }}</a></h3>
        @if(!$compact && $asset->excerpt)
            <p class="ca-text">{{ Str::limit($asset->excerpt, 110) }}</p>
        @endif
        @if($asset->published_at)
            <p class="ca-date"><time datetime="{{ $asset->published_at->toDateString() }}">{{ $asset->formatted_published_date }}</time></p>
        @endif
        <div class="ca-actions">
            @if($fileUrl && $asset->preview_kind !== 'none')
                <button type="button" class="ca-btn ca-btn--ghost"
                        data-preview-open
                        data-preview-slug="{{ $asset->slug }}"
                        data-preview-title="{{ $asset->title }}"
                        data-preview-kind="{{ $asset->preview_kind }}"
                        data-preview-src="{{ $fileUrl }}">
                    <i class="fas fa-eye" aria-hidden="true"></i> Preview<span class="visually-hidden"> {{ $asset->title }}</span>
                </button>
            @endif
            @if($fileUrl)
                <a href="{{ $fileUrl }}" class="ca-btn" download>
                    <i class="fas fa-download" aria-hidden="true"></i> Download<span class="visually-hidden"> {{ $asset->title }}</span>
                </a>
            @else
                <a href="{{ $pageUrl }}" class="ca-btn">View <span class="visually-hidden">{{ $asset->title }}</span></a>
            @endif
        </div>
    </div>
</article>
