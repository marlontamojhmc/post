<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InitialMail;
class TestController extends Controller
{
  public function sendEmail()
{
    $resetUrl = url('/settings/password');

    $to = 'marlontamo.jhmc@gmail.com';
    $temPass = 'Abc-123-)(*';
    Mail::to($to)
        ->send(new InitialMail('MarlonTamo', $resetUrl,$temPass, $to));

    return 'Email sent successfully to: ' . $to;
}
}
