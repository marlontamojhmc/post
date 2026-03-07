<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class HelloTest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message = "";
    public int $notificationCount = 0;

    public function __construct(string $message, User $user)
    {
        $this->message = $message;

        // Get the user's unread notification count
        $this->notificationCount = $user->notifications()->count();
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('hello-test'),
        ];
    }
}