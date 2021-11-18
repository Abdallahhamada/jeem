<?php

namespace Tests;

use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication, DatabaseMigrations;
    protected $faker;
    protected $user;


    public function setUp(): void
    {
        parent::setUp();


        $this->fake = Faker::create();

    }
}
