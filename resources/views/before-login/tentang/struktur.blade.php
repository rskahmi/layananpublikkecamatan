@extends('before-login.tentang.layout')

@section('title', 'Tentang Pertamina RU II Dumai')
@section('tentang-content')


<style>
    .tree ul {
        padding-top: 20px;
        position: relative;
        left: -15px;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree ul ul ul::before {
        content: '';
        position: absolute;
        left: 55%;
        bottom: -20px;
        border-left: 2px solid rgba(0, 0, 0, .45);
        height: 20px;
    }

    .tree li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li::before,
    .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid rgba(0, 0, 0, .45);
        width: 50%;
        height: 20px;
    }

    .tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid rgba(0, 0, 0, .45);
    }

    .tree li:only-child::after,
    .tree li:only-child::before {
        display: none;
    }

    .tree li:only-child {
        padding-top: 0;
    }

    .tree li:first-child::before,
    .tree li:last-child::after {
        border: 0 none;
    }

    .tree li:last-child::before {
        border-right: 2px solid rgba(0, 0, 0, .45);
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }

    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    .tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 55%;
        border-left: 2px solid rgba(0, 0, 0, .45);
        width: 0;
        height: 20px;
    }

    .tree li a {
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree ul ul ul ul li a {
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 10px;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        border: 2px solid rgba(0, 0, 0, .45);
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
        writing-mode: vertical-rl !important;
        text-orientation: mixed !important;
        white-space: nowrap;
    }

    .struktur img {
        width: 120px;
        height: 122px;
        border-radius: 5px 5px 0px 0px;
        object-fit: cover;
    }

    .struktur a img {
        border-top: .25px solid #145ea8;
        border-left: .25px solid #145ea8;
        border-right: .25px solid #145ea8;
    }
</style>

    <div class="struktur">
        <h3 class="tentang-title">Struktur Group</h3>
        <div class="tree">
            <ul>
                <li>
                    <a href="#">
                        <img src="{{ asset('storage/images/profil-perusahaan/struktur/' . $jabatanTingkat1->gambar) }}"
                            alt="Gambar {{ $jabatanTingkat1->deskripsi }}">
                        <div class="identitas text-center">
                            {{ $jabatanTingkat1->deskripsi }}
                            <div class="jabatan">
                                {{ $jabatanTingkat1->jabatan }}
                            </div>
                        </div>
                    </a>
                    <ul>
                        <li>
                            <a href="#">
                                <img src="{{ asset('storage/images/profil-perusahaan/struktur/' . $jabatanTingkat2->gambar) }}"
                                    alt="Gambar {{ $jabatanTingkat2->deskripsi }}">
                                <div class="identitas text-center">
                                    {{ $jabatanTingkat2->deskripsi }}
                                    <div class="jabatan">
                                        {{ $jabatanTingkat2->jabatan }}
                                    </div>
                                </div>
                            </a>
                            <ul>
                                <li><a href="#">
                                        <img src="{{ asset('storage/images/profil-perusahaan/struktur/' . $jabatanTingkat3->gambar) }}"
                                            alt="Gambar {{ $jabatanTingkat3->deskripsi }}">
                                        <div class="identitas text-center">
                                            {{ $jabatanTingkat3->deskripsi }}
                                            <div class="jabatan">
                                                {{ $jabatanTingkat3->jabatan }}
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('storage/images/profil-perusahaan/struktur/' . $jabatanTingkat4->gambar) }}"
                                            alt="Gambar {{ $jabatanTingkat4->deskripsi }}">
                                        <div class="identitas text-center">
                                            {{ $jabatanTingkat4->deskripsi }}
                                            <div class="jabatan">
                                                {{ $jabatanTingkat4->jabatan }}
                                            </div>
                                        </div>
                                    </a>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection
