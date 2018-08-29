<?php

use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;

if (! function_exists('backToFrontStack')) {
    /**
     * Returns service object.
     *
     * @return BackendToFrontendVariablesInterface
     */
    function backToFrontStack()
    {
        return resolve(BackendToFrontendVariablesInterface::class);
    }
}
