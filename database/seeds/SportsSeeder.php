<?php

use App\Models\Sport;
use Illuminate\Database\Seeder;

class SportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sport::create([
            'name' => 'football'
        ]);

        Sport::create([
            'name' => 'badminton'
        ]);

        Sport::create([
            'name' => 'tennis'
        ]);

        Sport::create([
            'name' => 'golf'
        ]);
    }
}
