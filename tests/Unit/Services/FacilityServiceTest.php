<?php

namespace Tests\Unit\Services;

use App\Models\Facility;
use Facades\App\Services\FacilityService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FacilityServiceTest extends TestCase
{
    use DatabaseMigrations;
    private $data;

    protected function setUp()
    {
        parent::setUp();
        $this->data = [
            'name' => 'toilet',
        ];
    }

    /**
     * @return void
     */
    public function testCreate()
    {
        $facility = FacilityService::create($this->data);
        $this->controlProperties($facility, $this->data);
        $this->controlFacilityInDB($facility);

        FacilityService::delete($facility);
    }

    /**
     * @expectedException \Exception
     */
    public function testCreateFail()
    {
        $data = [
        ];

        FacilityService::create($data);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $facility = FacilityService::create($this->data);
        $this->controlProperties($facility, $this->data);
        $this->controlFacilityInDB($facility);

        $facility = FacilityService::update($facility, ['name' => 'shower']);

        $newData = $this->data;
        $newData['name'] = 'shower';

        $this->controlProperties($facility, $newData);
        $this->controlFacilityInDB($facility);

        FacilityService::delete($facility);
    }

    /**
     * @expectedException \Exception
     */
    public function testUpdateFail()
    {
        $facility = FacilityService::create($this->data);
        $this->controlProperties($facility, $this->data);
        $this->controlFacilityInDB($facility);

        $result = FacilityService::update($facility, ['name' => null]);
    }


    /**
     * @return void
     */
    public function testDelete()
    {
        $facility = FacilityService::create($this->data);
        $this->controlProperties($facility, $this->data);
        $this->controlFacilityInDB($facility);
        $result = FacilityService::delete($facility);
        self::assertTrue($result);
        $this->controlFacilityNotInDB($facility);
    }

    /**
     * @return void
     */
    public function testGetByID()
    {
        $facility = FacilityService::create($this->data);
        $this->controlProperties($facility, $this->data);
        $this->controlFacilityInDB($facility);

        $getFacility = FacilityService::getByID($facility->id);
        $this->controlProperties($getFacility, $this->data);
        FacilityService::delete($getFacility);
    }

    /**
     * @expectedException \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testGetByIDFail()
    {
        FacilityService::getByID(100000);
    }

    /**
     * @param Facility $facility
     * @param array    $data
     */
    private function controlProperties($facility, $data)
    {
        foreach ($data as $key => $value) {
            self::assertTrue($facility->{$key} == $data[ $key ]);
        }
    }

    /**
     * @param Facility $facility
     */
    private function controlFacilityInDB($facility)
    {
        $this->assertDatabaseHas('sportemu_facilities', [
            'name' => $facility->name,
        ]);
    }

    /**
     * @param Facility $facility
     */
    private function controlFacilityNotInDB($facility)
    {
        $this->assertDatabaseMissing('sportemu_facilities', [
            'name' => $facility->name,
        ]);
    }
}
