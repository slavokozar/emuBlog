<?php

namespace Tests\Unit\Services;

use App\Models\County;
use App\Models\FieldPrice;
use Facades\App\Services\FieldPriceService;
use Facades\App\Services\FieldService;
use Facades\App\Services\ResortService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FieldPriceServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;
    private $resort;
    private $field;

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

        $this->field = FieldService::create([
            'name'                    => 'Hriste 2',
            'resort_id'               => $this->resort->id,
            'max_advance_reservation' => 12,
        ]);

        $this->data = [
            'field_id' => $this->field->id,
            'period'   => 30,
            'price'    => 14.23,
            'start'    => '10:00:00',
            'end'      => '18:00:00',
            'weekday'  => 2
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $fieldPrice = FieldPriceService::create($this->data);
        $this->controlProperties($fieldPrice, $this->data);
        $this->controlFieldPriceInDB($fieldPrice);

        self::assertTrue($fieldPrice->field->id == $this->field->id);
        FieldPriceService::delete($fieldPrice);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
            'period' => 10,
        ];

        FieldPriceService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $fieldPrice = FieldPriceService::create($this->data);
        $this->controlProperties($fieldPrice, $this->data);
        $this->controlFieldPriceInDB($fieldPrice);

        $fieldPrice = FieldPriceService::update($fieldPrice, ['period' => 10]);

        $newData = $this->data;
        $newData['period'] = 10;

        $this->controlProperties($fieldPrice, $newData);
        $this->controlFieldPriceInDB($fieldPrice);

        FieldPriceService::delete($fieldPrice);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $fieldPrice = FieldPriceService::create($this->data);
        $this->controlProperties($fieldPrice, $this->data);
        $this->controlFieldPriceInDB($fieldPrice);

        $result = FieldPriceService::update($fieldPrice, ['period' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $fieldPrice = FieldPriceService::create($this->data);
        $this->controlProperties($fieldPrice, $this->data);
        $this->controlFieldPriceInDB($fieldPrice);
        $result = FieldPriceService::delete($fieldPrice);
        self::assertTrue($result);
        $this->controlFieldPriceNotInDB($fieldPrice);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $fieldPrice = FieldPriceService::create($this->data);
        $this->controlProperties($fieldPrice, $this->data);
        $this->controlFieldPriceInDB($fieldPrice);

        $getFieldPrice = FieldPriceService::getByID($fieldPrice->id);
        $this->controlProperties($getFieldPrice, $this->data);
        FieldPriceService::delete($getFieldPrice);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        FieldPriceService::getByID(100000);
    }

    public function testGetPrices()
    {
        self::assertTrue(count(FieldPriceService::getPrices($this->field)) == 0);

        $fieldPrice = FieldPriceService::create($this->data);
        $this->field = $this->field->fresh();

        self::assertTrue(count(FieldPriceService::getPrices($this->field)) > 0);

        self::assertTrue(count(FieldPriceService::getPricesDay($this->field, 2)) > 0);
        self::assertTrue(count(FieldPriceService::getPricesDay($this->field, 3)) == 0);

        self::assertTrue(count(FieldPriceService::getPriceDayHour($this->field, 2, '13:00')) != null);
        self::assertTrue(count(FieldPriceService::getPriceDayHour($this->field, 2, '08:00')) == null);
        self::assertTrue(count(FieldPriceService::getPriceDayHour($this->field, 4, '13:00')) == null);

        FieldPriceService::delete($fieldPrice);
    }

    /**
     * @param FieldPrice $fieldPrice
     * @param array      $data
     */
    private function controlProperties($fieldPrice, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($fieldPrice->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param FieldPrice $fieldPrice
     */
    private function controlFieldPriceInDB($fieldPrice)
    {
        $this->assertDatabaseHas('sportemu_fields_prices', [
            'field_id' => $fieldPrice->field_id,
            'period'   => $fieldPrice->period,
            'price'    => $fieldPrice->price,
            'start'    => $fieldPrice->start,
            'end'      => $fieldPrice->end,
            'weekday'  => $fieldPrice->weekday,
        ]);
    }

    /**
     * @param FieldPrice $fieldPrice
     */
    private function controlFieldPriceNotInDB($fieldPrice)
    {
        $this->assertSoftDeleted('sportemu_fields_prices', [
            'field_id' => $fieldPrice->field_id,
            'period'   => $fieldPrice->period,
            'price'    => $fieldPrice->price,
            'start'    => $fieldPrice->start,
            'end'      => $fieldPrice->end,
            'weekday'  => $fieldPrice->weekday,
        ]);
    }
}
