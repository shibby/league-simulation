<?php

namespace App\Events;

use App\Models\Match;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class MatchPlayedEvent
{
    use Dispatchable, SerializesModels;
    /**
     * @var Match
     */
    private $match;

    /**
     * Create a new event instance.
     */
    public function __construct(Match $match)
    {
        $this->match = $match;
    }

    /**
     * @return Match
     */
    public function getMatch(): Match
    {
        return $this->match;
    }
}
