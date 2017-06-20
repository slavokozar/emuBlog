<?php

namespace Tests\Unit\Services;

use App\Models\County;
use App\Models\ResortAdmin;
use Facades\App\Services\ResortAdminService;
use Facades\App\Services\ResortService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ResortAdminServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;
    private $user;
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

        $this->user = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'Figura',
            'email'     => 'figura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figi',
            'role'      => 'ADMIN',
            'agreement' => true,
            'gender'    => 'MAN'
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
            'user_id'   => $this->user->id,
            'resort_id' => $this->resort->id,
            'owner'     => false
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $resortAdmin = ResortAdminService::create($this->data);

        $this->controlProperties($resortAdmin, $this->data);
        $this->controlResortAdminInDB($resortAdmin);

        self::assertTrue($resortAdmin->user->id == $this->user->id);
        self::assertTrue($resortAdmin->resort->id == $this->resort->id);
        ResortAdminService::delete($resortAdmin);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
            'user_id' => null,
        ];

        $result = ResortAdminService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $resortAdmin = ResortAdminService::create($this->data);
        $this->controlProperties($resortAdmin, $this->data);
        $this->controlResortAdminInDB($resortAdmin);

        $resortAdmin = ResortAdminService::update($resortAdmin, ['owner' => true]);

        $newData = $this->data;
        $newData['owner'] = true;

        $this->controlProperties($resortAdmin, $newData);
        $this->controlResortAdminInDB($resortAdmin);

        ResortAdminService::delete($resortAdmin);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $resortAdmin = ResortAdminService::create($this->data);
        $this->controlProperties($resortAdmin, $this->data);
        $this->controlResortAdminInDB($resortAdmin);

        $result = ResortAdminService::update($resortAdmin, ['user_id' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $resortAdmin = ResortAdminService::create($this->data);
        $this->controlProperties($resortAdmin, $this->data);
        $this->controlResortAdminInDB($resortAdmin);
        $result = ResortAdminService::delete($resortAdmin);
        self::assertTrue($result);
        $this->controlResortAdminNotInDB($resortAdmin);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $resortAdmin = ResortAdminService::create($this->data);
        $this->controlProperties($resortAdmin, $this->data);
        $this->controlResortAdminInDB($resortAdmin);

        $getResortAdmin = ResortAdminService::getByID($resortAdmin->id);
        $this->controlProperties($getResortAdmin, $this->data);
        ResortAdminService::delete($getResortAdmin);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        ResortAdminService::getByID(100000);
    }

    /**
     * @return void
     */
    public function testChangeOwner()
    {
        $resortAdmin = ResortAdminService::create($this->data);
        $this->controlProperties($resortAdmin, $this->data);
        $this->controlResortAdminInDB($resortAdmin);

        $resortAdmin = ResortAdminService::makeOwner($this->resort, $this->user);

        self::assertTrue($resortAdmin->owner);
        self::assertTrue(count(ResortAdminService::owners($this->resort)) > 0);

        $resortAdmin = ResortAdminService::removeOwner($this->resort, $this->user);

        self::assertFalse($resortAdmin->owner);
        self::assertTrue(count(ResortAdminService::owners($this->resort)) == 0);

        ResortAdminService::delete($resortAdmin);
    }

    /**
     * @param ResortAdmin $resortAdmin
     * @param array       $data
     */
    private function controlProperties($resortAdmin, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($resortAdmin->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param ResortAdmin $resortAdmin
     */
    private function controlResortAdminInDB($resortAdmin)
    {
        $this->assertDatabaseHas('sportemu_resorts_admins', [
            'user_id'   => $resortAdmin->user_id,
            'resort_id' => $resortAdmin->resort_id,
            'owner'     => $resortAdmin->owner
        ]);
    }

    /**
     * @param ResortAdmin $resortAdmin
     */
    private function controlResortAdminNotInDB($resortAdmin)
    {
        $this->assertDatabaseMissing('sportemu_resorts_admins', [
            'user_id'   => $resortAdmin->user_id,
            'resort_id' => $resortAdmin->resort_id,
            'owner'     => $resortAdmin->owner
        ]);
    }
}
