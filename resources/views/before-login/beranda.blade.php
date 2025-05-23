@extends('layout.guest')
@section('bodyClass', 'body-beranda')
@section('title', 'Homepage')
@section('content')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body {
    font-family: 'Arial', sans-serif;
    background: #f4f4f4;
    color: #333;
    line-height: 1.6;
  }
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }
  .logo {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .logo img {
    width: 30px;
    height: 30px;
  }
  nav a {
    margin-left: 20px;
    text-decoration: none;
    color: black;
    font-size: 14px;
    padding: 5px 10px;
  }
  .hero {
  background-image: url('assets/img/bg.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  height: 70vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  border-radius: 10px;
  max-width: 1390px;
}
    .hero-content {
    background-color: rgba(0, 0, 0, 0.5); /* opsional, biar teks lebih jelas */
    padding: 20px;
    border-radius: 10px;
    }
  .hero h1 {
    font-size: 24px;
    font-weight: bold;
  }

  section {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
  }

  h2 {
    font-size: 20px;
    margin-bottom: 20px;
    font-weight: bold;
    text-align: center;
  }
  @media (max-width: 768px) {
    nav {
      display: flex;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    nav a {
      margin: 5px 10px 0 0;
    }

    .hero h1 {
      font-size: 20px;
    }

    footer .container {
      flex-direction: column;
      align-items: center;
    }
  }
</style>
<section class="hero">
    <div class="hero-content">
      <h1>Website Resmi Kecamatan Kundur Barat</h1>
      <h2>Kabupaten Karimun <br> Provinsi Kepulauan Riau</h2>
    </div>
  </section>
<section>
    <div class="container pemberitaan">
        <div class="page-header" style="text-align: center;">
            <h1>Informasi Seputar Kundur Barat</h1>
        </div>

        <div class="row">
            @foreach ($berita as $item)
            <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                <x-card.berita-card
                title="{{ $item->judul }}"
                detail="{!! $item->deskripsi !!}"
                tautan="{{ $item->tautan }}"
                gambar="{{ isFileExists('storage/images/rilis/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                >
                onclick="beritaPopUp(`{{ $item->judul }}`, `{{ isFileExists('storage/images/rilis/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}`, `{{ $item->deskripsi }}`, {{$item->pemberitaan}})"
                </x-card.berita-card>
            </div>
            @endforeach
        </div>

        {{-- <div class="pagination" id="pagination">
            <ul>
                @if ($berita->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $berita->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                @foreach ($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                    @if ($page == $berita->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                @if ($berita->hasMorePages())
                    <li><a href="{{ route('berita', ['page' => $berita->nextPageUrl()]) }}" rel="next">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        </div> --}}

        <x-modals.BaseModal id="exampleModal">
            <div class="row">
                <div class="col-12">
                    <h3 class="popup-title" id="judul-berita"></h3>
                </div>
                <div class="col-12 mt-2">
                    <img id="gambarBerita" src="" alt="Gambar Pertamina Show 2023"/>
                </div>
                <div class="col-12">
                    <div class="deskripsi mt-3">
                        <x-text.PopUpMenu
                            title="Deskripsi"
                            id="deskripsi"
                        />
                    </div>
                </div>
            </div>
        </x-modals.BaseModal>
    </div>
</section>
<section>
    <div class="container pemberitaan">
        <div class="page-header" style="text-align: center;">
            <h1>Kegiatan Kantor Camat Kundur Barat</h1>
        </div>

        <div class="row">
            @foreach ($program_unggulan as $item)
                <div class="col-12 col-md-6 col-lg-4 mb-3 mb-lg-0">
                    <x-card.program
                    badge="UMKM"
                    title="{{ $item->nama_kegiatan }}"
                    detail="{!! $item->deskripsi !!}"
                    kontak="{{ checkNumber($item->contact) }}"
                    gambar="{{ isFileExists('storage/images/program-unggulan/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                    >
                    onclick="kegiatanPopUp(`{{ $item->nama_kegiatan }}`, `{{ isFileExists('storage/images/program_unggulan/' . $item->gambar, asset('assets/img/dafault/default-bg.png')) }}`, `{{ $item->deskripsi }}`)"
                    </x-card.program>
                </div>
            @endforeach
        </div>

        {{-- <div class="pagination" id="pagination">
            <ul>
                @if ($program_unggulan->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $program_unggulan->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                @endif

                @foreach ($program_unggulan->getUrlRange(1, $program_unggulan->lastPage()) as $page => $url)
                    @if ($page == $program_unggulan->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
                @if ($program_unggulan->hasMorePages())
                    <li><a href="{{ $program_unggulan->nextPageUrl() }}" rel="next">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul> --}}
        </div>
        <x-modals.BaseModal id="exampleModal">
            <div class="row">
                <div class="col-12">
                    <h3 class="popup-title" id="judul-berita"></h3>
                </div>
                <div class="col-12 mt-2">
                    <img id="gambarBerita" src="" alt="Gambar Pertamina Show 2023"/>
                </div>
                <div class="col-12">
                    <div class="deskripsi mt-3">
                        <x-text.PopUpMenu
                            title="Deskripsi"
                            id="deskripsi"
                        />
                    </div>
                </div>
            </div>
        </x-modals.BaseModal>

        <x-modals.BaseModal id="exampleModal">
            <div class="row">
                <div class="col-12">
                    <h3 class="popup-title" id="nama-kegiatan"></h3>
                </div>
                <div class="col-12 mt-2">
                    <img id="gambarKegiatan" src="" alt="Gambar Pertamina Show 2023"/>
                </div>
                <div class="col-12">
                    <div class="deskripsi mt-3">
                        <x-text.PopUpMenu
                            title="Deskripsi"
                            id="deskripsi"
                        />
                    </div>
                </div>
            </div>
        </x-modals.BaseModal>
    </div>
</section>
@endsection

@section('scripts')
<script>
  const app_url = "{{ config('app.url') }}";

  function setMessage(status) {
    switch (status) {
      case 'diajukan': return 'Berkas diajukan oleh stakeholder';
      case 'proses': return 'Berkas sedang diproses';
      case 'diterima': return 'Berkas telah disetujui untuk dibantu';
      case 'ditolak': return 'Berkas tidak disetujui untuk dibantu';
      default: return 'Status tidak diketahui';
    }
  }

  $("#btnSearchBerkas").on("click", function () {
    const keyword = $("#inputSearchBerkas").val();
    const url = $(this).data("url");
    const csrf = @json(csrf_token());

    if (keyword.length > 0) {
      $.ajax({
        url: url,
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf,
        },
        data: {
          keyword: keyword
        },
        success: function (response) {
          // Lanjutkan pemrosesan data di sini
        }
      });
    }
  });
</script>
@endsection
