@extends('layout.guest')
@section('content')

<div class="leaflet-popup-custom">
    <h5 class="card-title">Resume</h5>
    <p class="subtitle">Wilayah</p>
    <div class="progress-bar-berita">
        <div class="row d-flex align-items-center">
            <div class="col-5">
                <div class="progress">
                    <div class="progress-bar bg-progress-danger" role="progressbar" style="width: 50%;" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="col-1 d-flex align-items-center gap-2">
                <span class="value">50</span>
                <button class="btn btn-dark text-uppercase"  class="program-link" id="showProgram">detail</button>
            </div>
        </div>
        <span class="title ms-2">Program Unggulan</span>
    </div>
    <div class="progress-bar-berita mt-2">
        <div class="row d-flex align-items-center">
            <div class="col-5">
                <div class="progress">
                    <div class="progress-bar bg-progress-success" role="progressbar" style="width: 50%;" aria-valuenow="50"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="col-1 d-flex align-items-center gap-2">
                <span class="value">50</span>
                <button class="btn btn-dark text-uppercase" class="program-link" id="showTjsl">detail</button>
            </div>
        </div>
        <span class="title ms-2">TJSL</span>
    </div>
</div>
@endsection


marker.bindPopup(
                '<div class="leaflet-popup-custom">' +
                '<h5 class="card-title">Resume</h5>' +
                '<div class="mb-1">' +
                '<p>'+ wilayah.alamat + ', ' + wilayah.kelurahan + ', ' + wilayah.kecamatan +'</p>' +
                '<a href="#" class="program-link" id="showProgram' +
                index + '">Program Unggulan: ' + data
                .properties.jumlah.program +
                '</a></div>' +
                '<div class="mb-1"><a href="#" class="program-link" id="showTjsl' +
                index + '">Program TJSL: ' + data
                .properties.jumlah.tjsl +
                '</a></div>' +
                '<div class="mb-1"><a href="#" class="program-link" id="showPumk' +
                index + '">Program PUMK: ' + data.properties.jumlah.pumk +
                '</a></div>' +
                '<div class="d-flex justify-content-end"><button class="btn btn-primary" id="closePopupBtn' +
                index + '">Ok</button></div>' +
                '</div>', {
                    closeButton: false
                }
            );
