<?php

namespace Tests\Unit\Services;

use App\Models\County;
use App\Models\Image;
use Facades\App\Services\ImageService;
use Facades\App\Services\ResortService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $user;
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

        $this->data = [
            'user_id' => $this->user->id,
            'name'    => 'Obrazok.jpg',
            'path'    => '/user/storage/media'
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $image = ImageService::create($this->data);
        $this->controlProperties($image, $this->data);
        $this->controlImageInDB($image);

        self::assertTrue($image->user->id == $this->user->id);
        self::assertTrue(count($this->user->images) == 1);

        ImageService::delete($image);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
            'name' => 'Hahahaha',
        ];

        $result = ImageService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $image = ImageService::create($this->data);
        $this->controlProperties($image, $this->data);
        $this->controlImageInDB($image);

        $image = ImageService::update($image, ['name' => 'Hahahaha.png']);

        $newData = $this->data;
        $newData['name'] = 'Hahahaha.png';

        $this->controlProperties($image, $newData);
        $this->controlImageInDB($image);

        ImageService::delete($image);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $image = ImageService::create($this->data);
        $this->controlProperties($image, $this->data);
        $this->controlImageInDB($image);

        $result = ImageService::update($image, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $image = ImageService::create($this->data);
        $this->controlProperties($image, $this->data);
        $this->controlImageInDB($image);
        $result = ImageService::delete($image);
        self::assertTrue($result);
        $this->controlImageNotInDB($image);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $image = ImageService::create($this->data);
        $this->controlProperties($image, $this->data);
        $this->controlImageInDB($image);

        $getImage = ImageService::getByID($image->id);
        $this->controlProperties($getImage, $this->data);
        ImageService::delete($getImage);
    }

    public function testAddResort()
    {
        $image = ImageService::create($this->data);
        $image = ImageService::addResort($this->resort, $image);

        self::assertTrue(count(ResortService::getImages($this->resort)) == 1);
        ImageService::delete($image);
        self::assertTrue(count(ResortService::getImages($this->resort)) == 0);

        $image = ImageService::create($this->data);
        $image = ImageService::addResort($this->resort, $image);
        self::assertTrue(count(ResortService::getImages($this->resort)) == 1);
        $image = ImageService::removeResort($this->resort, $image);
        self::assertTrue(count(ResortService::getImages($this->resort)) == 0);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        ImageService::getByID(100000);
    }

    /**
     * @param Image $image
     * @param array $data
     */
    private function controlProperties($image, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($image->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Image $image
     */
    private function controlImageInDB($image)
    {
        $this->assertDatabaseHas('sportemu_images', [
            'user_id' => $image->user_id,
            'name'    => $image->name,
            'path'    => $image->path
        ]);
    }

    /**
     * @param Image $image
     */
    private function controlImageNotInDB($image)
    {
        $this->assertSoftDeleted('sportemu_images', [
            'user_id' => $image->user_id,
            'name'    => $image->name,
            'path'    => $image->path
        ]);
    }
}
