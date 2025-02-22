@extends('layout.guest-no-navbar')
@section('content')
    <div class="developer">
        <div class="header">
            <div class="container">
                <img src="{{ asset('assets/img/logo/logotimah.svg') }}"
                class="logo-simpro" alt="Logo {{ config('app.name') }}"
                    width="155" height="55">


            </div>
        </div>
        <div class="body">
            <div class="container">
                <div class="title">
                    <h1>Developer Team</h1>
                </div>
                <div class="member">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4 mt-4">
                            <x-card.developer nama="Risky Ahmi" role="Web Developer" gambar="{{ asset('assets/img/developer/risky.png') }}"/>
                        </div>
                        <div class="col-12 col-sm-12 col-md-4 mt-4">
                            <x-card.developer nama="Putri Amanda Sari" role="Web Developer" gambar="{{ asset('assets/img/developer/amanda.png') }}"/>
                        </div>
                        {{-- <div class="col-12 col-sm-12 col-md-4 mt-4">
                            <x-card.developer nama="Azarine Aprilia Afdal" role="UI/UX Designer" gambar="{{ asset('assets/img/developer/azarine.png') }}"/>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
