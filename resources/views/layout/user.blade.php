    <!DOCTYPE html>
    <html lang="{{ setlocale(LC_TIME, 'id_ID.UTF-8') }}">

    <head>
        @include('layout._partials.user.header')
    </head>

    <body class="@yield('bodyClass')">
        <x-svg.background />

        {{-- <div class="layer"></div> --}}
        <x-layout.loading />
        <!-- Body -->
        <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
        <div class="page-flex">

            <!-- Sidebar -->
            @include('layout._partials.user.sidebar')
            <div class="main-wrapper">

                <!-- Main nav -->
                @include('layout._partials.user.navbar')

                <!-- Main -->
                <main class="main users chart-page" id="skip-target">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>

                <!-- Footer -->
                @include('layout._partials.user.footer')
            </div>
        </div>

        @include('layout._partials.user.scripts')
    </body>

    </html>
