<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use AvtoDev\BackendToFrontendVariablesStack\BackendToFrontendVariablesStackServiceProvider;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AbstractTestCase extends BaseTestCase
{
    use Traits\CreatesApplicationTrait;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->app->register(BackendToFrontendVariablesStackServiceProvider::class);
    }
}
