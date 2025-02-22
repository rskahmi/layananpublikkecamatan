<footer class="footer {{ in_array(Route::currentRouteName(), ['auth', 'registrasi']) ? 'w-50' : 'w-100' }}">
    <div class="text-center">
        <p class="copyright-text">
            Copyright 2025 PT Timah Tbk Area Kundur |
            <a href="{{ route('developer') }}" target="_blank"
                rel="noopener noreferrer">
                Web Developer
            </a>
        </p>
    </div>
</footer>
