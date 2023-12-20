<?php
namespace XMalla\XUser\Event;

use XMalla\XCore\Model\Term;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    protected $states = [
        0 => "inactive",1 => "activated",2 => "locked",3 => "legal"        
    ];

    public function __construct( $user ) {
        $this->user = $user;        
        (new Term)->tax("user-counter", "saved")->increment("counter");
    }
}
