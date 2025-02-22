<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
            text-align: center;
        }
        .email-footer {
            background-color: #f1f1f1;
            padding: 10px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .email-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .email-button:hover {
            background-color: #0056b3;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>{{ $data['jenis'] }}</h1>
        </div>
        <div class="email-body">
            <p>{{ $data['text'] }}</p>
            <a href="http://127.0.0.1:8000/" class="email-button">{{ $buttonText ?? 'Click Here' }}</a>
        </div>
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} PT Timah Tbk Area Kundur. All rights reserved.</p>
        </div>
    </div>
</body>
</html>




{{-- <!DOCTYPE html>
<html>
<head>
    <title>Email Test</title>
</head>
<body>
    <h1>{{ $data['title'] }}</h1>
    <p>{{ $data['message'] }}</p>
</body>
</html> --}}
