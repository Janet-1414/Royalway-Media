<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RoyalWay Media')</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #f4f4f4;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: #38558A;
            padding: 30px 20px;
            text-align: center;
        }
        .header img {
            max-width: 180px;
            height: auto;
        }
        .content {
            padding: 40px 30px;
        }
        .content h1 {
            color: #38558A;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .content p {
            line-height: 1.6;
            margin-bottom: 15px;
            color: #555555;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #018DB1;
            padding: 15px 20px;
            margin: 20px 0;
        }
        .info-box strong {
            color: #38558A;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #38558A;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .footer {
            background-color: #1B1F2A;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #018DB1;
            text-decoration: none;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('assets/img/logo-white.png') }}" alt="RoyalWay Media">
    </div>


    <!-- Content -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>RoyalWay Media Ltd</strong></p>
        <p>Plot 23, Cooper Road, Kisementi-Kololo, Kampala, Uganda</p>
        <p>
            Email: <a href="mailto:sales@royalwaymedia.com">sales@royalwaymedia.com</a><br>
            Phone: <a href="tel:+256772464686">+256 772 464 686</a> | <a href="tel:+256774038086">+256 774 038 086</a>
        </p>
        <div class="divider" style="background-color: #38558A; margin: 15px auto; width: 80%;"></div>
        <p style="font-size: 12px; color: #FAFAFA;">
            &copy; {{ date('Y') }} RoyalWay Media Ltd. All Rights Reserved.
        </p>
    </div>
</div>


</body>
</html>
