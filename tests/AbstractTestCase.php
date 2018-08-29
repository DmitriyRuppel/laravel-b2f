<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use AvtoDev\BackendToFrontendVariablesStack\BackendToFrontendVariablesStackServiceProvider;
use AvtoDev\BackendToFrontendVariablesStack\Tests\Unit\Traits\CreatesApplicationTrait;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AbstractTestCase extends BaseTestCase
{
    use CreatesApplicationTrait;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->app->register(BackendToFrontendVariablesStackServiceProvider::class);
    }
}
