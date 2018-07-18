<?php

use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;

if (! function_exists('backToFrontStack')) {
    /**
     * Возвращает объект стэка для передачи данных от бэка фронту.
     *
     * @return BackendToFrontendVariablesInterface
     */
    function backToFrontStack()
    {
        return resolve(BackendToFrontendVariablesInterface::class);
    }
}