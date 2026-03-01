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

    // Public property will be sent to frontend
    public string $message;

    /**
     * Create a new event instance.
     */
    public function __construct(string $message = 'Hello from Laravel!')
    {
        $this->message = $message;

        // Optional: log to see if event fires
        logger('HelloTest fired: ' . $this->message);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('hello-test'),
        ];
    }
}