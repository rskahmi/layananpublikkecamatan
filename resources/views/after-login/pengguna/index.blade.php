@extends('layout.user')

@section('headers')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection

@section('title', 'Pengguna')
@section('content')
<x-svg.fitur.tjsl />
<div class="row">
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 mb-2 mb-lg-0">
        <x-card.summary header="Total Akun" value="{{ formatRibuan($total_akun) }}" footer="dari Seluruh Pengguna"
            id="allUsers">
            <x-svg.icon.users />
        </x-card.summary>
    </div>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xxl-2 mb-2 mb-lg-0">
        <x-card.summary header="Total Akun Masyarakat" color="red" value="{{ formatRibuan($total_admin) }}"
            footer="dari Seluruh Pengguna" id="akunManager">
            <x-svg.icon.manager />
        </x-card.summary>
    </div>
</div>

<div class="animate__animated animate__fadeInUp">
    <div class="card table mt-2 mt-lg-3">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-6">
                    <h4>Daftar List Akun</h4>
                </div>
                <div class="col-6 d-flex justify-content-end gap-2">
                    <x-search />
                    {{-- @if (isManager())
                            <button class="btn btn-primary text-capitalize" data-bs-toggle="modal" data-bs-target="#tambahUser">
                                <x-svg.icon.addfile />
                                Tambah User
                            </button>
                        @endif --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <x-table>
                @slot('slotHeading')
                <tr>
                    <th scope="col">NAMA</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">NIK</th>
                    <th scope="col">ROLE AKSES</th>
                    <th scope="col">STATUS</th>
                    <th scope="col">AKSI</th>
                </tr>
                @endslot

                @slot('slotBody')
                @foreach ($user as $item )
                <tr>
                    <td>
                        {{ $item->nama }}
                    </td>
                    <td>
                        {{ $item->email }}
                    </td>
                    <td>
                        {{ $item->nip }}
                    </td>
                    <td>
                        {{ roles($item->role )}}
                    </td>
                    <td>

                        <span class="badge text-capitalize
                {{ isStatusVerify($item->status) ? 'bg-success' :
                (isStatusNonVerify($item->status) ? 'bg-warning' :
                (isStatusDitolak($item->status) ? 'bg-danger' : 'bg-secondary')) }}">
                            {{ $item->status }}
                        </span>


                    </td>
                    <td>
                        <a href="{{route('user.detail', ['id' => $item->id])}}">
                            <x-svg.icon.info />
                        </a>
                    </td>

                </tr>
                @endforeach
                @endslot
            </x-table>
        </div>
    </div>

    <x-pagination />
</div>

<!-- Modal -->
@if (isPetugasAdministrasi())
<x-modals.admin action="{{route('user.store')}}" id="tambahUser">
    @slot('slotHeader')
    <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
    @endslot

    @slot('slotBody')
    <div class="mb-3">
        <x-forms.input label="Nama Lengkap" name="nama" placeholder="Masukkan Nama Lengkap" />
    </div>
    <div class="mb-3">
        <x-forms.input label="Email" name="email" type="email" placeholder="Masukkan Email" />
    </div>
    <div class="mb-3">
        <x-forms.input label="NIK" type="number" name="nip" placeholder="Masukkan NIK" />
    </div>
    <div class="mb-3">
        <x-forms.select label="Role Akses" name="role" placeholder="Masukkan Role Akses">
            <option value="admin">User</option>
            <option value="am">Areal Manager</option>
            <option value="admin">Admin</option>
            <option value="admin-csr">Admin CSR</option>
            <option value="admin-comrel">Admin Comrel</option>
            </x-forms.select2>
    </div>
    @endslot

    @slot('slotFooter')
    <button type="submit" class="btn btn-primary btn-tutup-modal">Simpan</button>
    @endslot
</x-modals.admin>
@endif
@endsection

@section('scripts')
<script>
    dataTable(8)
    document.addEventListener('DOMContentLoaded', function () {
        Echo.channel('test-user-channel')
            .listen('TestUser', (e) => {
                var user = e.data
                dataTables['dataTable'].row.add([
                    user.nama, user.email, user.nip, user.role
                ]).draw(false)
                if (user.role === "am" || user.role === "gm") {
                    setSummary("#akunManager")
                } else if (user.role === "admin-csr" || user.role === "admin-comrel") {
                    setSummary("#akunAdmin")
                }
                setSummary("#allUsers")
            });
    });
</script>
@endsection
