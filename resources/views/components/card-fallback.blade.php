{{-- Card Fallback Component - Shows when image is missing --}}
@props(['type' => 'resource', 'icon' => 'fa-file-alt'])

<div class="card-fallback-image">
    <i class="fas {{ $icon }}"></i>
    <span class="fallback-chip">{{ ucfirst(str_replace('_', ' ', $type)) }}</span>
</div>
