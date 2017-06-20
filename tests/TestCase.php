<?php

namespace Tests;

use DB;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
    }
}
