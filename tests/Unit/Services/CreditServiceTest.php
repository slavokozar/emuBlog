<?php

namespace Tests\Unit\Services;

use App\Models\Credit;
use Facades\App\Services\CreditService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreditServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data, $user;

    protected function setUp()
    {
        parent::setUp();

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
            'balance' => 20.23
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $credit = CreditService::create($this->data);
        $this->controlProperties($credit, $this->data);
        $this->controlCreditInDB($credit);

        self::assertTrue($credit->user->id == $this->user->id);
        self::assertTrue($this->user->credit->id == $credit->id);

        CreditService::delete($credit);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        CreditService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $credit = CreditService::create($this->data);
        $this->controlProperties($credit, $this->data);
        $this->controlCreditInDB($credit);

        $credit = CreditService::update($credit, ['balance' => 4.4]);

        $newData = $this->data;
        $newData['balance'] = 4.4;

        $this->controlProperties($credit, $newData);
        $this->controlCreditInDB($credit);

        CreditService::delete($credit);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $credit = CreditService::create($this->data);
        $this->controlProperties($credit, $this->data);
        $this->controlCreditInDB($credit);

        $result = CreditService::update($credit, ['balance' => null]);
    }

    public function testAddCredit()
    {
        $credit = CreditService::create($this->data);

        $oldBalance = $credit->balance;
        $result = CreditService::addCredit($credit, 67.54);
        self::assertTrue($result->balance == ($oldBalance + 67.54));

        $oldBalance = $result->balance;
        $result = CreditService::addCredit($credit, -1167.54);
        self::assertTrue($result->balance == ($oldBalance + (-1167.54)));

        CreditService::delete($credit);
    }

    /**
     * @return void
     */
    public function testDelete()
    {
        $credit = CreditService::create($this->data);
        $this->controlProperties($credit, $this->data);
        $this->controlCreditInDB($credit);
        $result = CreditService::delete($credit);
        self::assertTrue($result);
        $this->controlCreditNotInDB($credit);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $credit = CreditService::create($this->data);
        $this->controlProperties($credit, $this->data);
        $this->controlCreditInDB($credit);

        $getCredit = CreditService::getByID($credit->id);
        $this->controlProperties($getCredit, $this->data);
        CreditService::delete($getCredit);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        CreditService::getByID(100000);
    }

    /**
     * @param Credit $credit
     * @param array  $data
     */
    private function controlProperties($credit, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($credit->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Credit $credit
     */
    private function controlCreditInDB($credit)
    {
        $this->assertDatabaseHas('sportemu_credits', [
            'user_id' => $credit->user_id,
            'balance' => $credit->balance,
        ]);
    }

    /**
     * @param Credit $credit
     */
    private function controlCreditNotInDB($credit)
    {
        $this->assertSoftDeleted('sportemu_credits', [
            'user_id' => $credit->user_id,
            'balance' => $credit->balance,
        ]);
    }
}
