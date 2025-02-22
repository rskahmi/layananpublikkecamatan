@extends('layout.guest')

@section('title', 'Persebaran Program')

@section('content')
    <div class="container persebaran">
        <div class="page-header">
            <h1>Persebaran Program CSR</h1>
        </div>
        <div class="body">
            <x-layout.resume>
                <script>
                    const wilayah = @json($wilayah)
                </script>
            </x-layout.resume>
        </div>
    </div>
@endsection
