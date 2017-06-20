<?php

namespace Tests\Unit\Services;

use App\Models\Rating;
use Facades\App\Services\RatingService;
use Facades\App\Services\ResortService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RatingServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;
    private $user;
    private $author;
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

        $this->author = UserService::create([
            'name'      => 'Lukas',
            'surname'   => 'FiguraAuthor',
            'email'     => 'authorfigura@e-zone.sk',
            'password'  => bcrypt('qwerty'),
            'nickname'  => 'figiauthor',
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
            "author_id" => $this->author->id,
            "user_id"   => $this->user->id,
            "resort_id" => $this->resort->id,
            "content"   => 'asd asdakdjlkasjd lkasj dkjaslkj dlsaj ldjasl jdlasj dlajsldk asjkl djaslkj dlksa ',
            "rating"    => 4.5
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $rating = RatingService::create($this->data);
        $this->controlProperties($rating, $this->data);
        $this->controlRatingInDB($rating);

        self::assertTrue($rating->user->id == $this->user->id);
        self::assertTrue(count($this->user->ratings) == 1);
        self::assertTrue($rating->resort->id == $this->resort->id);
        RatingService::delete($rating);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = RatingService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $rating = RatingService::create($this->data);
        $this->controlProperties($rating, $this->data);
        $this->controlRatingInDB($rating);

        $rating = RatingService::update($rating, ['content' => 'asda \da\s das']);

        $newData = $this->data;
        $newData['content'] = 'asda \da\s das';

        $this->controlProperties($rating, $newData);
        $this->controlRatingInDB($rating);

        RatingService::delete($rating);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $rating = RatingService::create($this->data);
        $this->controlProperties($rating, $this->data);
        $this->controlRatingInDB($rating);

        $result = RatingService::update($rating, ['content' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $rating = RatingService::create($this->data);
        $this->controlProperties($rating, $this->data);
        $this->controlRatingInDB($rating);
        $result = RatingService::delete($rating);
        self::assertTrue($result);
        $this->controlRatingNotInDB($rating);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $rating = RatingService::create($this->data);
        $this->controlProperties($rating, $this->data);
        $this->controlRatingInDB($rating);

        $getRating = RatingService::getByID($rating->id);
        $this->controlProperties($getRating, $this->data);
        RatingService::delete($getRating);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        RatingService::getByID(100000);
    }

    /**
     * @param Rating $rating
     * @param array  $data
     */
    private function controlProperties($rating, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($rating->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Rating $rating
     */
    private function controlRatingInDB($rating)
    {
        $this->assertDatabaseHas('sportemu_ratings', [
            "author_id" => $rating->author_id,
            "user_id"   => $rating->user_id,
            "resort_id" => $rating->resort_id,
            "content"   => $rating->content,
            "rating"    => $rating->rating
        ]);
    }

    /**
     * @param Rating $rating
     */
    private function controlRatingNotInDB($rating)
    {
        $this->assertDatabaseMissing('sportemu_ratings', [
            "author_id" => $rating->author_id,
            "user_id"   => $rating->user_id,
            "resort_id" => $rating->resort_id,
            "content"   => $rating->content,
            "rating"    => $rating->rating
        ]);
    }
}
