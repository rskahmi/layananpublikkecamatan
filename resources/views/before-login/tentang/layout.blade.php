@extends('layout.guest')
@section('bodyClass', 'body-tentang')
@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Tentang
                 Kantor Camat Kundur Barat</h1>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-4 col-xxl-4">
                <ul class="nav-tentang">
                    <li>
                        <a
                            href="{{ route('tentang.sejarah') }}"
                            class="btn w-100 {{ isRouteActive('tentang.sejarah') || isRouteActive('tentang') ? 'active' : '' }}">
                            Sejarah
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.visi-misi') ? 'active' : '' }}" href="{{ route('tentang.visi-misi') }}">
                            Visi & Misi
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.program') ? 'active' : '' }}" href="{{ route('tentang.program') }}">
                            Daftar Kelurahan/Desa
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.struktur') ? 'active' : '' }}" href="{{ route('tentang.struktur') }}">
                            Struktur Organisasi
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.alursurat') ? 'active' : '' }} " href="{{ route('tentang.alursurat') }}">
                            Alur Pengajuan Surat
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.alurpengaduan') ? 'active' : '' }} " href="{{ route('tentang.alurpengaduan') }}">
                            Alur Pengaduan
                        </a>
                    </li>
                    <li>
                        <a class="btn w-100 {{ isRouteActive('tentang.alurakun') ? 'active' : '' }} " href="{{ route('tentang.alurakun') }}">
                            Alur Registrasi Akun dan Login Masyarakat
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
