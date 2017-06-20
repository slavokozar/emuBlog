<?php

namespace Tests\Unit\Services;

use App\Models\Sport;
use Facades\App\Services\ResortService;
use Facades\App\Services\SportService;
use Facades\App\Services\UserService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SportServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;

    protected function setUp()
    {
        parent::setUp();
        $this->data = [
            'name' => 'football',
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $sport = SportService::create($this->data);
        $this->controlProperties($sport, $this->data);
        $this->controlSportInDB($sport);

        SportService::delete($sport);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        $result = SportService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $sport = SportService::create($this->data);
        $this->controlProperties($sport, $this->data);
        $this->controlSportInDB($sport);

        $sport = SportService::update($sport, ['name' => 'golf']);

        $newData = $this->data;
        $newData['name'] = 'golf';

        $this->controlProperties($sport, $newData);
        $this->controlSportInDB($sport);

        SportService::delete($sport);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $sport = SportService::create($this->data);
        $this->controlProperties($sport, $this->data);
        $this->controlSportInDB($sport);

        $result = SportService::update($sport, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $sport = SportService::create($this->data);
        $this->controlProperties($sport, $this->data);
        $this->controlSportInDB($sport);
        $result = SportService::delete($sport);
        self::assertTrue($result);
        $this->controlSportNotInDB($sport);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $sport = SportService::create($this->data);
        $this->controlProperties($sport, $this->data);
        $this->controlSportInDB($sport);

        $getSport = SportService::getByID($sport->id);
        $this->controlProperties($getSport, $this->data);
        SportService::delete($getSport);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        SportService::getByID(100000);
    }


    /**
     * @param Sport $sport
     * @param array $data
     */
    private function controlProperties($sport, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($sport->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Sport $sport
     */
    private function controlSportInDB($sport)
    {
        $this->assertDatabaseHas('sportemu_sports', [
            'name' => $sport->name,
        ]);
    }

    /**
     * @param Sport $sport
     */
    private function controlSportNotInDB($sport)
    {
        $this->assertDatabaseMissing('sportemu_sports', [
            'name' => $sport->name,
        ]);
    }
}
