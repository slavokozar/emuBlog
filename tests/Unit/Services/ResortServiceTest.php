<?php

namespace Tests\Unit\Services;

use App\Models\County;
use App\Models\Resort;
use Facades\App\Services\FacilityService;
use Facades\App\Services\ImageService;
use Facades\App\Services\OpeningHourService;
use Facades\App\Services\ResortAdminService;
use Facades\App\Services\ResortService;
use Facades\App\Services\SportService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ResortServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;

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

        $this->data = [
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
        ];
    }

    public function testFacilities()
    {
        $resort = ResortService::create($this->data);
        $facility = FacilityService::create([
            'name' => 'toilet'
        ]);

        $resort = ResortService::addFacility($facility, $resort);
        self::assertTrue(count(ResortService::getFacilities($resort)) == 1);

        $resort = ResortService::removeFacility($facility, $resort);
        self::assertTrue(count(ResortService::getFacilities($resort)) == 0);

        $resort = ResortService::addFacility($facility, $resort);
        self::assertTrue(count(ResortService::getFacilities($resort)) == 1);

        $resort = ResortService::removeFacility($facility->id, $resort);
        self::assertTrue(count(ResortService::getFacilities($resort)) == 0);

        $resort = ResortService::addFacility($facility->id, $resort);
        FacilityService::delete($facility);
        self::assertTrue(count(ResortService::getFacilities($resort)) == 0);

        $facility = FacilityService::create([
            'name' => 'toilet'
        ]);

        $resort = ResortService::addFacility($facility, $resort);
        ResortService::delete($resort);
        self::assertTrue(count($facility->resorts) == 0);
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $resort = ResortService::create($this->data);
        $this->controlProperties($resort, $this->data);
        $this->controlResortInDB($resort);

        ResortService::delete($resort);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
            'name' => 'Admin',
        ];

        $result = ResortService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $resort = ResortService::create($this->data);
        $this->controlProperties($resort, $this->data);
        $this->controlResortInDB($resort);

        $resort = ResortService::update($resort, ['invoice_recipient' => 'emailko@sportemu.cz']);

        $newData = $this->data;
        $newData['invoice_recipient'] = 'emailko@sportemu.cz';

        $this->controlProperties($resort, $newData);
        $this->controlResortInDB($resort);

        ResortService::delete($resort);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $resort = ResortService::create($this->data);
        $this->controlProperties($resort, $this->data);
        $this->controlResortInDB($resort);

        $result = ResortService::update($resort, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $resort = ResortService::create($this->data);
        $this->controlProperties($resort, $this->data);
        $this->controlResortInDB($resort);
        $result = ResortService::delete($resort);
        self::assertTrue($result);
        $this->controlResortNotInDB($resort);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $resort = ResortService::create($this->data);
        $this->controlProperties($resort, $this->data);
        $this->controlResortInDB($resort);

        $getResort = ResortService::getByID($resort->id);
        $this->controlProperties($getResort, $this->data);
        ResortService::delete($getResort);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        ResortService::getByID(100000);
    }


    public function testResortSport()
    {
        $sport = SportService::create([
            'name' => 'football',
        ]);
        $resort = ResortService::create($this->data);

        $sports = ResortService::resortSports($resort);
        self::assertTrue(count($sports) == 0);

        $resort = ResortService::addSport($sport, $resort);
        $sports = ResortService::resortSports($resort);
        self::assertTrue(count($sports) == 1);


        $resort = ResortService::removeSport($sport, $resort);
        $sports = ResortService::resortSports($resort);
        self::assertTrue(count($sports) == 0);


        $resort = ResortService::addSport($sport->id, $resort);
        $sports = ResortService::resortSports($resort);
        self::assertTrue(count($sports) == 1);
        $resort = ResortService::removeSport($sport->id, $resort);
        $sports = ResortService::resortSports($resort);
        self::assertTrue(count($sports) == 0);

        $resort = ResortService::addSport($sport->id, $resort);
        ResortService::delete($sport);
        $sports = ResortService::resortSports($resort);
        self::assertTrue(count($sports) == 0);

        ResortService::delete($resort);
    }

    public function testOwner()
    {
        $user = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'Figura',
            'email'     => 'figura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figi',
            'role'      => 'ADMIN',
            'agreement' => true,
            'gender'    => 'MAN'
        ]);

        $resort = ResortService::create($this->data);

        ResortAdminService::create([
            'user_id'   => $user->id,
            'resort_id' => $resort->id,
            'owner'     => true
        ]);

        self::assertTrue(ResortService::isOwner($resort, $user));

        UserService::delete($user);

        self::assertFalse(ResortService::isOwner($resort, $user));

        $user = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'Figura',
            'email'     => 'figura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figi',
            'role'      => 'ADMIN',
            'agreement' => true,
            'gender'    => 'MAN'
        ]);

        ResortAdminService::create([
            'user_id'   => $user->id,
            'resort_id' => $resort->id,
            'owner'     => false
        ]);

        self::assertFalse(ResortService::isOwner($resort, $user));

        ResortService::delete($resort);
        self::assertTrue(count($user->resorts) == 0);
    }

    public function testImages()
    {
        $user = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'Figura',
            'email'     => 'figura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figi',
            'role'      => 'ADMIN',
            'agreement' => true,
            'gender'    => 'MAN'
        ]);

        $image = ImageService::create([
            'user_id' => $user->id,
            'name'    => 'Obrazok.jpg',
            'path'    => '/user/storage/media'
        ]);


        $resort = ResortService::create($this->data);
        self::assertTrue(count(ResortService::getImages($resort)) == 0);

        $resort = ResortService::addImage($image, $resort);

        self::assertTrue(count(ResortService::getImages($resort)) == 1);

        $resort = ResortService::removeImage($image, $resort);
        self::assertTrue(count(ResortService::getImages($resort)) == 0);

        $resort = ResortService::addImage($image->id, $resort);

        self::assertTrue(count(ResortService::getImages($resort)) == 1);

        $resort = ResortService::removeImage($image->id, $resort);
        self::assertTrue(count(ResortService::getImages($resort)) == 0);


        $resort = ResortService::addImage($image, $resort);
        ResortService::delete($resort);
        self::assertTrue(count($image->resorts) == 0);
    }

    public function testOpeningHours()
    {
        $openingHour = OpeningHourService::create([
            'start'   => '08:00:00',
            'end'     => '10:00:00',
            'weekday' => 2
        ]);
        $resort = ResortService::create($this->data);

        $resort = ResortService::addOpeningHour($openingHour, $resort);
        self::assertTrue(count(ResortService::getOpeningHours($resort)) == 1);

        $resort = ResortService::removeOpeningHour($openingHour, $resort);
        self::assertTrue(count(ResortService::getOpeningHours($resort)) == 0);

        $resort = ResortService::addOpeningHour($openingHour->id, $resort);
        self::assertTrue(count(ResortService::getOpeningHours($resort)) == 1);

        $resort = ResortService::removeOpeningHour($openingHour->id, $resort);
        self::assertTrue(count(ResortService::getOpeningHours($resort)) == 0);


        $resort = ResortService::addOpeningHour($openingHour, $resort);
        ResortService::delete($resort);
        self::assertTrue(count($openingHour->resorts) == 0);
    }


    /**
     * @param Resort $resort
     * @param array  $data
     */
    private function controlProperties($resort, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($resort->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Resort $resort
     */
    private function controlResortInDB($resort)
    {
        $this->assertDatabaseHas('sportemu_resorts', [
            'name'              => $resort->name,
            'invoice_recipient' => $resort->invoice_recipient,
            'description'       => $resort->description,
            'address_street'    => $resort->address_street,
            'address_zip'       => $resort->address_zip,
            'address_city'      => $resort->address_city,
            'address_county_id' => $resort->address_county_id,
            'contact_phone'     => $resort->contact_phone,
            'contact_email'     => $resort->contact_email,
            'address_latitude'  => $resort->address_latitude,
            'address_longitude' => $resort->address_longitude,
        ]);
    }

    /**
     * @param Resort $resort
     */
    private function controlResortNotInDB($resort)
    {
        $this->assertSoftDeleted('sportemu_resorts', [
            'name'              => $resort->name,
            'invoice_recipient' => $resort->invoice_recipient,
            'description'       => $resort->description,
            'address_street'    => $resort->address_street,
            'address_zip'       => $resort->address_zip,
            'address_city'      => $resort->address_city,
            'address_county_id' => $resort->address_county_id,
            'contact_phone'     => $resort->contact_phone,
            'contact_email'     => $resort->contact_email,
            'address_latitude'  => $resort->address_latitude,
            'address_longitude' => $resort->address_longitude,
        ]);
    }
}
