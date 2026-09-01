<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset your password</title>
</head>
<body style="margin:0; padding:24px; font-family: Arial, sans-serif; background:#f6f8fb; color:#1f2937;">
    <div style="max-width:560px; margin:0 auto; background:#ffffff; border-radius:8px; padding:32px; box-shadow:0 2px 10px rgba(15, 23, 42, 0.06);">
        <h2 style="margin-top:0; margin-bottom:16px; color:#0f172a;">Reset your password</h2>

        <p style="margin:0 0 16px; line-height:1.6;">
            Hello {{ $firstName ?? 'there' }},
        </p>

        <p style="margin:0 0 16px; line-height:1.6;">
            We received a request to reset the password for your ESI International Projects Portal account.
            Use the link below to choose a new password.
        </p>

        <p style="margin:0 0 24px; line-height:1.6;">
            <a href="{{ $resetUrl }}" style="display:inline-block; background:#1d4ed8; color:#ffffff; text-decoration:none; padding:12px 20px; border-radius:6px; font-weight:bold;">
                Reset password
            </a>
        </p>

        <p style="margin:0 0 8px; line-height:1.6;">
            If you did not request this change, you can safely ignore this email.
        </p>

        <p style="margin:0; line-height:1.6; color:#475569;">
            This link will expire in 1 hour.
        </p>
    </div>
</body>
</html>
