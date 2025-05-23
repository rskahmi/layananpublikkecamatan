@section('headers')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
@endsection


<div class="animate__animated animate__fadeInUp" id="mapid"></div>


<x-modals.BaseModal id="exampleModal">
    <div class="row">
        <div class="col-12">
            <h3 class="popup-title text-capitalize" id="judul-berita"></h3>
        </div>
        <div class="col-12">
            <div class="deskripsi">
                <div id="carouselGambarDokumentasi" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        {{-- slide show --}}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselGambarDokumentasi"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselGambarDokumentasi"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="deskripsi mt-3">
                <x-text.PopUpMenu title="Tanggal" id="tanggal" />
            </div>
            <div class="deskripsi mt-3">
                <x-text.PopUpMenu title="Alamat" id="alamat" />
            </div>
            <div class="deskripsi mt-3">
                <x-text.PopUpMenu title="Kontak" id="kontak" />
            </div>
        </div>
    </div>
</x-modals.BaseModal>
@section('scripts')
    <script src="https://unpkg.com/leaflet"></script>
    <script src="https://unpkg.com/leaflet-fullscreen/dist/Leaflet.fullscreen.min.js"></script>

    {{ $slot }}
    <script>
        var map = L.map('mapid').setView([1.6692, 101.4478], 13);

        // Define base layers
        var streetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var satelliteMap = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        });

        var baseLayers = {
            "Street Map": streetMap,
            "Satellite Map": satelliteMap
        };

        L.control.layers(baseLayers).addTo(map);

        streetMap.addTo(map);

        var pointData = [];



        pointData.forEach(function(data, index) {
            var latitude = data.geometry.coordinates[1];
            var longitude = data.geometry.coordinates[0];

            var marker = L.marker([latitude, longitude]).addTo(map);

            var tableContent =
                '<table id="dataTable" class="display table table-responsive dataTable popup-custom-width mt-3">' +
                '<thead>' +
                '<th>PROGRAM</th>' +
                '<th>TANGGAL</th>' +
                '<th>PIC</th>' +
                '<th>AKSI</th>' +
                '</thead>' +
                '<tbody>';

            pointData[index].tjsl.forEach(function(tjslItem, tjslIndex) {
                tableContent += '<tr>' +
                    '<td class="text-capitalize">' + removeWordProposal(tjslItem.nama) + '</td>' +
                    '<td>' + formatDfy(tjslItem.tanggal) + '</td>' +
                    '<td>' + tjslItem.pic + '</td>' +
                    '<td>' +
                    '<button class="text-uppercase detail-program btn btn-dark" data-nama="' +
                    removeWordProposal(tjslItem.nama) + '" data-tanggal="' + formatDfy(tjslItem.tanggal) +
                    '" data-pic="' + tjslItem.pic +
                    '" data-kontak="' + tjslItem.contact + '" data-alamat="' +
                    .kecamatan +
                    '" data-id="' + tjslItem.id + '" onclick="showDetailProgram(event)">detail' +
                    '</button>' + '</td>' +
                    '</tr>';
            });

            tableContent += '</tbody>' +
                '</table>';

            marker.bindPopup(
                '<div class="leaflet-popup-custom popup-custom-width">' +
                '<h5 class="card-title">Resume</h5>' +
                .kecamatan + '</span>' +
                tableContent +
                '</div>' +
                '<div class="d-flex justify-content-end"><button class="btn btn-primary" id="closePopupBtn' +
                index + '">Ok</button></div>' +
                '</div>', {
                    closeButton: false
                }
            );

            marker.on('popupopen', function() {
                document.querySelector('#closePopupBtn' + index).addEventListener('click', function() {
                    marker.closePopup();
                });
            });
        });

        map.addControl(new L.Control.Fullscreen());

        function removeWordProposal(sentence) {
            return sentence.replace(/\bproposal\b/gi, '');
        }

        var app_url = "{{ config('app.url') }}"

        function showDetailProgram(event) {
            var button = event.target;

            var nama = $(button).data('nama');
            var tanggal = $(button).data('tanggal');
            var kontak = $(button).data('kontak');
            var alamat = $(button).data('alamat');
            var pic = $(button).data('pic');
            var id = $(button).data('id');

            $("#judul-berita").html(nama)
            $("#tanggal").html(tanggal)
            $("#alamat").html(alamat)
            $("#kontak").html(kontak + " (<b>" + pic + "</b>)")

            $.ajax({
                url: app_url + '/tjsl/dokumentasi/' + id,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': @json(csrf_token()),
                },
                success: function(response) {
                    response.forEach((item, index) => {
                        var carouselItem = $('<div>', {
                            class: 'carousel-item' + (index == 0 ? ' active' : '')
                        })

                        var img = $('<img>', {
                            src: app_url + '/storage/images/dokumentasi-tjsl/' + item.nama_file,
                            class: 'd-block w-100',
                            alt: item.nama_kegiatan
                        })

                        carouselItem.append(img)
                        $("#carouselGambarDokumentasi .carousel-inner").append(carouselItem);
                    })
                },
                error: function(xhr, status, error) {
                    console.log('dokumentasi' + error);
                }
            });
            $("#exampleModal").modal('show')
        }
    </script>
@endsection
