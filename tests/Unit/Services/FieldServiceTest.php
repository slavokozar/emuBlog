<?php

namespace Tests\Unit\Services;

use App\Models\County;
use App\Models\Field;
use Facades\App\Services\FieldService;
use Facades\App\Services\OpeningHourService;
use Facades\App\Services\ResortService;
use Facades\App\Services\SportService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FieldServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;
    private $resort;

    protected function setUp()
    {
        parent::setUp();

        $stateObj = \App\Models\Country::create([
            'name' => 'Slovenská republika'
        ]);

        $regionObj = \App\Models\Region::create([
            'name'     => 'Banskobystrický kraj',
            'state_id' => $stateObj->id
        ]);

        $county = \App\Models\County::create([
            'name'      => 'Banská Bystrica',
            'region_id' => $regionObj->id
        ]);

        $this->resort = ResortService::create([
            'name'              => 'Olšanka sports center',
            'invoice_recipient' => "recipient@hotelolsanka.cz",
            'description'       => "The Olšanka sports center offers more than 10 sport facilities under one roof for the general public. Our goal is to offer you comfortable facilities and a friendly approach by our trained staff for your active rest and relaxation. In an area of more than 2,500 m 2 you can find a gym, group lessons, table tennis, massage, sauna and aqua aerobics. The most popular features are a 25 meter swimming pool and 4 badminton courts in the indoor hall. An excellent price for single admission as well as a wide range of discounted seasonal/multiuse tickets is offered to all.",
            'address_street'    => "Táboritská 23/1000",
            'address_zip'       => "13000",
            'address_city'      => "Prague 3- Žižkov",
            'address_county_id' => $county->id,
            'contact_phone'     => "+420 267 092 448",
            'contact_email'     => "contact@hotelolsanka.cz",
            'address_latitude'  => 50.0828074,
            'address_longitude' => 14.4549493,
        ]);

        $this->data = [
            'name'                    => 'Hriste 2',
            'resort_id'               => $this->resort->id,
            'max_advance_reservation' => 12,
        ];
    }


    /**
     * @return void
     */
    public function testCreate()
    {
        $field = FieldService::create($this->data);
        $this->controlProperties($field, $this->data);
        $this->controlFieldInDB($field);

        self::assertTrue(count($this->resort->fields) == 1);
        self::assertTrue($field->resort->id == $this->resort->id);

        ResortService::delete($this->resort);
        $this->controlFieldNotInDB($field);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
            'name' => 'hriste 3',
        ];

        $result = FieldService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $field = FieldService::create($this->data);
        $this->controlProperties($field, $this->data);
        $this->controlFieldInDB($field);

        $field = FieldService::update($field, ['name' => 'ihriskoooo']);

        $newData = $this->data;
        $newData['name'] = 'ihriskoooo';

        $this->controlProperties($field, $newData);
        $this->controlFieldInDB($field);

        FieldService::delete($field);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $field = FieldService::create($this->data);
        $this->controlProperties($field, $this->data);
        $this->controlFieldInDB($field);

        $result = FieldService::update($field, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $field = FieldService::create($this->data);
        $this->controlProperties($field, $this->data);
        $this->controlFieldInDB($field);
        $result = FieldService::delete($field);
        self::assertTrue($result);
        $this->controlFieldNotInDB($field);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $field = FieldService::create($this->data);
        $this->controlProperties($field, $this->data);
        $this->controlFieldInDB($field);

        $getField = FieldService::getByID($field->id);
        $this->controlProperties($getField, $this->data);
        FieldService::delete($getField);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        FieldService::getByID(100000);
    }


    public function testFieldSport()
    {
        $sport = SportService::create([
            'name' => 'football',
        ]);
        $field = FieldService::create($this->data);

        $sports = FieldService::fieldSports($field);
        self::assertTrue(count($sports) == 0);

        $field = FieldService::addSport($sport, $field);
        $sports = FieldService::fieldSports($field);
        self::assertTrue(count($sports) == 1);


        $field = FieldService::removeSport($sport, $field);
        $sports = FieldService::fieldSports($field);
        self::assertTrue(count($sports) == 0);

        $field = FieldService::addSport($sport->id, $field);
        $sports = FieldService::fieldSports($field);
        self::assertTrue(count($sports) == 1);


        $field = FieldService::removeSport($sport->id, $field);
        $sports = FieldService::fieldSports($field);
        self::assertTrue(count($sports) == 0);


        $field = FieldService::addSport($sport, $field);
        FieldService::delete($field);
        self::assertTrue(count($sport->fields) == 0);
    }

    /**
     * @param Field $field
     * @param array $data
     */
    private function controlProperties($field, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($field->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Field $field
     */
    private function controlFieldInDB($field)
    {
        $this->assertDatabaseHas('sportemu_fields', [
            'name'                    => $field->name,
            'resort_id'               => $field->resort_id,
            'max_advance_reservation' => $field->max_advance_reservation,
        ]);
    }

    /**
     * @param Field $field
     */
    private function controlFieldNotInDB($field)
    {
        $this->assertSoftDeleted('sportemu_fields', [
            'name'                    => $field->name,
            'resort_id'               => $field->resort_id,
            'max_advance_reservation' => $field->max_advance_reservation,
        ]);
    }
}
