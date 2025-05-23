@extends('layout.guest')

@section('bodyClass', 'body-hubungi')
@section('title', 'Hubungi kami Pertamina RU II Dumai')
@section('content')
    <div class="container">
        <div class="page-header">
            <h1>Hubungi Kami</h1>
        </div>

        {{-- <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.113319707888!2d101.46012227581573!3d1.675092560442365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d3afbb4a5629bd%3A0xae240cba8d3456e9!2sComrel%20%26%20CSR%20PT%20Kilang%20Pertamina%20Internasional%20RU%202%20Dumai!5e0!3m2!1sen!2sid!4v1713746587332!5m2!1sen!2sid"
            width="100%" height="390" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe> --}}

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.4902651182115!2d103.36607007472372!3d0.7347464992581066!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d765fcdbb8ef3f%3A0xef9a9d0b1e75d864!2sKantor%20Camat%20Kundur%20Barat!5e0!3m2!1sid!2sid!4v1741668445030!5m2!1sid!2sid"
            width="100%" height="390" style="border:0;"
            allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>

        <div class="card kontak">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-xl-4 col-xl-3">
                        <h5>The Office</h5>
                        <div class="mb-2">
                            Kantor Camat Kundur Barat <br>
                            " Jalan Besar Sawang Kota KM 16
                            Kundur Barat Kabupaten Karimun, Kepulauan Riau "
                        </div>
                        <div class="mb-2">
                            <span>Telepon</span>: <a target="_blank" href="
                            ">085835401314 </a>
                        </div>
                        <div class="mb-2">
                            <span>WA</span>: <a target="_blank" href="https://wa.me/{{ '085835401314' }}
                            ">085835401314 </a>
                        </div>
                        <div class="mb-0">
                            <span>Email</span>: <a target="_blank" href="mailto:{{ 'riskyahmi123@gmail.com' }}">riskyahmi123@gmail.com</a>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
@endsection
