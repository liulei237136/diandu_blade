<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', '点读包社区')" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tail.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body class="tw-bg-white">
    <div id="app" class="{{ route_class() }}-page">
        @include('layouts._header')

        @include('shared._messages')

        @include('layouts._repository_header')

        @yield('content')

        @include('layouts._footer')

    </div>
    <!-- Scripts -->
    @routes
    {{-- <script src="https://unpkg.com/petite-vue" defer init></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
