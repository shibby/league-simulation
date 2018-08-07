<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;

    protected $casts = [
        'f_w' => 'integer',
        'f_d' => 'integer',
        'f_l' => 'integer',
        'f_gd' => 'integer',
        'f_pts' => 'integer',
        'fans_count' => 'integer',
    ];
}
