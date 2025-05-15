<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AnalyticsUpdated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $analytics;

    public function __construct($analytics)
    {
        $this->analytics = $analytics;
    }

    public function broadcastOn()
    {
        return new Channel('analytics');
    }

    public function broadcastWith()
    {
        return ['analytics' => $this->analytics];
    }
}
