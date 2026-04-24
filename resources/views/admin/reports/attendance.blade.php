<!DOCTYPE html>
<html>
<head>
    <title>Attendance List - {{ $event->title }}</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2e7d32; padding-bottom: 10px; }
        .event-info { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 50px; text-align: right; font-size: 0.8em; color: #777; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8em; background: #e8f5e9; color: #2e7d32; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="color: #2e7d32; margin-bottom: 5px;">University of El Oued</h2>
        <h3 style="margin-top: 0;">Official Attendance List</h3>
    </div>

    <div class="event-info">
        <p><strong>Event:</strong> {{ $event->title }}</p>
        <p><strong>Type:</strong> {{ $event->type }}</p>
        <p><strong>Speaker:</strong> {{ $event->speaker_name }}</p>
        <p><strong>Date:</strong> {{ $event->date_time->format('M d, Y') }} at {{ $event->date_time->format('h:i A') }}</p>
        <p><strong>Location:</strong> {{ $event->location }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="40%">Full Name</th>
                <th width="25%">University ID</th>
                <th width="20%">Role</th>
                <th width="10%">Signature</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $index => $reg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reg->user->name }}</td>
                    <td>{{ $reg->user->university_id }}</td>
                    <td style="text-transform: capitalize;">{{ $reg->user->role }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on {{ now()->format('M d, Y - h:i A') }}</p>
        <p>Event Management System - ElOued University</p>
    </div>
</body>
</html>
