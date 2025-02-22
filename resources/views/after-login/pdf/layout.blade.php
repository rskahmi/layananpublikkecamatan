<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Balasan Terhadap @yield('nama-surat')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
        }
        html,
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .content {
            width: 100%;
            height: 100%;
            padding: 20px 58px 0 74px;
            box-sizing: border-box;
        }
        .content,
        table {
            color: var(--Dark-1-Dark, #202020);
            font-family: "Inter", sans-serif;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
        }
        .header {
            text-align: right;
        }
        .header img {
            height: 60mm;
            width: 169mm;
        }
        tr td {
            padding: 5px;
        }
        span.bolder {
            font-weight: bold;
        }
        .mt-0 {
            margin-top: 0px !important;
        }
        .mt-1 {
            margin-top: 4px !important;
        }
        .mt-2 {
            margin-top: 8px !important;
        }
        .mt-3 {
            margin-top: 16px !important;
        }
        .mt-4 {
            margin-top: 24px !important;
        }
        .mt-5 {
            margin-top: 48px !important;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <img style="height: 150px; width: 300px;"
                src="D:\JRFS\Self\Project\simpro-csr\public\assets\img\dafault\File.png" alt="Surat Balasan @yield('nama-surat')">
        </div>
        <div class="body">
            <div class="date">
                <div>Dumai, @yield('tanggal-sekarang')</div>
                <div>No. @yield('nomor-surat')</div>
            </div>
            <div class="perihal mt-3">
                <p>Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Pengajuan proposal @yield('nama-surat')</p>
            </div>
            <div class="greeting mt-2">
                <div>Yang terhormat</div>
                <div>Bapak/Ibu @yield('nama-pemohon')</div>
                <div>Di -</div>
                <div>Tempat</div>
            </div>

            @yield('main-body')

            <div class="ttd mt-5">
                <p>Area Manager Comm & Relation Sumbagut</p>
                <p class="pt-5">Agustiawan</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>
</html>
