<script src="{{asset('assets/user/plugins/chart.min.js') }}"></script>
<script src="{{asset('assets/user/plugins/feather.min.js') }}"></script>
<script src="{{asset('assets/user/js/script.js') }}"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>


<script src="{{asset('assets/js/datepicker.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
<x-sweetalert/>

@vite('resources/js/app.js')
<script src="{{asset('assets/user/js/customs.js') }}"></script>
<script src="{{asset('assets/js/globals.js') }}"></script>
@yield('scripts')
