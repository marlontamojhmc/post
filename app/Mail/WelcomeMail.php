<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class WelcomeMail extends Mailable
{
    public $name;
    public $resetUrl;
    public $appName;
    public $logoUrl;
    public $expiresIn;

    public function __construct($name, $resetUrl)
    {
        $this->name = $name;
        $this->resetUrl = $resetUrl;
        $this->appName = config('app.name');
        $this->logoUrl = asset('images/logo.png');
        $this->expiresIn = '60 minutes';
    }

    public function build()
    {
        return $this->view('emails.welcome')
            ->subject('Your New Account to Sezris is requesting You To Reset Your Password...');
    }
}