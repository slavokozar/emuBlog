<?php

use App\Models\Sport;
use Facades\App\Services\ResortService;
use Illuminate\Database\Seeder;

class ResortsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resort1 = ResortService::create([
            'name' => 'Olšanka sports center',
            'description'       => "The Olšanka sports center offers more than 10 sport facilities under one roof for the general public. Our goal is to offer you comfortable facilities and a friendly approach by our trained staff for your active rest and relaxation. In an area of more than 2,500 m 2 you can find a gym, group lessons, table tennis, massage, sauna and aqua aerobics. The most popular features are a 25 meter swimming pool and 4 badminton courts in the indoor hall. An excellent price for single admission as well as a wide range of discounted seasonal/multiuse tickets is offered to all.",
            'address_street'    => "Táboritská 23/1000",
            'address_zip'       => "13000",
            'address_city'      => "Prague 3- Žižkov",
            'address_county_id' => get_random_ids_for_model(\App\Models\County::class)[0],
            'contact_phone'     => "+420 267 092 448",
            'contact_email'     => "contact@hotelolsanka.cz",
            'address_latitude'  => 50.0828074,
            'address_longitude' => 14.4549493,

        ]);


        $resort1->sports()->attach([1, 2, 3, 4]);

        $resort2 = ResortService::create([
            'name' => 'Sportcentrum Step',
            'description'       => "SPORTCENTRUM STEP je moderně vybavený komplex, který nabízí široké spektrum sportovních a relaxačních služeb pod jednou střechou v městské části Praha – 9 Vysočany. ",
            'address_street'    => "Malletova 2350",
            'address_zip'       => "19000",
            'address_city'      => "Praha 9",
            'address_county_id' => get_random_ids_for_model(\App\Models\County::class)[0],
            'contact_phone'     => "+420 296 786 177",
            'contact_email'     => "contact@sportcentrum.com",
            'address_latitude'  => 50.10,
            'address_longitude' => 14.48,

        ]);

        $resort2->sports()->attach([2, 3]);
    }
}
