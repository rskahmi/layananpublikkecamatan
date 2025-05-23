<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="#" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <img src="{{ asset('assets/img/logo/logokck.svg') }}" alt="Logo {{ config('app.name') }}" width="120" height="80">
            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>

        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                @if (isAllnonMasyarakat())
                <li>
                    <a class="{{ isRouteActive('resume') ? 'active' : '' }}" href="{{ route('resume') }}">
                        <span class="icon resume" aria-hidden="true"></span>
                        Resume
                    </a>
                </li>

                <li>
                    <a class="show-cat-btn {{ isRouteActive('surat') || isRouteActive('surat.pengajuan') || isRouteActive('surat.detail') ? 'reactive' : '' }}" href="##">
                        <span class="icon berkas" aria-hidden="true"></span>
                        Surat
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Surat</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ isRouteActive('surat') ? 'active' : '' }}" href="{{ route('surat') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="{{ isRouteActive('surat.pengajuan') || isRouteActive('surat.detail') ? 'active' : '' }}" href="{{ route('surat.pengajuan') }}">Pengajuan</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="show-cat-btn {{ isRouteActive('pengaduan') || isRouteActive('pengaduan.pengajuan') || isRouteActive('pengaduan.detail') ? 'reactive' : '' }}" href="##">
                        <span class="icon berkas" aria-hidden="true"></span>
                        Pengaduan
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Pengaduan</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ isRouteActive('pengaduan') ? 'active' : '' }}" href="{{ route('pengaduan') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="{{ isRouteActive('pengaduan.pengajuan') || isRouteActive('pengaduan.detail') ? 'active' : '' }}" href="{{ route('pengaduan.pengajuan') }}">Monitoring</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="show-cat-btn" href="##">
                        <span class="icon program-unggulan" aria-hidden="true"></span>
                        Kegiatan
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Kegiatan</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li>
                            <a href="#">Monitoring</a>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="#">
                        <span class="icon media" aria-hidden="true"></span>
                        Berita
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon tjsl" aria-hidden="true"></span>
                        Pengumuman
                    </a>
                </li>
                <li>
                    <a class="{{ isRouteActive('profile.kantor') ? 'active' : '' }}" href="{{ route('profile.kantor') }}">
                        <span class="icon perusahaan" aria-hidden="true"></span>
                        Profil
                    </a>
                </li>
                @if (isPetugasAdministrasi())
                <li>
                    <a class="{{ isRouteActive('user') ? 'active' : '' }}" href="{{ route('user') }}">
                        <span class="icon pengguna" aria-hidden="true"></span>
                        Pengguna
                    </a>
                </li>
                @endif
                @endif

                @if (isMasyarakat())
                <li>
                    <ul class="cat-sub-menu"></ul>
                </li>
                <li>
                    <a class="{{ isRouteActive('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <span class="icon resume" aria-hidden="true"></span>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a class="{{ isRouteActive('surat.pengajuan') || isRouteActive('surat.detail') ? 'active' : '' }}" href="{{ route('surat.pengajuan') }}">
                        <span class="icon berkas" aria-hidden="true"></span>
                        Surat
                    </a>
                </li>
                <li>
                    <a class="{{ isRouteActive('pengaduan.pengajuan') ? 'active' : '' }}" href="{{ route('pengaduan.pengajuan') }}">
                        <span class="icon reports" aria-hidden="true"></span>
                        Pengaduan
                    </a>
                </li>
                @endif

            </ul>
        </div>
    </div>

    <div class="sidebar-footer">
        <ul class="sidebar-body-menu">
            <li>
                <a href="{{ route('logout') }}" id="btn-logout">
                    <span class="icon logout" aria-hidden="true"></span>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</aside>
