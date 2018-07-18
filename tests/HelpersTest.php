<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use DateTime;
use Tarampampam\Wrappers\Json;
use AvtoDev\BackendToFrontendVariablesStack\Service\BackendToFrontendVariablesStack;
use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;

/**
 * Тест хэлперов к сервису передачи данных от бэка фронту.
 *
 * @group back-to-front
 */
class HelpersTest extends AbstractTestCase
{
    /**
     * Проверка типа объекта возвращаемого хэлпером.
     */
    public function testBackToFrontStack()
    {
        $stack_object = backToFrontStack();

        $this->assertInstanceOf(BackendToFrontendVariablesInterface::class, $stack_object);
    }
}
