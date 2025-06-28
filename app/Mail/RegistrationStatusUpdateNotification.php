<?php
namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationStatusUpdateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $status;
    public $action;

    /**
     * Create a new message instance.
     */
    public function __construct(EventRegistration $registration, string $status)
    {
        $this->registration = $registration;
        $this->status       = $status;
        $this->action       = $status === 'approved' ? 'approved' : 'rejected';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved'
        ? 'Registration Approved - ' . $this->registration->event->name
        : 'Registration Update - ' . $this->registration->event->name;

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
            view: 'emails.registration-status-update',
            with: [
                'registration' => $this->registration,
                'event'        => $this->registration->event,
                'ticket'       => $this->registration->ticket,
                'status'       => $this->status,
                'action'       => $this->action,
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
