<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Meta Tags --}}
    @include('partials.seo-meta')

    {{-- Favicon --}}
    @php
        $favicon = setting_file_url('favicon', asset('assets/img/fav.png'));
    @endphp
    <link rel="shortcut icon" type="image/x-icon" href="{{ $favicon }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Files -->
    <link href="{{ asset('assets/css/soft-design-system-pro.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet"/>

    @stack('styles')

    {{-- Structured Data --}}
    @include('partials.structured-data')
</head>
<body>
@include('layouts.partials.navbar')

@yield('content')

@include('layouts.partials.footer')

{{-- WhatsApp Widget (frontend only) --}}
@if(!request()->is('admin*'))
    @include('partials.whatsapp-widget')
@endif

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/soft-design-system-pro.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>

@stack('scripts')
</body>
</html>
