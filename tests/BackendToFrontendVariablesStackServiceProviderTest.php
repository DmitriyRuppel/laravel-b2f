<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use AvtoDev\BackendToFrontendVariablesStack\BackendToFrontendVariablesStackServiceProvider;

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
    protected $config_key = 'back2front';

    /**
     * Проверка существования и корректности значений конфигурации.
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
