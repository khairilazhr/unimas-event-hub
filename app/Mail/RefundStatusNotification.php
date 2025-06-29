<?php
namespace App\Mail;

use App\Models\Refunds;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RefundStatusNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $refund;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct(Refunds $refund, string $status)
    {
        $this->refund = $refund;
        $this->status = $status;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved'
        ? 'Refund Approved - ' . $this->refund->eventRegistration->event->name
        : 'Refund Update - ' . $this->refund->eventRegistration->event->name;

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.refund-status',
            with: [
                'refund' => $this->refund,
                'event'  => $this->refund->eventRegistration->event,
                'ticket' => $this->refund->ticket,
                'user'   => $this->refund->user,
                'status' => $this->status,
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
