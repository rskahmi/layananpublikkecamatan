<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout._partials.guest.header')
</head>

<body class="@yield('bodyClass')">
    <x-layout.loading />
    <div class="page-flex">

        <!-- ! Sidebar -->
        <div class="main-wrapper">

            <!-- ! Main nav -->
            @include('layout._partials.guest.navbar')

            <!-- ! Main -->
            <main class="main guests chart-page" id="skip-target">
                @yield('content')
            </main>

            <!-- ! Footer -->
            @include('layout._partials.guest.footer')
        </div>
    </div>

    @include('layout._partials.guest.scripts')
</body>

</html>
