<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout._partials.guest.header')
</head>

<body class="error">
    <x-layout.loading />
    <div class="page-flex">
        <div class="main-wrapper">
            <main class="main guests chart-page" id="skip-target">
                @yield('content')
            </main>
            @include('layout._partials.guest.footer')
        </div>
    </div>
    @include('layout._partials.guest.scripts')
</body>
</html>
