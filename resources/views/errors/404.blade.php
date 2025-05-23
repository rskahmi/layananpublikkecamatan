@extends('layout.guest-no-navbar')
@section('title', 'Error Messages')
@section('content')
    <div class="error-container">
        <img src="{{ asset('assets/img/dafault/error-min.png') }}" alt="Error">
        <h2>Oops!</h2>
        <p>Ini bukan halaman yang ingin saya tuju!</p>
        <a href="{{ route('beranda') }}">Kembali</a>
    </div>
@endsection
