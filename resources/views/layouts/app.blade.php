<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<meta name="csrf-token" content="{{ @csrf_token() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- css in build folder --}}
        @php
            $cssFiles = glob(public_path('build/assets/*.css'));
        @endphp

        @foreach ($cssFiles as $file)
            <link rel="stylesheet" href="{{ asset('build/assets/' . basename($file)) }}">
        @endforeach

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    @endif
</head>

<body>
    {{-- page loader --}}
    @include('components.loader')

    {{-- menu area --}}
    @include('components.main-nav-menu')
    {{-- end menu area --}}
    <div id="main-container" class="container-fluid">
        {{-- content --}}
        @yield('content')
        {{-- end content --}}
    </div>

    <x-theme-toggle/>
    <x-confirm-model/>
    <x-feedback-model/>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        {{-- Vite JS --}}
    @else
        {{-- js in build folder --}}
        @php
            $jsFiles = glob(public_path('build/assets/*.js'));
        @endphp

        @foreach ($jsFiles as $file)
            <script src="{{ asset('build/assets/' . basename($file)) }}"></script>
        @endforeach

        <!-- Bootstrap JS (with Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @endif
</body>

</html>
