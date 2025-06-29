<?php
namespace App\Mail;

use App\Models\ForumReply;
use App\Models\ForumTopic;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ForumReplyNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $topic;
    public $event;

    /**
     * Create a new message instance.
     */
    public function __construct(ForumReply $reply, ForumTopic $topic)
    {
        $this->reply = $reply;
        $this->topic = $topic;
        $this->event = $topic->event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Reply to: ' . $this->topic->title,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.forum-reply',
            with: [
                'reply'   => $this->reply,
                'topic'   => $this->topic,
                'event'   => $this->event,
                'replier' => $this->reply->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
