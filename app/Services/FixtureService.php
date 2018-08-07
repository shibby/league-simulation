<?php

namespace App\Services;

use App\Models\Match;
use App\Models\Team;
use ScheduleBuilder;

class FixtureService
{
    public function generateFixture(): void
    {
        $teamCount = Team::count();
        $teams = Team::get();

        $teamIds = Team::inRandomOrder()->pluck('id')->toArray();
        $scheduleBuilder = new ScheduleBuilder($teamIds);
        $schedule = $scheduleBuilder->build();

        foreach ($schedule as $week => $matches) {
            foreach ($matches as $match) {
                $this->createMatch(
                    $week,
                    $teams->where('id', $match[0])->first(),
                    $teams->where('id', $match[1])->first()
                );
            }
        }

        $this->generateAwayFixture($teamCount);
    }

    private function createMatch(int $week, Team $teamHome, Team $teamAway): Match
    {
        $match = new Match();
        $match->week = $week;
        $match->team1_id = $teamHome->id;
        $match->team2_id = $teamAway->id;
        $match->save();

        return $match;
    }

    private function generateAwayFixture(int $teamCount): void
    {
        $matches = Match::all();
        \DB::beginTransaction();
        foreach ($matches as $match) {
            $newMatch = new Match();
            $newMatch->week = $match->week + ($teamCount - 1);
            $newMatch->team1_id = $match->team2_id;
            $newMatch->team2_id = $match->team1_id;
            $newMatch->save();
        }
        \DB::commit();
    }

//    public function generateFixturePerWeek(): void
//    {
//        $teamCount = Team::count();
//
//        for ($i = 1; $i < $teamCount; ++$i) {
//            $this->generateWeek($teamCount, $i);
//        }
//
//        $this->generateAwayFixture($teamCount);
//    }

//    public function generateWeek(int $teamCount, int $week): void
//    {
//        $matchPerWeek = $teamCount / 2;
//        \Log::debug('Week Selected: '.$week.' - There will be '.$matchPerWeek.' matches');
//
//        $selectedTeamsForWeek = [];
//
//        for ($i = 1; $i <= $matchPerWeek; ++$i) {
//            /** @var Team $teamHome */
//            $teamHome = Team::inRandomOrder()->whereNotIn('id', $selectedTeamsForWeek)->first();
//            $selectedTeamsForWeek[] = $teamHome->id;
//            \Log::debug('Team-Home: '.$teamHome->id);
//
//            $teamAway = $this->findOppositeForTeam($teamHome, $selectedTeamsForWeek);
//            $selectedTeamsForWeek[] = $teamAway->id;
//            \Log::debug('Team-Away: '.$teamAway->id);
//            \Log::debug($teamHome->id.'-'.$teamAway->id);
//
//            $this->createMatch($week, $teamHome, $teamAway);
//        }
//    }

//    private function findOppositeForTeam(Team $teamHome, array $selectedTeamsForWeek): Team
//    {
//        return Team::whereNotIn('id', $selectedTeamsForWeek)
//            ->whereRaw('NOT EXISTS (SELECT `matches`.`id` FROM `matches` WHERE (`team1_id` = ? AND `team2_id` = `teams`.`id`) OR (`team2_id` = ? AND `team1_id` = `teams`.`id`))')
//            ->addBinding($teamHome->id)
//            ->addBinding($teamHome->id)
//            ->first();
//    }
}
