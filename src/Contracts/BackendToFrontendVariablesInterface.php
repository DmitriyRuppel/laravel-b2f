<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Contracts;

use Countable;
use Traversable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Интерфейс объекта для обмена данными между бэкэндом и фронтендом.
 */
interface BackendToFrontendVariablesInterface extends Arrayable, Jsonable, Traversable, Countable
{
    /**
     * Добавить элемент для передачи фронту.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return BackendToFrontendVariablesInterface
     */
    public function put($key, $value);

    /**
     * Remove an item by key.
     *
     * @param array|string $keys
     *
     * @return $this
     */
    public function forget($keys);

    /**
     * Get an item by key.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Проверка, что есть данные по заданному ключу.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);
}
