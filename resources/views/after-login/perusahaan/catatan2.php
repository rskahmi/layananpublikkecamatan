<div class="col-12 col-xl-5">
                    <div class="card customize sekilas-ru-ii">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="card-title">Sejarah Pertamina RU II</h5>
                                </div>
                                <div class="col-6 card-header d-flex justify-content-end">
                                    <a href="#edit-kontak" class="btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editSejarah">
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
                        </div>
                    </div>
                </div>