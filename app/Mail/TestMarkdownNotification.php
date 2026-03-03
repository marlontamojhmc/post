<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TestMarkdownNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Login to SezadRIS',
        );
    }

    public function content(): Content
    {
        $loginUrl = URL::temporarySignedRoute(
            'magic.login',
            now()->addMinutes(30),
            ['user' => $this->user->id]
        );

        return new Content(
            markdown: 'emails.test',
            with: [
                'user' => $this->user,
                'loginUrl' => $loginUrl,
            ],
        );
    }
}