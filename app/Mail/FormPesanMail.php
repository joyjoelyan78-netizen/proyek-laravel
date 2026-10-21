<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormPesanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pesan Baru dari Website: ' . ($this->data['subjek'] ?? 'Formulir Website'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.form_pesan',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}