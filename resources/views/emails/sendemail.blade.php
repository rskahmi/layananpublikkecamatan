<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f2f3f5;
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #dadce0;
            box-shadow: 0 1px 3px rgba(60,64,67,0.3);
            padding: 32px 24px;
            text-align: center;
        }

        .logo {
            margin-bottom: 16px;
        }

        .logo img {
            height: 24px;
        }

        h2 {
            font-size: 20px;
            color: #202124;
            margin-bottom: 8px;
        }

        .email {
            color: #5f6368;
            font-size: 14px;
            margin-bottom: 24px;
        }

        .divider {
            height: 1px;
            background-color: #dadce0;
            margin: 24px 0;
        }

        .message {
            color: #202124;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .btn {
            background-color: #1a73e8;
            color: white;
            padding: 10px 24px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }

        .footer {
            font-size: 12px;
            color: #5f6368;
            margin-top: 24px;
        }

        .footer a {
            color: #1a73e8;
            text-decoration: none;
        }

        .icon {
            background-color: #d2e3fc;
            color: #1a73e8;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            line-height: 40px;
            display: inline-block;
            font-weight: bold;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            {{-- <img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_92x30dp.png" alt="Logo"> --}}
            {{-- <img src="{{ asset('assets/img/logo/logokck.svg') }}" alt="Logo {{ config('app.name') }}" width="92" height="30"> --}}
        </div>
        <div class="email">
            {{-- <div class="icon">Layanan Kecamatan</div><br> --}}
            Layanan Online Kantor Camat Kundur Barat
        </div>
        <h2>
            Jenis :
            {{ $data['jenis'] }}
        </h2>


        <div class="divider"></div>
        <div class="message">
            {{ $data['text'] }}<br>
            {{-- Jika ini memang kamu, tidak perlu melakukan apa pun. Jika tidak, kami bantu amankan akun kamu. --}}
        </div>

        <a href="http://127.0.0.1:8000/" class="btn">{{ $buttonText ?? 'Lihat Disini' }}</a>

        <div class="footer">
            {{-- Kamu juga bisa melihat aktivitas keamanan di<br> --}}
            {{-- <a href="#">https://myaccount.google.com/notifications</a><br><br> --}}
            © {{ date('Y') }} Kantor Camat Kundur Barat
        </div>
    </div>
</body>
</html>
