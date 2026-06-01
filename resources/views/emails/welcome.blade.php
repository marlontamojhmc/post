<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f6f9;padding:30px 15px;">
        <tr>
            <td align="center">

                <!-- Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td align="center" style="background:#0f172a;padding:30px;">
                            <img src="{{ $logoUrl }}"
                                alt="{{ $appName }}"
                                style="max-width:120px;height:auto;display:block;margin-bottom:15px;">

                            <h1 style="margin:0;color:#ffffff;font-size:28px;font-weight:bold;">
                                {{ $appName }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding:40px 35px;color:#334155;">

                            <h2 style="margin-top:0;color:#1e293b;">
                                Password Reset Request
                            </h2>

                            <p style="font-size:16px;line-height:1.7;">
                                Hello <strong>{{ $name }}</strong>,
                            </p>

                            <p style="font-size:16px;line-height:1.7;">
                                We received a request to reset the password associated with your account.
                                Click the button below to choose a new password.
                            </p>

                            <!-- Button -->
                            <table cellpadding="0" cellspacing="0" border="0" align="center" style="margin:35px auto;">
                                <tr>
                                    <td align="center"
                                        style="border-radius:6px;background-color:#2563eb;">
                                        <a href="{{ $resetUrl }}"
                                            style="display:inline-block;padding:14px 28px;color:#ffffff;text-decoration:none;font-size:16px;font-weight:bold;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size:15px;line-height:1.7;">
                                If the button above does not work, copy and paste the following URL into your browser:
                            </p>

                            <p style="background:#f8fafc;padding:12px;border-radius:6px;word-break:break-all;font-size:14px;color:#2563eb;">
                                {{ $resetUrl }}
                            </p>

                            <p style="font-size:15px;line-height:1.7;">
                                This password reset link will expire in
                                <strong>{{ $expiresIn ?? '60 minutes' }}</strong>.
                            </p>

                            <p style="font-size:15px;line-height:1.7;">
                                If you did not request a password reset, you can safely ignore this email.
                                No changes will be made to your account.
                            </p>

                            <hr style="border:none;border-top:1px solid #e2e8f0;margin:30px 0;">

                            <p style="font-size:15px;line-height:1.7;margin-bottom:0;">
                                Regards,<br>
                                <strong>{{ $appName }} Team</strong>
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="background:#f8fafc;padding:20px;color:#64748b;font-size:13px;">

                            © {{ date('Y') }} {{ $appName }}. All Rights Reserved.

                            <br><br>

                            This is an automated email. Please do not reply directly to this message.

                        </td>
                    </tr>

                </table>
                <!-- End Container -->

            </td>
        </tr>
    </table>

</body>
</html>