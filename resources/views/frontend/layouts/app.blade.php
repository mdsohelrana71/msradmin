<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon.png') }}">
    @php
        $designManager = app(\App\Services\Frontend\DesignManager::class);
    @endphp
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/global.css') }}">
    <link rel="stylesheet" href="{{ $designManager->getTemplateCss('common') }}">
    <link rel="stylesheet" href="{{ $designManager->getSectionCss('header') }}">
    <link rel="stylesheet" href="{{ $designManager->getSectionCss('footer') }}">
    @stack('styles')
</head>
<body>
    {!! $designManager->render('header') !!}
    @yield('content')
    @include('frontend.partials.quick-view')
    {!! $designManager->render('footer') !!}
    <script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/slick.min.js') }}"></script>
    <script src="{{ asset('frontend/js/global.js') }}"></script>
    @stack('scripts')
</body>
</html>