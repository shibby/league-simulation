<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(\App\Models\Team::class, 2)->create();
        factory(\App\Models\Team::class, 2)->create([
            'is_rival' => true,
        ]);
    }
}
