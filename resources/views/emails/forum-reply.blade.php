<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Forum Reply</title>
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

        .notification-badge {
            background-color: #0057A7;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin: 10px 0;
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

        .topic-info {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #0057A7;
        }

        .reply-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }

        .replier-info {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
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

        .quote {
            background-color: #f8f9fa;
            border-left: 4px solid #dee2e6;
            padding: 15px;
            margin: 15px 0;
            font-style: italic;
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Forum Reply</h1>
            <p>Someone has replied to your topic</p>
        </div>

        <div style="text-align: center;">
            <span class="notification-badge">New Reply</span>
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
        </div>

        <div class="topic-info">
            <h3>Your Topic</h3>
            <div class="detail-row">
                <span class="detail-label">Title:</span>
                <span class="detail-value">{{ $topic->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Posted:</span>
                <span
                    class="detail-value">{{ \Carbon\Carbon::parse($topic->created_at)->format('M d, Y \a\t g:i A') }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    @if ($topic->is_resolved)
                        <span style="color: #28a745; font-weight: bold;">Resolved</span>
                    @else
                        <span style="color: #ffc107; font-weight: bold;">Open</span>
                    @endif
                </span>
            </div>
        </div>

        <div class="replier-info">
            <h3>Reply From</h3>
            <div class="detail-row">
                <span class="detail-label">Name:</span>
                <span class="detail-value">{{ $replier->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Role:</span>
                <span class="detail-value">{{ ucfirst($replier->role) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Replied:</span>
                <span
                    class="detail-value">{{ \Carbon\Carbon::parse($reply->created_at)->format('M d, Y \a\t g:i A') }}</span>
            </div>
        </div>

        <div class="reply-content">
            <h3>Reply Content</h3>
            <div class="quote">
                {!! nl2br(e($reply->content)) !!}
            </div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('forum.show', ['eventId' => $event->id, 'topicId' => $topic->id]) }}" class="button">View
                Full Discussion</a>
        </div>

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <h4>Quick Actions</h4>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Read the full reply and other responses</li>
                <li>Reply to continue the discussion</li>
                @if ($topic->user_id == auth()->id() || auth()->user()->role == 'organizer')
                    <li>Mark a reply as the solution if your question is answered</li>
                @endif
                <li>Stay engaged with the event community</li>
            </ul>
        </div>

        <div class="footer">
            <p><strong>EventHub Forum</strong></p>
            <p>Stay connected with other event participants and organizers.</p>
            <p>Thank you for being part of our community!</p>
        </div>
    </div>
</body>

</html>
