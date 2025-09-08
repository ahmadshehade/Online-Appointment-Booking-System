<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Permission Assigned</title>
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
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2d3748;
        }
        p {
            font-size: 15px;
            color: #4a5568;
            line-height: 1.6;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #a0aec0;
            text-align: center;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .btn:hover {
            background: #4338ca;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hello {{ $user->name }},</h2>
        <p>
            🎉 We’re glad to let you know that new permissions have been assigned to your account.  
        </p>
        <p>
            You can now log in and make use of your updated access.
        </p>
        <a href="{{ url('/') }}" class="btn">Go to Dashboard</a>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Your System Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
