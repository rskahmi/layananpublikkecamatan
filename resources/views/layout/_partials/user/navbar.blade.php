<nav class="main-nav--bg">
    <div class="container-fluid main-nav">
        <div class="main-nav-start">
            <h2 class="main-title">@yield('title')</h2>
        </div>
        <div class="main-nav-end">
            <button class="sidebar-toggle transparent-btn" title="Menu" type="button">
                <span class="sr-only">Toggle menu</span>
                <span class="icon menu-toggle--gray" aria-hidden="true"></span>
            </button>
            <div class="nav-user-wrapper">
                <a href="{{ route('profile') }}" class="nav-user-btn dropdown-btn" title="My profile" type="button">
                    <span class="sr-only">My profile</span>
                    <span class="nav-user-img">
                        <picture>
                            <img src="{{asset('assets/img/avatar/Rectangle 1944.svg') }}" width="30" height="30" alt="{{ auth()->user()->nama }}">
                        </picture>
                    </span>
                    @if(auth()->check())
                        <span>Hi, <span class="text-capitalize">{{ auth()->user()->nama }}</span></span>
                    @else
                        <script>window.location = "{{ route('auth') }}";</script>
                    @endif
                </a>
            </div>
        </div>
    </div>
</nav>
