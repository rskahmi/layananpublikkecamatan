<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
    <div


        @if (!Route::is('auth') && !Route::is('registrasi'))
        class="container-fluid me-3 me-md-5 ms-3 ms-md-5"
        @endif
    >
        @if (!Route::is('auth') && !Route::is('registrasi'))
        <a class="navbar-brand" href="#">
            <img src="{{asset('assets/img/logo/logotimah.svg') }}" alt="Logo {{ config('app.name') }}"
                width="200" height="69">
        </a>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 {{ (!isRouteActive('auth') ? 'ms-auto' : 'p-3') }}">
                {{-- <li class="nav-item ms-4">
                    <a class="nav-link  {{ isRouteActive('beranda') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('beranda') }}">Home</a>
                </li> --}}


                {{-- <li class="nav-item ms-4">
                    <a class="nav-link {{ isRouteActive('tentang') ?     'active' : (isRouteActive('tentang.struktur') ? 'active' : (isRouteActive('tentang.sejarah') ? 'active' : (isRouteActive('tentang.visi-misi') ? 'active' : (isRouteActive('tentang.produk') ? 'active' : (isRouteActive('tentang.program') ? 'active' : ''))))) }}" aria-current="page"
                        href="{{ route('tentang') }}">Tentang Kami</a>
                </li> --}}

                <li class="nav-item ms-4">
                    <a class="nav-link {{ isRouteActive('auth') ? 'active' : '' }}" aria-current="page" href="{{ route('auth') }}">Login</a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link {{ isRouteActive('registrasi') ? 'active' : '' }}" aria-current="page" href="{{ route('registrasi') }}">Registrasi</a>
                </li>
                <li class="nav-item ms-4">
                    <a class="nav-link {{ isRouteActive('kontak') ? 'active' : '' }}" aria-current="page"
                        href="{{ route('kontak') }}">Hubungi Kami</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
