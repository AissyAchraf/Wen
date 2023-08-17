<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
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
            <h1>Booking Confirmation</h1>
        </div>
        <div class="content">
            <p>Hello {{ $data->cust_name }},</p>
            <p>Your booking has been confirmed. We're excited to have you join us!</p>
            <p>Here are the details of your booking:</p>
            <ul>
                <li>Transaction ID: {{ $data->txn_id }}</li>
                <li>{{ $data->property_type }}: @if($data->property_type == "Room") {{ $data->property_data->room_type }}, {{ $data->property_data->beds_type }}, N°: {{ $data->property_data->number }} @elseif($data->property_type == "Chalet") {{ $data->property_data->name }} @else {{ $data->property_data->number }} @endif</li>
                @if($data->property_type == "Room")<li>Nights: {{ floor($data->paid_amount/($data->unit_price*100)) }}</li> @endif
                <li>Check-in: </li>
                <li>Check-out: </li>
            </ul>
            <p>We look forward to seeing you there. If you have any questions, feel free to contact us.</p>
            <div class="cta-button">
                <a href="{{ route('index', 'en') }}" style="background-color: #1cc3b2; color: #ffffff; padding: 10px 20px; border-radius: 5px; text-decoration: none;">Visite our site</a>
            </div>
        </div>
        <div class="footer">
            <p>Thank you for choosing us for your booking!</p>
            <p>&copy; 2023 Wen Site</p>
        </div>
    </div>
</body>
</html>
