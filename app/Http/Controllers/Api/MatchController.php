<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MatchResource;
use App\Services\MatchService;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * @var MatchService
     */
    private $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    public function getWeeklyMatchesAction(Request $request, int $week)
    {
        $matches = $this->matchService->getWeeklyMatches($week);

        return new MatchResource($matches);
    }

    public function postPlayWeeklyMatchAction(int $week)
    {
        $matches = $this->matchService->getWeeklyMatches($week);

        foreach ($matches as $match) {
            $this->matchService->playMatch($match);
        }

        return response()->json([
            'success' => true,
        ]);
    }
}
