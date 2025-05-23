<div class="col-12 col-xl-5">
                    <div class="card customize sejarah-ru-ii">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Struktur Organisasi</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editStrukturOrganisasi">
                                        <x-svg.icon.editGray />
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-body">
                            <img class="w-100"
                                src="{{ isFileExists('storage/images/profil-perusahaan/sejarah/' . $sejarah->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                alt="Gambar sejarah">
                            <div class="deskripsi">
                                <div class="limited-text-deskripsi-sejarah">
                                    {!! limitCharacters($sejarah->deskripsi, 290) !!}
                                </div>
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="full-text-deskripsi-sejarah" style="display: none;">
                                        {!! $sejarah->deskripsi !!}
                                    </div>
                                @endif
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="text-center">
                                        <a class="btn-more-less" href="#show-more" id="showMoreSejarah">Show More</a>
                                    </div>
                                @endif
                            </div>
                        </div> --}}
                    </div>
                </div>






                <div class="col-12 col-xl-5">
                    <div class="card customize sejarah-ru-ii">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Alur Pengajuan Surat</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editAlurSurat">
                                        <x-svg.icon.editGray />
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img class="w-100"
                                src="{{ isFileExists('storage/images/profil-perusahaan/alursurat/' . $alursurat->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                alt="Gambar alursurat">
                            <div class="deskripsi">
                                <div class="limited-text-deskripsi-alursurat">
                                    {!! limitCharacters($alursurat->deskripsi, 290) !!}
                                </div>
                                @if (isLimit($alursurat->deskripsi, 290))
                                    <div class="full-text-deskripsi-alursurat" style="display: none;">
                                        {!! $alursurat->deskripsi !!}
                                    </div>
                                @endif
                                @if (isLimit($alursurat->deskripsi, 290))
                                    <div class="text-center">
                                        <a class="btn-more-less" href="#show-more" id="showMoreAlurSurat">Show More</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>






<div class="col-12 col-xl-5 mt-3">
                    <div class="card customize sejarah-ru-ii">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Alur Pengajuan Pengaduan</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editStrukturOrganisasi">
                                        <x-svg.icon.editGray />
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="card-body">
                            <img class="w-100"
                                src="{{ isFileExists('storage/images/profil-perusahaan/sejarah/' . $sejarah->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                alt="Gambar sejarah">
                            <div class="deskripsi">
                                <div class="limited-text-deskripsi-sejarah">
                                    {!! limitCharacters($sejarah->deskripsi, 290) !!}
                                </div>
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="full-text-deskripsi-sejarah" style="display: none;">
                                        {!! $sejarah->deskripsi !!}
                                    </div>
                                @endif
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="text-center">
                                        <a class="btn-more-less" href="#show-more" id="showMoreSejarah">Show More</a>
                                    </div>
                                @endif
                            </div>
                        </div> --}}
                    </div>
                </div>








                <div class="col-12 col-xl-5 mt-3">
                    <div class="card customize sejarah-ru-ii">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Alur Registrasi Akun dan Login</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editAlurRegistrasi">
                                        <x-svg.icon.editGray />
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <img class="w-100"
                                src="{{ isFileExists('storage/images/profil-perusahaan/sejarah/' . $sejarah->gambar, asset('assets/img/dafault/default-bg.png')) }}"
                                alt="Gambar sejarah">
                            {{-- <div class="deskripsi">
                                <div class="limited-text-deskripsi-sejarah">
                                    {!! limitCharacters($sejarah->deskripsi, 290) !!}
                                </div>
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="full-text-deskripsi-sejarah" style="display: none;">
                                        {!! $sejarah->deskripsi !!}
                                    </div>
                                @endif
                                @if (isLimit($sejarah->deskripsi, 290))
                                    <div class="text-center">
                                        <a class="btn-more-less" href="#show-more" id="showMoreSejarah">Show More</a>
                                    </div>
                                @endif
                            </div> --}}
                        </div>
                    </div>
                </div>


