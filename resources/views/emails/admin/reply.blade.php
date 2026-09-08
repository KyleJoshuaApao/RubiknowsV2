<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; line-height: 1.6; color: #18181b;">

    <!-- Background wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f5; padding: 40px 15px;">
        <tr>
            <td align="center">
                
                <!-- Email Container -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 650px; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                    
                    <!-- Header with Logo -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 30px; background-color: #ffffff; border-bottom: 3px solid #E0A92A;">
                            <div style="font-size: 44px; font-weight: 900; letter-spacing: -1px; text-transform: uppercase; line-height: 1; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ $message->embed(public_path('RK3-email.png')) }}" alt="RK3" style="height: 100px; vertical-align: middle; margin-right: 20px;">
                                <div style="display: inline-block; vertical-align: middle; margin-top: 25px;">
                                    <span style="color: #18181b; font-weight: 300;">RUBI</span><span style="color: #E0A92A;">KNOWS</span>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <!-- Title & Intro -->
                    <tr>
                        <td style="padding: 40px 40px 20px; background-color: #ffffff;">
                            <h1 style="margin: 0 0 10px 0; color: #18181b; font-size: 22px; font-weight: 800; letter-spacing: -0.5px;">Hello {{ $recipientName }},</h1>
                            <p style="margin: 0; color: #52525b; font-size: 16px; line-height: 1.6;">
                                You have received a new message from our team regarding your recent inquiry.
                            </p>
                        </td>
                    </tr>

                    <!-- Message Block -->
                    <tr>
                        <td style="padding: 0 40px 30px; background-color: #ffffff;">
                            <div style="background-color: #f8fafc; border-left: 4px solid #E07B2A; padding: 25px; font-size: 16px; color: #3f3f46; line-height: 1.7; border-radius: 0 4px 4px 0;">
                                {!! nl2br(e($replyText)) !!}
                            </div>
                        </td>
                    </tr>

                    <!-- Call to Action -->
                    <tr>
                        <td align="left" style="padding: 10px 40px 50px; background-color: #ffffff;">
                            <p style="margin: 0 0 5px 0; font-size: 15px; font-weight: 600; color: #18181b;">Best regards,</p>
                            <p style="margin: 0; font-size: 15px; color: #52525b;">{{ $senderName ?: 'The RubiKnows Team' }}</p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #18181b; text-align: center;">
                            <p style="margin: 0 0 10px 0; font-size: 12px; font-weight: 600; color: #a1a1aa; text-transform: uppercase; letter-spacing: 1px;">
                                RubiKnows Engineering & Construction
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #71717a;">
                                Please reply directly to this email if you have any further questions.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
