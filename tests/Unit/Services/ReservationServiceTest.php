<?php

namespace Tests\Unit\Services;

use App\Models\Reservation;
use Facades\App\Services\FieldService;
use Facades\App\Services\ReservationService;
use Facades\App\Services\ResortService;
use Facades\App\Services\SportService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReservationServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data, $resort, $field, $sport;

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

        $this->sport = SportService::create([
            'name' => 'football',
        ]);

        $this->data = [
            'resort_id'     => $this->resort->id,
            'field_id'      => $this->field->id,
            'sport_id'      => $this->sport->id,
            'opened'        => false,
            'start'         => '12:00:00',
            'end'           => '15:00:00',
            'date'          => '2017-07-24',
            'price'         => 20.56,
            'meet_info'     => 'some meet info',
            'contact_phone' => '001231231231231',
            'canceled_at'   => null
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $reservation = ReservationService::create($this->data);
        $this->controlProperties($reservation, $this->data);
        $this->controlReservationInDB($reservation);

        self::assertTrue($reservation->resort->id == $this->resort->id);
        self::assertTrue($reservation->field->id == $this->field->id);
        self::assertTrue($reservation->sport->id == $this->sport->id);

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

        self::assertTrue(count($this->resort->reservations) == 1);

        $reservation = ReservationService::addOwner($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 1);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 0);

        $reservation = ReservationService::addInstructor($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 1);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 1);

        $reservation = ReservationService::removeOwner($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 0);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 1);

        $reservation = ReservationService::removeInstructor($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 0);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 0);

        //change order of insert owner and instructor
        $reservation = ReservationService::addInstructor($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 0);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 1);

        $reservation = ReservationService::addOwner($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 1);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 1);

        $reservation = ReservationService::removeInstructor($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 1);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 0);

        $reservation = ReservationService::removeOwner($user, $reservation);
        self::assertTrue(count(ReservationService::getOwners($reservation)) == 0);
        self::assertTrue(count(ReservationService::getInstructors($reservation)) == 0);

        $reservation = ReservationService::addOwner($user, $reservation);
        ReservationService::delete($reservation);
        self::assertTrue(count($user->reservations) == 0);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = ReservationService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $reservation = ReservationService::create($this->data);
        $this->controlProperties($reservation, $this->data);
        $this->controlReservationInDB($reservation);

        $reservation = ReservationService::update($reservation, ['start' => '14:30:00']);

        $newData = $this->data;
        $newData['start'] = '14:30:00';

        $this->controlProperties($reservation, $newData);
        $this->controlReservationInDB($reservation);

        ReservationService::delete($reservation);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $reservation = ReservationService::create($this->data);
        $this->controlProperties($reservation, $this->data);
        $this->controlReservationInDB($reservation);

        $result = ReservationService::update($reservation, ['start' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $reservation = ReservationService::create($this->data);
        $this->controlProperties($reservation, $this->data);
        $this->controlReservationInDB($reservation);
        $result = ReservationService::delete($reservation);
        self::assertTrue($result);
        $this->controlReservationNotInDB($reservation);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $reservation = ReservationService::create($this->data);
        $this->controlProperties($reservation, $this->data);
        $this->controlReservationInDB($reservation);

        $getReservation = ReservationService::getByID($reservation->id);
        $this->controlProperties($getReservation, $this->data);
        ReservationService::delete($getReservation);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        ReservationService::getByID(100000);
    }


    /**
     * @param Reservation $reservation
     * @param array       $data
     */
    private function controlProperties($reservation, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($reservation->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Reservation $reservation
     */
    private function controlReservationInDB($reservation)
    {
        $this->assertDatabaseHas('sportemu_reservations', [
            'resort_id'     => $reservation->resort_id,
            'field_id'      => $reservation->field_id,
            'sport_id'      => $reservation->sport_id,
            'opened'        => $reservation->opened,
            'start'         => $reservation->start,
            'end'           => $reservation->end,
            'date'          => $reservation->date,
            'price'         => $reservation->price,
            'meet_info'     => $reservation->meet_info,
            'contact_phone' => $reservation->contact_phone,
            'canceled_at'   => $reservation->canceled_at
        ]);
    }

    /**
     * @param Reservation $reservation
     */
    private function controlReservationNotInDB($reservation)
    {
        $this->assertSoftDeleted('sportemu_reservations', [
            'resort_id'     => $reservation->resort_id,
            'field_id'      => $reservation->field_id,
            'sport_id'      => $reservation->sport_id,
            'opened'        => $reservation->opened,
            'start'         => $reservation->start,
            'end'           => $reservation->end,
            'date'          => $reservation->date,
            'price'         => $reservation->price,
            'meet_info'     => $reservation->meet_info,
            'contact_phone' => $reservation->contact_phone,
            'canceled_at'   => $reservation->canceled_at
        ]);
    }
}
