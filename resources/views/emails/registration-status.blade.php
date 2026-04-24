<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Update</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f7f6; }
        .container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: {{ $status === 'approved' ? '#2e7d32' : '#c62828' }}; color: #ffffff; padding: 40px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; letter-spacing: 1px; }
        .content { padding: 30px; text-align: center; }
        .ticket-box { background: #fcfcfc; border: 2px dashed #ddd; border-radius: 15px; padding: 25px; margin: 20px 0; position: relative; }
        .ticket-header { border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px; }
        .event-title { font-size: 20px; font-weight: bold; color: #1a1a1a; margin-bottom: 5px; }
        .event-info { font-size: 14px; color: #666; }
        .qr-code { margin: 20px 0; }
        .qr-code img { border: 1px solid #eee; padding: 10px; border-radius: 8px; background: white; }
        .status-badge { display: inline-block; padding: 8px 20px; border-radius: 25px; font-weight: bold; font-size: 14px; text-transform: uppercase; margin-bottom: 20px; }
        .status-approved { background: #e8f5e9; color: #2e7d32; }
        .status-rejected { background: #ffebee; color: #c62828; }
        .footer { background: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #999; }
        .btn { display: inline-block; padding: 12px 30px; background: #2e7d32; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://www.univ-eloued.dz/wp-content/uploads/2024/03/logouef.png" width="80" alt="University Logo" style="margin-bottom: 15px; filter: brightness(0) invert(1);">
            <h1>REGISTRATION UPDATE</h1>
        </div>
        
        <div class="content">
            <div class="status-badge {{ $status === 'approved' ? 'status-approved' : 'status-rejected' }}">
                {{ $status === 'approved' ? 'ACCEPTED ✅' : 'REJECTED ❌' }}
            </div>
            
            <p>Hello <strong>{{ $user->name }}</strong>,</p>
            <p>Your registration request for <strong>{{ $registration->event->title }}</strong> has been updated.</p>

            @if($status === 'approved')
                <div class="ticket-box">
                    <div class="ticket-header">
                        <div class="event-title">{{ $registration->event->title }}</div>
                        <div class="event-info">
                            {{ $registration->event->date_time->format('M d, Y') }} | {{ $registration->event->location }}
                        </div>
                    </div>
                    
                    <div class="qr-code">
                        <img src="{{ $message->embedData(base64_decode($qrCode), 'qrcode.svg', 'image/svg+xml') }}" width="150" alt="Ticket QR Code">
                    </div>
                    
                    <div style="font-size: 12px; color: #888;">
                        Ticket ID: #{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}
                    </div>
                </div>
                
                <p><strong>Great news!</strong> Your ticket is ready. We have attached the official PDF version to this email for your records.</p>
                <a href="{{ url('/dashboard') }}" class="btn">View in Dashboard</a>
            @else
                <p style="color: #666; margin: 30px 0;">We regret to inform you that we cannot accommodate your registration for this event at this time.</p>
                @if($registration->admin_note)
                    <div style="background: #f5f5f5; padding: 15px; border-radius: 8px; font-style: italic; color: #555;">
                        "{{ $registration->admin_note }}"
                    </div>
                @endif
                <p>Feel free to check out other upcoming events on our portal.</p>
            @endif
        </div>
        
        <div class="footer">
            <p>Official Event Management System - University of El Oued</p>
            <p>&copy; {{ date('Y') }} All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
