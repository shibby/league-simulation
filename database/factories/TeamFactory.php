<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Team::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'fans_count' => random_int(1000000, 5000000),
        'f_pts' => 0,
        'f_w' => 0,
        'f_d' => 0,
        'f_l' => 0,
        'f_gd' => 0,
    ];
});
