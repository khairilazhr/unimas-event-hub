<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Status Update</title>
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
            background-color: #fff;
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

        .status-banner {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 18px;
            font-weight: bold;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .event-details,
        .ticket-info,
        .refund-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .event-details h2,
        .ticket-info h3,
        .refund-info h3 {
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
            <h1>Refund Status Update</h1>
            <p>Your refund request status has been updated.</p>
        </div>
        <div class="status-banner status-{{ $status }}">
            @if ($status === 'approved')
                Your refund has been <strong>APPROVED</strong>!
            @else
                Your refund has been <strong>REJECTED</strong>
            @endif
        </div>
        <div class="event-details">
            <h2>Event Information</h2>
            <div class="detail-row"><span class="detail-label">Event Name:</span><span
                    class="detail-value">{{ $event->name }}</span></div>
            <div class="detail-row"><span class="detail-label">Date & Time:</span><span
                    class="detail-value">{{ \Carbon\Carbon::parse($event->date)->format('l, jS F Y \a\t g:i A') }}</span>
            </div>
            <div class="detail-row"><span class="detail-label">Location:</span><span
                    class="detail-value">{{ $event->location }}</span></div>
        </div>
        <div class="ticket-info">
            <h3>Ticket Details</h3>
            <div class="detail-row"><span class="detail-label">Type:</span><span
                    class="detail-value">{{ $ticket->type }}</span></div>
            <div class="detail-row"><span class="detail-label">Section:</span><span
                    class="detail-value">{{ $ticket->section }}</span></div>
            <div class="detail-row"><span class="detail-label">Row:</span><span
                    class="detail-value">{{ $ticket->row }}</span></div>
            <div class="detail-row"><span class="detail-label">Seat:</span><span
                    class="detail-value">{{ $ticket->seat }}</span></div>
            <div class="detail-row"><span class="detail-label">Price:</span><span
                    class="detail-value">RM{{ number_format($ticket->price, 2) }}</span></div>
        </div>
        <div class="refund-info">
            <h3>Refund Details</h3>
            <div class="detail-row"><span class="detail-label">Refund Amount:</span><span
                    class="detail-value">RM{{ number_format($refund->refund_amount, 2) }}</span></div>
            <div class="detail-row"><span class="detail-label">Reason:</span><span
                    class="detail-value">{{ $refund->refund_reason }}</span></div>
            @if ($refund->notes)
                <div class="detail-row"><span class="detail-label">Notes:</span><span
                        class="detail-value">{{ $refund->notes }}</span></div>
            @endif
            <div class="detail-row"><span class="detail-label">Status:</span><span
                    class="detail-value">{{ ucfirst($refund->status) }}</span></div>
            <div class="detail-row"><span class="detail-label">Requested At:</span><span
                    class="detail-value">{{ $refund->created_at->format('M d, Y \a\t g:i A') }}</span></div>
            <div class="detail-row"><span class="detail-label">Updated At:</span><span
                    class="detail-value">{{ $refund->updated_at->format('M d, Y \a\t g:i A') }}</span></div>
        </div>
        <div class="footer">
            <p><strong>EventHub</strong></p>
            <p>If you have any questions, please contact the event organizer or our support team.</p>
            <p>Thank you for using EventHub!</p>
        </div>
    </div>
</body>

</html>
