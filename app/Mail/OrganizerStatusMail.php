<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Organizer;

class OrganizerStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $organizer;
    public $status;

    public function __construct(Organizer $organizer, string $status)
    {
        $this->organizer = $organizer;
        $this->status = $status;
    }

    public function envelope(): Envelope
    {
        $subject = $this->status === 'approved' 
            ? 'Pendaftaran Organizer Disetujui: Selamat Datang di AmikomEventHub!' 
            : 'Pembaruan Status Pendaftaran Organizer: ' . ucfirst($this->status);

        return new Envelope(
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.organizer-status',
        );
    }
}
