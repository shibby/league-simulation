<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
    public function getTeams(): Collection
    {
        return Team::orderBy('f_pts', 'DESC')
            ->orderBy('f_gd', 'DESC')
            ->get();
    }
}
