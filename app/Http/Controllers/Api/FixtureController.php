<?php

namespace App\Http\Controllers\Api;

use App\Models\Match;
use App\Models\Team;
use App\Services\FixtureService;
use App\Http\Controllers\Controller;

class FixtureController extends Controller
{
    /**
     * @var FixtureService
     */
    private $fixtureService;

    public function __construct(FixtureService $fixtureService)
    {
        $this->fixtureService = $fixtureService;
    }

    public function postGenerateFixtureAction()
    {
        $this->fixtureService->generateFixture();

        return response()->json([
            'success' => true,
        ]);
    }

    public function deleteFixtureAction()
    {
        Match::truncate();
        Team::query()->update([
            'f_pts' => null,
            'f_w' => null,
            'f_d' => null,
            'f_l' => null,
            'f_gd' => null,
        ]);

        return response(null, 204);
    }
}
