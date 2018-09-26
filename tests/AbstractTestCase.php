<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use AvtoDev\BackendToFrontendVariablesStack\BackendToFrontendVariablesStackServiceProvider;
use AvtoDev\BackendToFrontendVariablesStack\Tests\Unit\Traits\CreatesApplicationTrait;
use AvtoDev\DevTools\Tests\PHPUnit\AbstractLaravelTestCase;

abstract class AbstractTestCase extends AbstractLaravelTestCase
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
