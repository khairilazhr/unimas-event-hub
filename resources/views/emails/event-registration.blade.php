<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0057A7;
        }

        .header h1 {
            color: #0057A7;
            margin: 0;
            font-size: 24px;
        }

        .event-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .event-details h2 {
            color: #0057A7;
            margin-top: 0;
            font-size: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .detail-label {
            font-weight: bold;
            color: #495057;
        }

        .detail-value {
            color: #6c757d;
        }

        .ticket-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0057A7;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0057A7;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }

        .button:hover {
            background-color: #003d75;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Registration Confirmed!</h1>
            <p>Thank you for registering for our event</p>
        </div>

        <div class="event-details">
            <h2>Event Information</h2>
            <div class="detail-row">
                <span class="detail-label">Event Name:</span>
                <span class="detail-value">{{ $event->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date & Time:</span>
                <span
                    class="detail-value">{{ \Carbon\Carbon::parse($event->date)->format('l, jS F Y \a\t g:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Location:</span>
                <span class="detail-value">{{ $event->location }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Organizer:</span>
                <span class="detail-value">{{ $event->organizer_name }}</span>
            </div>
        </div>

        <div class="ticket-info">
            <h3>Your Ticket Details</h3>
            <div class="detail-row">
                <span class="detail-label">Ticket Type:</span>
                <span class="detail-value">{{ $ticket->type }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Section:</span>
                <span class="detail-value">{{ $ticket->section }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Row:</span>
                <span class="detail-value">{{ $ticket->row }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Seat:</span>
                <span class="detail-value">{{ $ticket->seat }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Price:</span>
                <span class="detail-value">RM{{ number_format($ticket->price, 2) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Registration Status:</span>
                <span class="detail-value">
                    <span class="status-badge status-{{ $registration->status }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </span>
            </div>
        </div>

        <div style="margin: 20px 0;">
            <h3>Registration Details</h3>
            <div class="detail-row">
                <span class="detail-label">Attendee Name:</span>
                <span class="detail-value">{{ $registration->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $registration->email }}</span>
            </div>
            @if ($registration->phone)
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $registration->phone }}</span>
                </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Registration ID:</span>
                <span class="detail-value">#{{ $registration->id }}</span>
            </div>
        </div>

        @if ($registration->status === 'pending')
            <div
                style="background-color: #fff3cd; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ffc107;">
                <h4>⚠️ Payment Verification Required</h4>
                <p>Your registration is pending payment verification. Once your payment is verified by the organizer,
                    your ticket will be approved.</p>
            </div>
        @endif

        @if ($registration->status === 'approved')
            <div
                style="background-color: #d4edda; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #28a745;">
                <h4>✅ Ticket Approved</h4>
                <p>Your ticket has been approved! You can now access your ticket details and QR code from your
                    dashboard.</p>
            </div>
        @endif

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('user.events.my-bookings') }}" class="button">View My Bookings</a>
        </div>

        <div class="footer">
            <p><strong>EventHub</strong></p>
            <p>If you have any questions, please contact the event organizer or our support team.</p>
            <p>Thank you for choosing EventHub!</p>
        </div>
    </div>
</body>

</html>
