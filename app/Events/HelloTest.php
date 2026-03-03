<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;

class HelloTest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $post; // Public property for broadcast

    public function __construct(array $post)
    {
        $this->post = $post;
        
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('hello-test'), // Public channel
        ];
    }
}