@extends('layout.guest-right-navbar')
@section('title', 'Registrasi')
@section('content')
    <div class="registrasi animate__animated animate__fadeInRight">
        <h1>Sign Up</h1>
        <form action="{{ route('registrasi.store') }}" method="POST">
            @csrf
            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3">
                    <i class="nama icon"></i>
                    <input type="text" name ="nama" class="form-control" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3">
                    <i class="envelope icon"></i>
                    <input type="email" name ="email" class="form-control" placeholder="Email Address">
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3 position-relative">
                    <i class="lock icon"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <button type="button" class="btn btn-light btn-sm position-absolute top-1 end-0 mt-2 me-2" id="togglePassword">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3">
                    <i class="departemen icon"></i>
                    <select name="departemen" class="form-control-departemen">
                        <option value="" disabled selected>Pilih Departemen</option>
                        <option value="Administrasi">Administrasi</option>
                        <option value="Keuangan">Keuangan</option>
                        <option value="IT">IT</option>
                        <option value="HSE">HSE</option>

                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3">
                    <i class="nomorpegawai icon"></i>
                    <input type="text" name ="nip" class="form-control" placeholder="NIK">
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </div>

            <div class="link">
                <p>
                    Sudah Memiliki Akun ?
                    <a href="{{ route('auth') }}"
                        >
                        Login Disini
                    </a>
                </p>
            </div>

        </form>
    </div>
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // Toggle visibility
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;

            // Ganti ikon tombol
            this.innerHTML = passwordInput.type === "password" ?
                '<i class="fa fa-eye"></i>' :
                '<i class="fa fa-eye-slash"></i>';
        });
    </script>
@endsection
