<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class CertificateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $participant;
    public $event;
    public $pdfPath;

    public function __construct($participant, $event, $pdfPath)
    {
        $this->participant = $participant;
        $this->event = $event;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Certificado - ' . $this->event->title,
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
                ->as('Certificado.pdf')
                ->withMime('application/pdf'),
        ];
    }
}