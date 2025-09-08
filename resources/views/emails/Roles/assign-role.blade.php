<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Role Assigned</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #2c3e50;">Hello {{ $user->name }},</h2>

        <p style="font-size: 16px; color: #333;">
            You have been assigned a new role in the system. 🎉
        </p>

        <p style="font-size: 16px; color: #333;">
            <strong>Email:</strong> {{ $user->email }} <br>
            <strong>Assigned Role:</strong> 
            @if($user->roles && $user->roles->count() > 0)
                {{ $user->roles->pluck('name')->join(', ') }}
            @else
                No role assigned yet.
            @endif
        </p>

        <p style="margin-top: 20px; font-size: 14px; color: #888;">
            Regards,<br>
            The Admin Team
        </p>
    </div>
</body>
</html>
