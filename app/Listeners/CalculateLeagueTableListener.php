<?php

namespace App\Listeners;

use App\Events\MatchPlayedEvent;
use App\Models\Match;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;

class CalculateLeagueTableListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param MatchPlayedEvent $event
     */
    public function handle(MatchPlayedEvent $event)
    {
        $match = $event->getMatch();

        \DB::beginTransaction();
        $this->calculatePoints($match->team1);
        $this->calculatePoints($match->team2);

        $this->calculateGoals($match->team1);
        $this->calculateGoals($match->team2);
        \DB::commit();
    }

    private function calculatePoints(Team $team)
    {
        $threePts = Match::where(function (Builder $m) use ($team) {
            $m->where('team1_id', $team->id)
                ->whereRaw('team1_score > team2_score');
        })->orWhere(function (Builder $m) use ($team) {
            $m->where('team2_id', $team->id)
                ->whereRaw('team2_score > team1_score');
        })
            ->where('has_been_played', true)
            ->count();
        $onePts = Match::where(function (Builder $m) use ($team) {
            $m->where('team1_id', $team->id)
                ->orWhere('team2_id', $team->id)
                ;
        })
            ->whereRaw('team1_score = team2_score')
            ->where('has_been_played', true)
            ->count();
        $teamMatchCount = Match::where(function (Builder $m) use ($team) {
            $m->where('team1_id', $team->id)
                ->orWhere('team2_id', $team->id)
                ;
        })
            ->where('has_been_played', true)
            ->count();

        $team->f_w = $threePts;
        $team->f_d = $onePts;
        $team->f_l = $teamMatchCount - ($threePts + $onePts);
        $team->f_pts = $threePts * 3 + $onePts * 1;
        $team->save();
    }

    private function calculateGoals(Team $team)
    {
        $goal1 = Match::where('team1_id', $team->id)
            ->sum('team1_score');
        $goal2 = Match::where('team2_id', $team->id)
            ->sum('team2_score');

        //opposite goal
        $goal3 = Match::where('team1_id', $team->id)
            ->sum('team2_score');
        $goal4 = Match::where('team2_id', $team->id)
            ->sum('team1_score');

        $team->f_gd = ($goal1 + $goal2) - ($goal3 + $goal4);
        $team->save();
    }
}
