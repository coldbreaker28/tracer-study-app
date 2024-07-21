<?php

namespace App\Events;

use App\Models\Acara;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AcaraCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $acara;

    public function __construct(Acara $acara)
    {
        //
        $this->acara = $acara;
    }

    public function broadcastOn()
    {
        return new Channel('acara');
    }

    // public function broadcastAs(): string
    // {
    //     # code...
    //     return 'acara.created';
    // }

    public function broadcastWith()
    {
        # code...
        return [
            'acara' => $this->acara,
        ];
    }
}
