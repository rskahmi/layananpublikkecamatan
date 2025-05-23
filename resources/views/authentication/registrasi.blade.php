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
                    <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap" required>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3">
                    <i class="envelope icon"></i>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan Email Google Anda" required>
                    <small id="emailWarning" class="text-danger d-none">
                        Format email tidak valid. Contoh: email@domain.com
                    </small>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3 position-relative">
                    <i class="lock icon"></i>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <button type="button" class="btn btn-light btn-sm position-absolute top-1 end-0 mt-2 me-2" id="togglePassword">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3 position-relative">
                    <i class="lock icon"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    <button type="button" class="btn btn-light btn-sm position-absolute top-1 end-0 mt-2 me-2" id="toggleConfirmPassword">
                        <i class="fa fa-eye"></i>
                    </button>
                    <small id="passwordMismatchWarning" class="text-danger d-none">
                        Konfirmasi password tidak cocok.
                    </small>
                </div>
            </div>

            <div class="col-12">
                <div class="mb-3 mb-md-4 mb-lg-3">
                    <i class="nomorpegawai icon"></i>
                    <input type="text" name="nip" class="form-control" placeholder="Masukkan NIK Anda" required>
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </div>

            <div class="link">
                <p>
                    Sudah Memiliki Akun?
                    <a href="{{ route('auth') }}">Login Disini</a>
                </p>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.getElementById("email");
            const emailWarning = document.getElementById("emailWarning");

            const togglePassword = document.getElementById("togglePassword");
            const password = document.getElementById("password");

            const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
            const confirmPassword = document.getElementById("password_confirmation");

            const warningText = document.getElementById("passwordMismatchWarning");

            // Regex untuk validasi email
            const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            // Validasi email format saat mengetik
            emailInput.addEventListener("input", function () {
                if (!emailRegex.test(emailInput.value)) {
                    emailWarning.classList.remove("d-none"); // Tampilkan peringatan
                } else {
                    emailWarning.classList.add("d-none"); // Sembunyikan peringatan
                }
            });

            // Toggle password utama
            togglePassword.addEventListener("click", function () {
                const type = password.type === "password" ? "text" : "password";
                password.type = type;
                this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
            });

            // Toggle konfirmasi password
            toggleConfirmPassword.addEventListener("click", function () {
                const type = confirmPassword.type === "password" ? "text" : "password";
                confirmPassword.type = type;
                this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
            });

            // Validasi konfirmasi password real-time
            function validatePasswordMatch() {
                if (confirmPassword.value !== password.value) {
                    warningText.classList.remove("d-none");
                } else {
                    warningText.classList.add("d-none");
                }
            }

            password.addEventListener("input", validatePasswordMatch);
            confirmPassword.addEventListener("input", validatePasswordMatch);
        });
    </script>
@endsection
