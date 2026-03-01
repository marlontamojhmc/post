<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HelloTest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $message; // Public property for broadcast

    public function __construct(string $message = 'Hello from Laravel!')
    {
        $this->message = $message;
        logger('HelloTest fired: ' . $this->message);
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('hello-test'), // Public channel
        ];
    }
}