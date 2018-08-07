<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Match;
use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * @var TeamService
     */
    private $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function getTeamsAction(Request $request)
    {
        $teams = $this->teamService->getTeams();

        return new TeamResource($teams);
    }

    public function deleteTeamsAction()
    {
        Match::truncate();
        Team::truncate();

        return response(null, 204);
    }

    public function postTeamsAction(Request $request)
    {
        $teamCount = $request->request->getInt('teamCount');

        factory(Team::class, $teamCount)->create();

        return response()->json([
            'success' => true,
        ]);
    }
}
