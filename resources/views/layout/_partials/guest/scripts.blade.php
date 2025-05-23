<script src="{{asset('assets/guest/js/bootstrap.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<x-sweetalert/>

@vite('resources/js/app.js')
<script src="{{asset('assets/js/globals.js') }}"></script>
<script src="{{asset('assets/guest/js/customs.js') }}"></script>
@yield('scripts')
