<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Event Ticket - {{ $registration->event->title }}</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; margin: 0; padding: 40px; background-color: #f8fafc; }
        .ticket-container { width: 500px; margin: 0 auto; background: white; border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0; }
        .header { background-color: #2e7d32; padding: 30px; text-align: center; color: white; }
        .logo-box { background: white; padding: 10px; display: inline-block; border-radius: 10px; margin-bottom: 15px; }
        .serial { background: rgba(0,0,0,0.2); display: inline-block; padding: 5px 15px; border-radius: 20px; font-size: 12px; margin-top: 10px; border: 1px solid rgba(255,255,255,0.3); }
        .content { padding: 30px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .label { color: #64748b; font-size: 10px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .value { color: #0f172a; font-size: 16px; font-weight: bold; margin-bottom: 20px; }
        .stub { background-color: #f1f5f9; padding: 30px; text-align: center; border-top: 2px dashed #cbd5e1; }
        .qr-box { background: white; padding: 10px; display: inline-block; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 15px; }
        .footer-text { color: #64748b; font-size: 10px; line-height: 1.4; }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <div class="logo-box">
                <img src="https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef-png.avif" width="60" alt="Logo">
            </div>
            <div style="font-weight: bold; font-size: 20px;">OFFICIAL EVENT PASS</div>
            <div class="serial">#{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}-{{ strtoupper(substr($registration->user->name, 0, 2)) }}</div>
        </div>

        <div class="content">
            <table class="info-table">
                <tr>
                    <td width="50%">
                        <div class="label">Attendee Name</div>
                        <div class="value">{{ $registration->user->name }}</div>
                        <div style="font-size: 10px; color: #64748b; margin-top: -15px;">{{ $registration->user->university_id }}</div>
                    </td>
                    <td width="50%">
                        <div class="label">University Role</div>
                        <div class="value" style="color: #2e7d32;">{{ ucfirst($registration->user->role) }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="label">Venue Location</div>
                        <div class="value">{{ $registration->event->location }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="label">Event Schedule</div>
                        <div class="value">{{ $registration->event->date_time->format('M d, Y') }} at {{ $registration->event->date_time->format('h:i A') }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="stub">
            <div class="qr-box">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="120" alt="QR Code">
            </div>
            <div class="label" style="margin-bottom: 10px;">SCAN FOR OFFICIAL ENTRY</div>
            <p class="footer-text">This ticket is electronically generated and verified via the Official University Event Management System.</p>
            <div style="font-weight: bold; font-size: 11px; margin-top: 10px;">VALID FOR ONE ENTRY ONLY</div>
            <div style="font-size: 9px; color: #94a3b8; margin-top: 15px; border-top: 1px solid #e2e8f0; pt: 10px;">Issued: {{ now()->format('Y-m-d H:i') }}</div>
        </div>
    </div>
</body>
</html>
