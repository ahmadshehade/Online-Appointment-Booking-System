<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>
<body>
    <p>Hello,</p>

    <p>You have requested to reset your account password. Click the link below to reset it:</p>

    <p>
        <a href="{{ $resetLink }}">{{ $resetLink }}</a>
    </p>

    <p>If you did not request a password reset, no further action is required.</p>

    <p>Thank you,</p>
    <p>Support Team</p>
</body>
</html>
