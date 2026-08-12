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

    public function __construct(
        public string $message,
        public User $user
    ) {
        $this->notificationCount = $user->unreadNotifications()->count();
    }

    public int $notificationCount;

    public function broadcastOn(): array
    {
        return [
            new Channel('hello-test'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'notificationCount' => $this->notificationCount,
        ];
    }
}