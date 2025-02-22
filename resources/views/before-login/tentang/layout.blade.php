@extends('layout.guest')

@section('bodyClass', 'body-tentang')
@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Tentang Kami</h1>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 col-xxl-4">
                <ul class="nav-tentang">
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang') ? 'active' : '' }}" href="{{ route('tentang') }}">
                            Sekilas Pertamina RU II Dumai
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.sejarah') ? 'active' : '' }}" href="{{ route('tentang.sejarah') }}">
                            Sejarah Pertamina RU II Dumai
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.visi-misi') ? 'active' : '' }}" href="{{ route('tentang.visi-misi') }}">
                            Visi & Misi
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.produk') ? 'active' : '' }}" href="{{ route('tentang.produk') }}">
                            Produk Yang Dihasilkan
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.program') ? 'active' : '' }}" href="{{ route('tentang.program') }}">
                            Program Unggulan
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.struktur') ? 'active' : '' }}" href="{{ route('tentang.struktur') }}">
                            Struktur Fungsi Comm, Rel & CSR RU II Dumai
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-8 col-xxl-8 mt-3 mt-lg-0">
                <div class="tentang-content">
                    @yield('tentang-content')
                </div>
            </div>
        </div>
    </div>
@endsection
