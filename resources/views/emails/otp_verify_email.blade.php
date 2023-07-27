<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Email</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 36px;
            margin: 0;
            color: #333;
        }

        .otp-box {
            text-align: center;
            margin-bottom: 30px;
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .otp-code {
            font-size: 48px;
            font-weight: bold;
            color: #007bff;
            letter-spacing: 10px;
            margin: 0;
        }

        .instructions {
            text-align: center;
            margin-bottom: 30px;
            color: #555;
        }

        .instructions p {
            margin: 0;
            font-size: 18px;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: #ffffff;
            font-size: 20px;
            border-radius: 8px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            color: #888;
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>OTP Verification Code</h1>
        </div>
        <div class="otp-box">
            <p class="otp-code">{{ $otp }}</p>
        </div>
        <div class="instructions">
            <p>Use the above code to verify your account.</p>
        </div>
        <div class="footer">
            <p>This email was sent by Laravel 10 Syntax.</p>
        </div>
    </div>
</body>

</html>
