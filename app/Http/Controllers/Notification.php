<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\UserActivityNotification;
use App\Events\HelloTest;

class Notification extends Controller
{
    public function notify(Request $request)
    {
        // $request->validate([
        //     'message' => ['required', 'string', 'max:255'],
        // ]);

        $user = auth()->user();
      
        $message = $request->message;

        $user->notify(
            new UserActivityNotification(
                $message,
                '/requests/123'
            )
        );

        HelloTest::dispatch($message, $user);

        return response()->json([
            'success' => true,
            'message' => 'Notification sent successfully',
            'user' => $user,
            
        ]);
    }
}