<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use Faker\Generator;
use Exception;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseMigrations;

    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        Artisan::call('migrate:refresh');
        Artisan::call('migrate:reset');
        Artisan::call('migrate');
        Artisan::call('migrate', ['--seed' => true]);
    }

    public function __get($key)
    {
        if ($key === 'faker') {
            return $this->faker;
        }

        throw new Exception('Unknown Key Requested');
    }
}
