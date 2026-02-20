<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Email Verification - EemoTrack</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4ff; font-family:Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:50px 15px;">
<tr>
<td align="center">

    <!-- Main Container -->
    <table width="520" cellpadding="0" cellspacing="0"
           style="background:#ffffff; border-radius:16px; overflow:hidden;
                  box-shadow:0 15px 35px rgba(0,0,0,0.08);">

        <!-- Header -->
        <tr>
            <td style="background:#FAF0E7; padding:30px 25px;">
                
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="160" valign="middle">
                            <img src="logo.png"
                                 alt="EemoTrack Logo"
                                 style="width:140px; height:auto; display:block;">
                        </td>

                        <td valign="middle" style="padding-left:20px; color:#111827;">
                            <h1 style="margin:0; font-size:20px; font-weight:600;">
                                Verify Your Email
                            </h1>
                            <p style="margin:5px 0 0 0; font-size:13px; color:#6b7280;">
                                Secure your account
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding:45px 40px; color:#030303; background:#ffffff;">

                <p style="margin:0 0 15px 0; font-size:18px; font-weight:600;">
                    Hello,
                </p>

                <p style="margin:0 0 25px 0; font-size:15px; line-height:24px; color:#4b5563;">
                    We received a request to verify your email address:
                </p>

                <p style="margin:0 0 30px 0; font-size:15px;">
                    <strong style="color:#111827;">
                        {{-- {{ $email }} --}}
                        mansy@gmail.com
                    </strong>
                </p>

                <!-- OTP Button -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <a href="#"
                               style="
                               background:#7c3aed;
                               color:#ffffff;
                               text-decoration:none;
                               padding:16px 50px;
                               font-size:24px;
                               font-weight:bold;
                               letter-spacing:8px;
                               border-radius:8px;
                               display:inline-block;">
                                {{-- {{ $otp }} --}}
                                123456
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="text-align:center; font-size:14px; color:#6b7280; margin:25px 0;">
                    ⏳ This OTP will expire in <strong>5 minutes</strong>.
                </p>

                <p style="font-size:13px; color:#6b7280; line-height:20px; margin:0;">
                    If you didn’t request this verification, you can safely ignore this email.
                </p>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background:#FAF0E7; padding:25px 20px;" align="center">

                <p style="margin:0 0 15px 0; font-size:14px; font-weight:600; color:#111827;">
                    Stay Connected with EEMOT OVERSEAS RECRUITMENT
                </p>

                <!-- Social Icons -->
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding:0 8px;">
                            <a href="https://facebook.com">
                                <img src="https://img.freepik.com/premium-vector/round-facebook-logo-isolated-white-background_469489-897.jpg?semt=ais_user_personalization&w=740&q=80"
                                     width="26" alt="Facebook" style="display:block;">
                            </a>
                        </td>

                        <td style="padding:0 8px;">
                            <a href="https://instagram.com">
                                <img src="https://img.freepik.com/free-psd/instagram-application-logo_23-2151544100.jpg?semt=ais_user_personalization&w=740&q=80"
                                     width="26" alt="Instagram" style="display:block;">
                            </a>
                        </td>

                        <td style="padding:0 8px;">
                            <a href="https://yourwebsite.com">
                                <img src="https://yourdomain.com/icons/website.png"
                                     width="26" alt="Website" style="display:block;">
                            </a>
                        </td>
                    </tr>
                </table>

                <p style="margin:20px 0 5px 0; font-size:12px; color:#111827;">
                    © {{ date('Y') }} EEMOT OVERSEAS RECRUITMENT. All rights reserved.
                </p>

                <p style="margin:5px 0 0 0; font-size:11px; color:#6b7280;">
                    This is an automated message. Please do not reply.
                </p>

                <hr style="border:none; border-top:1px solid #e5e7eb; margin:20px 0; width:80%;">

                <!-- Disclaimer -->
                <p style="margin:0; font-size:10px; line-height:16px; color:#9ca3af;">
                    <strong>Disclaimer:</strong> This email and any attachments are confidential 
                    and intended solely for the individual to whom they are addressed. 
                    If you have received this email in error, please notify the sender immediately 
                    and delete it from your system. EEMOT OVERSEAS RECRUITMENT 
                    is not responsible for any unauthorized use, disclosure, or modification of this email.
                </p>

            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>