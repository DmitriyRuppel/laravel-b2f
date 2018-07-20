<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests;

use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;

/**
 * Helper test to the data transfer service from the back to the front.
 *
 * @group back-to-front
 */
class HelpersTest extends AbstractTestCase
{
    /**
     * Check the type of object returned by the helper.
     */
    public function testBackToFrontStack()
    {
        $stack_object = backToFrontStack();

        $this->assertInstanceOf(BackendToFrontendVariablesInterface::class, $stack_object);
    }
}
