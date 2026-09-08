<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Quotation Request - RubiKnows</title>
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
                            <h1 style="margin: 0 0 10px 0; color: #18181b; font-size: 24px; font-weight: 800; letter-spacing: -0.5px;">New Quotation Request</h1>
                            <p style="margin: 0; color: #52525b; font-size: 16px; line-height: 1.6;">
                                A potential client has submitted a request for a project quotation via the website.
                            </p>
                        </td>
                    </tr>

                    <!-- Information Grid -->
                    <tr>
                        <td style="padding: 10px 40px 30px; background-color: #ffffff;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fafafa; border: 1px solid #e4e4e7; border-radius: 6px;">
                                <tr>
                                    <td width="50%" valign="top" style="padding: 25px; border-right: 1px solid #e4e4e7; border-bottom: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Client Name</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #18181b;">{{ $quotation->name }}</div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 25px; border-bottom: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Service Needed</div>
                                        <div style="font-size: 16px; font-weight: 600; color: #18181b;">{{ $quotation->service_needed }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" valign="top" style="padding: 25px; border-right: 1px solid #e4e4e7; border-bottom: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Email Address</div>
                                        <div style="font-size: 15px; font-weight: 500;">
                                            <a href="mailto:{{ $quotation->email }}" style="color: #E07B2A; text-decoration: none;">{{ $quotation->email }}</a>
                                        </div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 25px; border-bottom: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Project Location</div>
                                        <div style="font-size: 15px; font-weight: 500; color: #18181b;">{{ $quotation->project_location }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" valign="top" style="padding: 25px; border-right: 1px solid #e4e4e7; border-bottom: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Company</div>
                                        <div style="font-size: 15px; font-weight: 500; color: #18181b;">{{ $quotation->company ?: 'N/A' }}</div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 25px; border-bottom: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Estimated Budget</div>
                                        <div style="font-size: 15px; font-weight: 500; color: #18181b;">{{ $quotation->budget ?: 'N/A' }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" valign="top" style="padding: 25px; border-right: 1px solid #e4e4e7;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Phone Number</div>
                                        <div style="font-size: 15px; font-weight: 500; color: #18181b;">{{ $quotation->phone ?: 'N/A' }}</div>
                                    </td>
                                    <td width="50%" valign="top" style="padding: 25px;">
                                        <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;">Project Timeline</div>
                                        <div style="font-size: 15px; font-weight: 500; color: #18181b;">{{ $quotation->timeline ?: 'N/A' }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Description Block -->
                    <tr>
                        <td style="padding: 0 40px 30px; background-color: #ffffff;">
                            <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Project Description</div>
                            <div style="background-color: #ffffff; border-left: 4px solid #18181b; padding: 15px 20px; font-size: 15px; color: #3f3f46; line-height: 1.7;">
                                {!! nl2br(e($quotation->description)) !!}
                            </div>
                        </td>
                    </tr>

                    <!-- Attachments Notice -->
                    @if($quotation->attachment_path)
                    <tr>
                        <td style="padding: 0 40px 30px; background-color: #ffffff;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 15px;">
                                <tr>
                                    <td width="30" valign="top" style="font-size: 18px;">📎</td>
                                    <td style="font-size: 14px; color: #92400e;">
                                        <strong>Attachment available:</strong> The client has securely uploaded a reference file. You can download it directly from the admin dashboard.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif

                    <!-- Call to Action -->
                    <tr>
                        <td align="center" style="padding: 10px 40px 50px; background-color: #ffffff;">
                            <a href="{{ url('/admin/quotations/' . $quotation->id) }}" style="display: inline-block; background-color: #18181b; color: #ffffff; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; text-decoration: none; padding: 18px 40px; border-radius: 4px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                View Quotation Request in Dashboard
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #18181b; text-align: center;">
                            <p style="margin: 0 0 10px 0; font-size: 12px; font-weight: 600; color: #a1a1aa; text-transform: uppercase; letter-spacing: 1px;">
                                RubiKnows Engineering & Construction
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #71717a;">
                                This is an automated notification from the RubiKnows quoting system.<br>
                                Please do not reply directly to this email.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
