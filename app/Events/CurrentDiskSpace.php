<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CurrentDiskSpace implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $byte_size, $human_size, $percentage, $downloading;

    /**
     * Create a new event instance.
     *
     * @param $human_size
     * @param $percentage
     */
    public function __construct($human_size, $percentage, $downloading)
    {
        $this->human_size = $human_size;
        $this->percentage = $percentage;
        $this->downloading = $downloading;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('disk.space');
    }
}
