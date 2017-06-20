<?php

namespace Tests\Unit\Services;

use App\Models\CancelPolicy;
use App\Models\County;
use Facades\App\Services\CancelPolicyService;
use Facades\App\Services\FieldService;
use Facades\App\Services\ResortService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CancelPolicyServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data, $field, $resort;

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
            'address_longitude' => 14.4549493
        ]);

        $this->field = FieldService::create([
            'name'                    => 'Hriste 2',
            'resort_id'               => $this->resort->id,
            'max_advance_reservation' => 12,
        ]);


        $this->data = [
            'field_id' => $this->field->id,
            'until'    => 10,
            'refund'   => 85.5
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $cancelPolicy = CancelPolicyService::create($this->data);
        $this->controlProperties($cancelPolicy, $this->data);
        $this->controlCancelPolicyInDB($cancelPolicy);

        self::assertTrue($cancelPolicy->field->id == $this->field->id);
        self::assertTrue(count($this->field->cancel_policies) == 1);

        self::assertTrue(CancelPolicyService::delete($cancelPolicy));
        $this->field = $this->field->fresh();
        self::assertTrue(count($this->field->cancel_policies) == 0);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        CancelPolicyService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $cancelPolicy = CancelPolicyService::create($this->data);
        $this->controlProperties($cancelPolicy, $this->data);
        $this->controlCancelPolicyInDB($cancelPolicy);

        $cancelPolicy = CancelPolicyService::update($cancelPolicy, ['until' => '20']);

        $newData = $this->data;
        $newData['until'] = 20;

        $this->controlProperties($cancelPolicy, $newData);
        $this->controlCancelPolicyInDB($cancelPolicy);

        CancelPolicyService::delete($cancelPolicy);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $cancelPolicy = CancelPolicyService::create($this->data);
        $this->controlProperties($cancelPolicy, $this->data);
        $this->controlCancelPolicyInDB($cancelPolicy);

        CancelPolicyService::update($cancelPolicy, ['until' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $cancelPolicy = CancelPolicyService::create($this->data);
        $this->controlProperties($cancelPolicy, $this->data);
        $this->controlCancelPolicyInDB($cancelPolicy);
        $result = CancelPolicyService::delete($cancelPolicy);
        self::assertTrue($result);
        $this->controlCancelPolicyNotInDB($cancelPolicy);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $cancelPolicy = CancelPolicyService::create($this->data);
        $this->controlProperties($cancelPolicy, $this->data);
        $this->controlCancelPolicyInDB($cancelPolicy);

        $getCancelPolicy = CancelPolicyService::getByID($cancelPolicy->id);
        $this->controlProperties($getCancelPolicy, $this->data);
        CancelPolicyService::delete($getCancelPolicy);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        CancelPolicyService::getByID(100000);
    }

    /**
     * @param CancelPolicy $cancelPolicy
     * @param array        $data
     */
    private function controlProperties($cancelPolicy, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($cancelPolicy->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param CancelPolicy $cancelPolicy
     */
    private function controlCancelPolicyInDB($cancelPolicy)
    {
        $this->assertDatabaseHas('sportemu_cancel_policies', [
            'field_id' => $cancelPolicy->field_id,
            'until'    => $cancelPolicy->until,
            'refund'   => $cancelPolicy->refund,
        ]);
    }

    /**
     * @param CancelPolicy $cancelPolicy
     */
    private function controlCancelPolicyNotInDB($cancelPolicy)
    {
        $this->assertSoftDeleted('sportemu_cancel_policies', [
            'field_id' => $cancelPolicy->field_id,
            'until'    => $cancelPolicy->until,
            'refund'   => $cancelPolicy->refund,
        ]);
    }
}
