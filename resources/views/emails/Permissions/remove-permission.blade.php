<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Permission Removed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 30px auto;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #b91c1c;
        }

        p {
            font-size: 15px;
            color: #374151;
            line-height: 1.6;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Hello {{ $user->name }},</h2>
        <p>
            ⚠️ We would like to inform you that some of your permissions have been removed.
        </p>
        <p>
            If you believe this change was made in error, please contact the system administrator.
        </p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your System Name. All rights reserved.</p>
        </div>
    </div>
</body>

</html>