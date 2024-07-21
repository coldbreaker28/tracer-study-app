<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notifikasi implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    // public $slug;
    /**
     * Create a new event instance.
     *
     * @param string $slug
     * @return void
     */
    public function __construct()
    {
        //
        $this->message = "Acara baru sudah diunggah!";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notifikasi-channel');
    }
    /**
     * Get the name of the broadcast event.
     *
     * @return string
     */
    public function broadcastAs()
    {
        # code...
        return 'notifikasi-event';
    }
}