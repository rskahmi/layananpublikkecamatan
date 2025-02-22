@props(['modal'])

<x-modals.admin id="newWilayahModal" modal="{{$modal}}" action="{{ route('store-wilayah') }}">
    @slot('slotHeader')
        <h5 class="modal-title" id="exampleModalLabel">Tambah Wilayah</h5>
    @endslot

    @slot('slotBody')
        <div class="row">
            <input type="text" name="latitude" id="latitude" class="d-none">
            <input type="text" name="longitude" id="longitude" class="d-none">
            <div class="col-6">
                <div class="alert alert-danger mt-2" style="display: none" role="alert" id="alertWilayah">
                </div>
                <div class="mb-3">
                    <x-forms.input label="Alamat" name="alamat" placeholder="Pilih Alamat Lengkap" />
                    <p class="text-danger" id="jalan-error"></p>
                </div>
                <div class="mb-3">
                    <x-forms.input label="Kelurahan" name="kelurahan" placeholder="Pilih Kelurahan" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Kecamatan" name="kecamatan" placeholder="Pilih Kecamatan" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Kabupaten / Kota" name="kabupaten" placeholder="Pilih Kabupaten / Kota" />
                </div>
                <div class="mb-3">
                    <x-forms.input label="Koordinat" name="koordinat" placeholder="Pilih Koordinat" />
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">
                        Atur Pin Point
                    </label>
                    <div class="add-location" id="maps">
                    </div>
                </div>
            </div>
        </div>
    @endslot

    @slot('slotFooter')
        <button type="submit" class="btn btn-primary btn-tutup-modal" id="btnSimpanWilayah">Simpan</button>
    @endslot
</x-modals.admin>
