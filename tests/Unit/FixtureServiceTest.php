<?php

namespace Tests\Unit;

use App\Models\Match;
use App\Models\Team;
use App\Services\FixtureService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FixtureServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function test_generate_fixture()
    {
        $teamCount = Team::count();
        $this->assertEquals(4, $teamCount, 'There should be 4 teams');

        /** @var FixtureService $service */
        $service = app(FixtureService::class);
        $this->assertEquals(0, Match::count(), 'There is no match has been fixtured yet.');

        $service->generateFixture();

        $this->assertEquals(($teamCount / 2) * ($teamCount - 1) * 2, Match::count(), 'There sould be well enough match.');
    }

    public function test_generate_fixture_wih_18_team()
    {
        factory(Team::class, 14)->create();
        $teamCount = Team::count();

        $this->assertEquals(18, $teamCount, 'There should be 18 teams');
        /** @var FixtureService $service */
        $service = app(FixtureService::class);
        $this->assertEquals(0, Match::count(), 'There is no match has been fixtured yet.');

        $service->generateFixture();

        $this->assertEquals(($teamCount / 2) * ($teamCount - 1) * 2, Match::count(), 'There sould be well enough match.');
    }
}
