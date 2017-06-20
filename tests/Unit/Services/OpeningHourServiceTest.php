<?php

namespace Tests\Unit\Services;

use App\Models\OpeningHour;
use Facades\App\Services\OpeningHourService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OpeningHourServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data, $field, $resort;

    protected function setUp()
    {
        parent::setUp();

        $this->data = [
            'start'   => '08:00:00',
            'end'     => '10:00:00',
            'weekday' => 2,
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $openingHour = OpeningHourService::create($this->data);
        $this->controlProperties($openingHour, $this->data);
        $this->controlOpeningHourInDB($openingHour);

        $openingHourSec = OpeningHourService::create($this->data);
        $this->controlProperties($openingHourSec, $this->data);
        $this->controlOpeningHourInDB($openingHourSec);

        self::assertTrue($openingHourSec->id == $openingHour->id);

        OpeningHourService::delete($openingHour);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = OpeningHourService::create($data);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $openingHour = OpeningHourService::create($this->data);
        $this->controlProperties($openingHour, $this->data);
        $this->controlOpeningHourInDB($openingHour);
        $result = OpeningHourService::delete($openingHour);
        self::assertTrue($result);
        $this->controlOpeningHourNotInDB($openingHour);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $openingHour = OpeningHourService::create($this->data);
        $this->controlProperties($openingHour, $this->data);
        $this->controlOpeningHourInDB($openingHour);

        $getOpeningHour = OpeningHourService::getByID($openingHour->id);
        $this->controlProperties($getOpeningHour, $this->data);
        OpeningHourService::delete($getOpeningHour);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        OpeningHourService::getByID(100000);
    }

    /**
     * @param OpeningHour $openingHour
     * @param array       $data
     */
    private function controlProperties($openingHour, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($openingHour->getOriginal($key) == $data[ $key ]);
        }
    }

    /**
     * @param OpeningHour $openingHour
     */
    private function controlOpeningHourInDB($openingHour)
    {
        $this->assertDatabaseHas('sportemu_opening_hours', [
            'start'   => $openingHour->start,
            'end'     => $openingHour->end,
            'weekday' => $openingHour->weekday,
            'closed'  => $openingHour->closed,
        ]);
    }

    /**
     * @param OpeningHour $openingHour
     */
    private function controlOpeningHourNotInDB($openingHour)
    {
        $this->assertDatabaseMissing('sportemu_opening_hours', [
            'start'   => $openingHour->start,
            'end'     => $openingHour->end,
            'weekday' => $openingHour->weekday,
            'closed'  => $openingHour->closed,
        ]);
    }


}
