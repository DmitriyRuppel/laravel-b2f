<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Contracts;

use Countable;
use Traversable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * The interface of the object for data exchange between the backend and the frontend.
 */
interface BackendToFrontendVariablesInterface extends Arrayable, Jsonable, Traversable, Countable
{
    /**
     * Add an element to send to the front.
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
     * Check that there is data for a given key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);
}
