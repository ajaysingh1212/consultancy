<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification - EemoTrack</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0; background:#f3f4f6;">
        <tr>
            <td align="center">

                <!-- Main Card -->
                <table width="500" cellpadding="0" cellspacing="0"
                       style="background:#ffffff; border-radius:12px; padding:40px; box-shadow:0 10px 25px rgba(0,0,0,0.05);">

                    <!-- Logo / Title -->
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <h2 style="margin:0; color:#7c3aed; font-size:24px;">
                                🔐 EemoTrack Email Verification
                            </h2>
                        </td>
                    </tr>

                    <!-- Greeting -->
                    <tr>
                        <td style="color:#374151; font-size:16px; padding-bottom:15px;">
                            Hello,
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td style="color:#4b5563; font-size:15px; line-height:22px; padding-bottom:20px;">
                            You requested to verify your email address:
                            <br>
                            <strong style="color:#111827;">
                                {{ $email }}
                            </strong>
                        </td>
                    </tr>

                    <!-- OTP Box -->
                    <tr>
                        <td align="center" style="padding:25px 0;">
                            <div style="
                                display:inline-block;
                                background:#f5f3ff;
                                border:2px dashed #7c3aed;
                                border-radius:10px;
                                padding:20px 40px;
                                font-size:32px;
                                font-weight:bold;
                                letter-spacing:8px;
                                color:#6d28d9;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>

                    <!-- Expiry -->
                    <tr>
                        <td align="center"
                            style="color:#6b7280; font-size:14px; padding-bottom:20px;">
                            ⏳ This OTP will expire in 5 minutes.
                        </td>
                    </tr>

                    <!-- Warning -->
                    <tr>
                        <td style="color:#6b7280; font-size:13px; line-height:20px;">
                            If you did not request this verification,
                            please ignore this email.
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="padding:30px 0 10px 0;">
                            <hr style="border:none; border-top:1px solid #e5e7eb;">
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="color:#9ca3af; font-size:12px;">
                            © {{ date('Y') }} EemoTrack. All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
