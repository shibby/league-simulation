<?php

namespace App\Services;

use App\Events\MatchPlayedEvent;
use App\Models\Match;
use App\Models\Team;
use App\Util\RandomizerUtil;
use Illuminate\Database\Eloquent\Collection;

class MatchService
{
    /**
     * @param int $week
     *
     * @return Collection|Match[]
     */
    public function getWeeklyMatches(int $week): Collection
    {
        return Match::where('week', $week)
            ->with([
                'team1',
                'team2',
            ])
            ->get();
    }

    public function playMatch(Match $match)
    {
        $team1 = $match->team1;
        $team2 = $match->team2;

        $predictions = $this->getPredictions($team1, $team2);

        $winner = RandomizerUtil::weightedRandom(array_keys($predictions), array_values($predictions));
        $score = $this->generateScore($winner);

        $match->team1_score = $score[0];
        $match->team2_score = $score[1];
        $match->has_been_played = true;
        $match->save();

        event(new MatchPlayedEvent($match));
    }

    private function getPredictions(Team $team1, Team $team2): array
    {
        $predictions = [
            'team1' => 36,
            'team2' => 32,
            'draw' => 34,
        ];

        if ($team1->fans_count > $team2->fans_count) {
            $predictions['team1'] += 8;
            $predictions['team2'] -= 4;
            $predictions['draw'] -= 4;
        } elseif ($team1->fans_count < $team2->fans_count) {
            // takım1 evsahibi olduğu için oran daha az düşüyo, tersi duruma göre.
            $predictions['team1'] -= 6;
            $predictions['team2'] += 3;
            $predictions['draw'] += 3;
        }

        $team1Point = $team1->f_pts;
        $team2Point = $team2->f_pts;

        if ($team1Point !== $team2Point) {
            $predictions['team1'] += $team1Point;
            $predictions['team2'] += $team2Point;
        }

        return $predictions;
    }

    private function generateScore(string $winner): array
    {
        $team1Score = random_int(0, 4);
        $team2Score = 0;
        if ('draw' === $winner) {
            $team2Score = $team1Score;
        } elseif ('team1' === $winner) {
            if (0 === $team1Score) {
                ++$team1Score;
            }
            $team2Score = random_int(0, $team1Score - 1);
        } elseif ('team2' === $winner) {
            --$team1Score;
            if ($team1Score < 0) {
                $team1Score = 0;
            }
            $team2Score = random_int($team1Score + 1, $team1Score + 2);
        }

        return [
            $team1Score,
            $team2Score,
        ];
    }
}
