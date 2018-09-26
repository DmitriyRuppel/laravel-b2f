<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests\Unit;

use AvtoDev\BackendToFrontendVariablesStack\Tests\AbstractTestCase;

/**
 * Class BackendToFrontendVariablesStackServiceProviderTest.
 *
 * @group back-to-front
 */
class BackendToFrontendVariablesStackServiceProviderTest extends AbstractTestCase
{
    /**
     * @var string Ключ конфига.
     */
    protected $config_key = 'back-to-front';

    /**
     * Check config.
     */
    public function testConfigExists()
    {
        $configs = config($this->config_key);

        $this->assertTrue(is_array($configs));

        foreach (['max_recursion_depth', 'date_foramat'] as $item) {
            $this->assertArrayHasKey($item, $configs);
        }
    }
}
