@extends('layout.user')
@section('title', 'Profil')
@section('content')
    <x-svg.fitur.profile />
    <x-svg.background2 />
    <div class="container profile-container">
        <div class="card profile">
            <div class="card-header">
                <img src="{{ asset('assets/img/avatar/Rectangle 1944.svg') }}" alt="Gambar" width="200" height="200">
            </div>
            <div class="card-body">
                <div class="row">
                    <table>
                        <tbody>
                            <tr>
                                <td colspan="2" class="header">Beberapa info yang meliputi identitas diri dan kontak :</td>
                            </tr>
                            <tr>
                                <td class="w-50">Nama Lengkap</td>
                                <td>{{ auth()->user()->nama }}</td>
                            </tr>
                            <tr >
                                <td class="w-50">E-mail</td>
                                <td> {{ auth()->user()->email }}</td>
                            </tr>
                            <tr>
                                <td class="w-50">NIK</td>
                                <td>{{ auth()->user()->nip }}</td>
                            </tr>
                            <tr>
                                <td class="w-50">Departemen</td>
                                <td>{{ auth()->user()->departemen }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row profile-footer">
                    <div class="col-12 d-flex justify-content-center">
                        <button class="btn btn-primary btn-edt-profile text-capitalize" data-bs-toggle="modal" data-bs-target="#editProfile">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modals.admin id="editProfile" action="{{ route('update-profile') }}" isUpdate=true>
        @slot('slotHeader')
            <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        @endslot

        @slot('slotBody')
            <div class="mb-3">
                <x-forms.input
                    label="Nama Lengkap"
                    name="nama"
                    placeholder="Masukkan Nama Lengkap"
                    value="{{ auth()->user()->nama }}"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="Email"
                    name="email"
                    placeholder="Masukkan Email"
                    value="{{ auth()->user()->email }}"
                />
            </div>
            <div class="mb-3">
                <x-forms.input
                    label="No Pegawai"
                    name="nip"
                    placeholder="Masukkan No Pegawai"
                    value="{{ auth()->user()->nip }}"
                />
            </div>
            <div class="mb-3">
                <x-forms.select
                    label="Departemen"
                    name="departemen"
                    placeholder="Pilih Departemen"
                    value="{{ auth()->user()->departemen }}">
                    <option value="Administrasi" {{ auth()->user()->departemen == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                    <option value="Keuangan" {{ auth()->user()->departemen == 'Keuangan' ? 'selected' : '' }}>Keuangan</option>
                    <option value="IT" {{ auth()->user()->departemen == 'IT' ? 'selected' : '' }}>IT</option>
                    <option value="HSE" {{ auth()->user()->departemen == 'HSE' ? 'selected' : '' }}>HSE</option>
                </x-forms.select>
            </div>

        @endslot

        @slot('slotFooter')
            <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
        @endslot
    </x-modals.admin>
@endsection
