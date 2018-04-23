<?php

namespace Dilab\EventSauceLaravel\Test\Integration;

use Dilab\EventSauceLaravel\EventSauceServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Dilab\EventSauceLaravel\Test\TestHelper;

abstract class TestCase extends Orchestra
{
    /**
     * @var TestHelper
     */
    protected $testHelper;

    public function setUp()
    {
        $this->testHelper = new TestHelper();

        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            EventSauceServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->testHelper->initializeTempDirectory();

        $app['config']->set('app.key', '6rE9Nz59bGRbeMATftriyQjrpF7DcOQm');

        $app['config']->set('database.connections.db1', [
            'driver' => 'sqlite',
            'database' => $this->testHelper->createSQLiteDatabase('database1.sqlite'),
        ]);

        $app['config']->set('database.default', 'db1');

        $app['config']->set('queue.default', 'sync');

    }


}
