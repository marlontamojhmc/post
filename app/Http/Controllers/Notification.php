<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\UserActivityNotification;
use App\Events\HelloTest;

class Notification extends Controller
{
    public function notify()
    {   
        $user = auth()->user(); // user to receive notification
        $message = "mascara";
        $user->notify(new UserActivityNotification('Your request was approved!', '/requests/123'));
        HelloTest::dispatch($message, $user);
        return response()->json([
            'message' => 'Notification sent successfully'
        ]);
    }
}