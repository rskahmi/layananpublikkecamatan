    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- OG --}}
    <meta name="og:site_name" content="{{ config('app.url') }}">
    <meta name="og:title" content="{{ config('app.name') }} | @yield('title')">
    <meta name="og:image" content="{{ asset('assets/img/logo/logotimah.svg') }}">
    <meta name="og:description" content="{{ config('app.name') }} | @yield('title')">

    {{-- Browser --}}
    <meta name="title" content="{{ config('app.name') }} | @yield('title')">
    <meta name="description" content="{{ config('app.name') }} | @yield('title')">
    <meta name="image" content="{{ asset('assets/img/logo/logotimah.svg') }}">
    <meta name="keywords" content="laundry">
    <meta name="author" content="{{ config('app.url') }}">

<title>{{ config('app.name') }} | @yield('title')</title>

<link rel="shortcut icon" href="{{ asset('assets/img/logo/logokck.svg') }}" type="image/x-icon">
