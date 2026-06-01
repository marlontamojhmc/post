<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
class TestController extends Controller
{
   public function sendEmail()
{
    $resetUrl = url('/settings/password');

    Mail::to('marlontamo.jhmc@gmail.com')
        ->send(new WelcomeMail('MarlonTamo', $resetUrl));

    return 'Email sent successfully';
}
}
