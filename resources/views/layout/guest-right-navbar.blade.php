<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout._partials.guest.header')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>

<body class="auth">
    <x-layout.loading />

    <div class="auth-container">
        <div class="row contain">
            <div class="left col-0 col-lg-5 col-xl-5 col-xxl-6 d-flex align-items-center justify-content-center">
                <img
                    src="{{asset('assets/img/logo/logokck.svg') }}" alt="Logo {{ config('app.name') }}"
                    width="700" height="406" class="animate__animated animate__fadeInLeft">
            </div>
            <div class="right col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-6 bg-gray">
                <div class="row">
                    <div class="body">
                        <div class="col-12 top">
                            @include('layout._partials.guest.navbar')
                            <main id="skip-target">
                                @yield('content')
                            </main>
                        </div>
                        <div class="col-12">
                            @include('layout._partials.guest.footer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('layout._partials.guest.scripts')
</body>

</html>
