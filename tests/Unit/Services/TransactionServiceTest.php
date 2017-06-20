<?php

namespace Tests\Unit\Services;

use App\Models\County;
use App\Models\Transaction;
use Facades\App\Services\CreditService;
use Facades\App\Services\FieldService;
use Facades\App\Services\ReservationService;
use Facades\App\Services\ResortService;
use Facades\App\Services\SportService;
use Facades\App\Services\TransactionService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data, $user, $credit, $reservation, $resort, $sport, $field;

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

        $this->credit = CreditService::create([
            'user_id' => $this->user->id,
            'balance' => 20.23
        ]);

        $this->reservation = ReservationService::create([
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
        ]);

        $this->data = [
            'credit_id'      => $this->credit->id,
            'reservation_id' => $this->reservation->id,
            'value'          => 20.50,
            'canceled_at'    => null
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $transaction = TransactionService::create($this->data);
        $this->controlProperties($transaction, $this->data);
        $this->controlTransactionInDB($transaction);

        self::assertTrue($transaction->reservation->id == $this->reservation->id);
        self::assertTrue($transaction->credit->id == $this->credit->id);
        self::assertTrue(count($transaction->credit->transactions) == 1);
        self::assertTrue(count($this->reservation->transactions) == 1);

        TransactionService::delete($transaction);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = TransactionService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $transaction = TransactionService::create($this->data);
        $this->controlProperties($transaction, $this->data);
        $this->controlTransactionInDB($transaction);

        $transaction = TransactionService::update($transaction, ['value' => '15']);

        $newData = $this->data;
        $newData['value'] = '15';

        $this->controlProperties($transaction, $newData);
        $this->controlTransactionInDB($transaction);

        TransactionService::delete($transaction);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $transaction = TransactionService::create($this->data);
        $this->controlProperties($transaction, $this->data);
        $this->controlTransactionInDB($transaction);

        $result = TransactionService::update($transaction, ['value' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $transaction = TransactionService::create($this->data);
        $this->controlProperties($transaction, $this->data);
        $this->controlTransactionInDB($transaction);
        $result = TransactionService::delete($transaction);
        self::assertTrue($result);
        $this->controlTransactionNotInDB($transaction);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $transaction = TransactionService::create($this->data);
        $this->controlProperties($transaction, $this->data);
        $this->controlTransactionInDB($transaction);

        $getTransaction = TransactionService::getByID($transaction->id);
        $this->controlProperties($getTransaction, $this->data);
        TransactionService::delete($getTransaction);
    }


    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        TransactionService::getByID(100000);
    }


    /**
     * @param Transaction $transaction
     * @param array       $data
     */
    private function controlProperties($transaction, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($transaction->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Transaction $transaction
     */
    private function controlTransactionInDB($transaction)
    {
        $this->assertDatabaseHas('sportemu_transactions', [
            'credit_id'      => $transaction->credit_id,
            'reservation_id' => $transaction->reservation_id,
            'value'          => $transaction->value,
            'canceled_at'    => $transaction->canceled_at
        ]);
    }

    /**
     * @param Transaction $transaction
     */
    private function controlTransactionNotInDB($transaction)
    {
        $this->assertSoftDeleted('sportemu_transactions', [
            'credit_id'      => $transaction->credit_id,
            'reservation_id' => $transaction->reservation_id,
            'value'          => $transaction->value,
            'canceled_at'    => $transaction->canceled_at
        ]);
    }
}
