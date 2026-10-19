<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $event;
    protected $pdfPath;

    public function __construct(Participant $participant, Event $event, string $pdfPath)
    {
        $this->participant = $participant;
        $this->event = $event;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificado Oficial - ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->pdfPath)
                ->as('Certificado_' . str_replace(' ', '_', $this->participant->full_name) . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}