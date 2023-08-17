<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Wen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .content {
            padding: 0 20px;
        }
        .cta-button {
            display: block;
            text-align: center;
            margin-top: 30px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('/img/core-img/win-logo.png') }}" alt="Wen Logo" class="logo">
            <h1>Contact Us</h1>
        </div>
        <div class="content">
            <p>Hello, I'm {{ $data->name }}</p>
            <p>My emil address is {{ $data->email }}</p>
            <p>{{ $data->message }}</p>
        </div>
        <div class="footer">
            <p>Thank you</p>
            <p>&copy; 2023 Wen Site</p>
        </div>
    </div>
</body>
</html>