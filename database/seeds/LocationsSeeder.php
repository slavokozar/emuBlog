<?php

use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = include_once 'locations.php';

        foreach ($locations as $country => $regions) {
            $countryObj = \App\Models\Country::create([
                'name' => $country
            ]);

            foreach ($regions as $region => $counties) {

                $regionObj = \App\Models\Region::create([
                    'name'     => $region,
                    'country_id' => $countryObj->id
                ]);

                foreach ($counties as $county) {

                    \App\Models\County::create([
                        'name'      => $county,
                        'region_id' => $regionObj->id
                    ]);
                }
            }
        }
    }
}
