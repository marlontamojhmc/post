<?php namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InitialMail extends Mailable
{
    public $name;
    public $resetUrl;
    public $appName;
    public $expiresIn;
    public $tempPassword;

    

    public function __construct($name, $resetUrl, $tempPassword,$email)
    {
        $this->name = $name;
        $this->resetUrl = $resetUrl;
        $this->tempPassword = $tempPassword;
        $this->appName = config('app.name');
        $this->expiresIn = '60 minutes';
        $this->toEmail = $email;

    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your New Account - Password Setup Required'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.initial',
            with: [
            'email' => $this->toEmail ?? null,
        ]
        );
    }
}