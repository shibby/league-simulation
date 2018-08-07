<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    public $timestamps = false;

    protected $casts = [
        'has_been_played' => 'boolean',
        'week' => 'integer',
        'team1_id' => 'integer',
        'team2_id' => 'integer',
        'team1_score' => 'integer',
        'team2_score' => 'integer',
    ];

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }
}
