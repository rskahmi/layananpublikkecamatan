<aside class="sidebar">
    <div class="sidebar-start">
        <div class="sidebar-head">
            <a href="/" class="logo-wrapper" title="Home">
                <span class="sr-only">Home</span>
                <img src="{{asset('assets/img/logo/logotimah.svg') }}" alt="Logo {{ config('app.name') }}"
                    width="120" height="80">
            </a>
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle" aria-hidden="true"></span>
            </button>
        </div>
        <div class="sidebar-body">
            <ul class="sidebar-body-menu">
                @if (isNonSarana())
                @if (isAllnonUser())
                <li>
                    <a class="{{ isRouteActive('resume') ? 'active' : '' }}" href="{{ route('resume') }}">
                        <span class="icon resume" aria-hidden="true"></span>
                        Resume
                    </a>
                </li>
                @endif
                <li>
                    <a class="show-cat-btn {{ isRouteActive('npp') ? 'reactive' : (isRouteActive('npp.pengajuan') ? 'reactive' : (isRouteActive('npp.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon berkas" aria-hidden="true"></span>
                        NPP
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">NPP</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        @if (isAllnonUser())
                        <li>
                            <a class="{{ isRouteActive('npp') ? 'active' : '' }}"
                                href="{{ route('npp') }}">Dashboard</a>
                        </li>
                        @endif
                        <li>
                            <a class="{{ isRouteActive('npp.pengajuan') ? 'active' : (isRouteActive('npp.detail') ? 'active' : '') }}"
                                href="{{ route('npp.pengajuan') }}">Pengajuan</a>
                        </li>
                    </ul>
                    @endif
                    <li>
                        <a class="show-cat-btn {{ isRouteActive('rd') ? 'reactive' : (isRouteActive('rd.pengajuan') ? 'reactive' : (isRouteActive('rd.detail') ? 'reactive' : '')) }}"
                            href="##">
                            <span class="icon perusahaan" aria-hidden="true"></span>
                            RD
                            <span class="category__btn transparent-btn" title="Open list">
                                <span class="sr-only">RD</span>
                                <span class="icon arrow-down" aria-hidden="true"></span>
                            </span>
                        </a>
                        <ul class="cat-sub-menu">
                            @if (isAllnonUser())
                            <li>
                                <a class="{{ isRouteActive('rd') ? 'active' : '' }}"
                                    href="{{ route('rd') }}">Dashboard</a>
                            </li>
                            @endif
                            <li>
                                <a class="{{ isRouteActive('rd.pengajuan') ? 'active' : (isRouteActive('rd.detail') ? 'active' : '') }}"
                                    href="{{ route('rd.pengajuan') }}">Pengajuan</a>
                            </li>
                            @if (isNonSarana())
                            <li>
                                <a class="{{ isRouteActive('penerbitan.penerbitan') ? 'active' : (isRouteActive('rd.detailPenerbitan') ? 'active' : '') }}"
                                    href="{{ route('penerbitan.penerbitan') }}">Penerbitan SIMRD</a>
                            </li>
                            @endif
                        </ul>
                    </li>
                </li>

                @if (isNonSarana())
                <li>
                    <a class="show-cat-btn {{ isRouteActive('spd') ? 'reactive' : (isRouteActive('spd.pengajuan') ? 'reactive' : (isRouteActive('spd.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon media" aria-hidden="true">
                        </span>
                        SPD
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">SPD</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        @if (isAllnonUser())
                        <li>
                            <a class="{{ isRouteActive('spd') ? 'active' : '' }}"
                                href="{{ route('spd') }}">Dashboard</a>
                        </li>
                        @endif
                        <li>
                            <a class="{{ isRouteActive('spd.pengajuan') ? 'active' : (isRouteActive('spd.detail') ? 'active' : '') }}"
                                href="{{ route('spd.pengajuan') }}">Pengajuan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn {{ isRouteActive('sij') ? 'reactive' : (isRouteActive('sij.pengajuan') ? 'reactive' : (isRouteActive('sij.detail') ? 'reactive' : '')) }} "
                        href="##">
                        <span class="icon program-unggulan" aria-hidden="true">
                        </span>
                        SIJ
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">SIJ</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        @if (isAllnonUser())
                        <li>
                            <a class="{{ isRouteActive('sij') ? 'active' : '' }}"
                                href="{{ route('sij') }}">Dashboard</a>
                        </li>
                        @endif
                        <li>
                            <a class="{{ isRouteActive('sij.pengajuan') ? 'active' : (isRouteActive('sij.detail') ? 'active' : '') }}"
                                href="{{ route('sij.pengajuan')}}">Pengajuan</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="show-cat-btn {{ isRouteActive('spdl') ? 'reactive' : (isRouteActive('spdl.pengajuan') ? 'reactive' : (isRouteActive('spdl.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon tjsl" aria-hidden="true">
                        </span>
                        SPDL
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">SPDL</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        @if (isAllnonUser())
                        <li>
                            <a class="{{ isRouteActive('spdl') ? 'active' : '' }}"
                                href="{{ route('spdl') }}">Dashboard</a>
                        </li>
                        @endif
                        <li>
                            <a class="{{ isRouteActive('spdl.pengajuan') ? 'active' : (isRouteActive('spdl.detail') ? 'active' : '') }}"
                                href="{{ route('spdl.pengajuan')}}">Pengajuan</a>
                        </li>
                    </ul>
                </li>

                @if (isAllnonUser())
                <li>
                    <a class="show-cat-btn {{ isRouteActive('rotasi') ? 'reactive' : (isRouteActive('rotasi.pengajuan') ? 'reactive' : (isRouteActive('rotasi.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon reports" aria-hidden="true">
                        </span>
                        Rotasi
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Rotasi</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ isRouteActive('rotasi') ? 'active' : '' }}"
                                href="{{ route('rotasi') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="{{ isRouteActive('rotasi.pengajuan') ? 'active' : (isRouteActive('rotasi.detail') ? 'active' : '') }}"
                                href="{{ route('rotasi.pengajuan')}}">Pengajuan</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="show-cat-btn {{ isRouteActive('mutasi') ? 'reactive' : (isRouteActive('mutasi.pengajuan') ? 'reactive' : (isRouteActive('mutasi.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon reports" aria-hidden="true">
                        </span>
                        Mutasi
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Mutasi</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ isRouteActive('mutasi') ? 'active' : '' }}"
                                href="{{ route('mutasi') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="{{ isRouteActive('mutasi.pengajuan') ? 'active' : (isRouteActive('mutasi.detail') ? 'active' : '') }}"
                                href="{{ route('mutasi.pengajuan')}}">Pengajuan</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="show-cat-btn {{ isRouteActive('promosi') ? 'reactive' : (isRouteActive('promosi.pengajuan') ? 'reactive' : (isRouteActive('promosi.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon reports" aria-hidden="true">
                        </span>
                        Promosi
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Promosi</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ isRouteActive('promosi') ? 'active' : '' }}"
                                href="{{ route('promosi') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="{{ isRouteActive('promosi.pengajuan') ? 'active' : (isRouteActive('promosi.detail') ? 'active' : '') }}"
                                href="{{ route('promosi.pengajuan')}}">Pengajuan</a>
                        </li>
                    </ul>
                </li>
                @endif

                @if (isAksesPengguna())
                    <li>
                        <a class="{{ isRouteActive('user') ? 'active' : '' }}" href="{{ route('user') }}">
                            <span class="icon pengguna" aria-hidden="true"></span>
                            </span>
                            Pengguna
                        </a>
                    </li>
                @endif

                {{-- <li>
                    <a class="show-cat-btn {{ isRouteActive('berkas') ? 'reactive' : (isRouteActive('berkas.pengajuan') ? 'reactive' : (isRouteActive('berkas.detail') ? 'reactive' : '')) }}"
                        href="##">
                        <span class="icon berkas" aria-hidden="true"></span>
                        Berkas
                        <span class="category__btn transparent-btn" title="Open list">
                            <span class="sr-only">Berkas</span>
                            <span class="icon arrow-down" aria-hidden="true"></span>
                        </span>
                    </a>
                    <ul class="cat-sub-menu">
                        <li>
                            <a class="{{ isRouteActive('media') ? 'active' : '' }}"
                                href="{{ route('media') }}">Dashboard</a>
                        </li>
                        <li>
                            <a class="{{ isRouteActive('berkas.pengajuan') ? 'active' : (isRouteActive('berkas.detail') ? 'active' : '') }}"
                                href="{{ route('berkas.pengajuan') }}">Pengajuan</a>
                        </li>
                    </ul>
                </li> --}}

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
