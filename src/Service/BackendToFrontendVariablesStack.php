<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Service;

use DateTime;
use Traversable;
use Tarampampam\Wrappers\Json;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;

/**
 * Class BackendToFrontendVariablesStack.
 *
 * Service class for sending data from back to front Json.
 */
class BackendToFrontendVariablesStack extends Collection implements BackendToFrontendVariablesInterface
{
    /**
     * @var string Date format DateTime object conversion.
     */
    protected $date_format;

    /**
     * @var int Maximum depth of recursive data traversal when converting to scalars
     */
    protected $max_recursion_depth;

    /**
     * BackendToFrontendVariablesStack constructor.
     */
    public function __construct($items = [])
    {
        parent::__construct($items);

        $this->date_format         = config('back-tofront-stack.date_format', 'Y-m-d H:i:s');
        $this->max_recursion_depth = config('back-tofront-stack.max_recursion_depth', 3);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->clearNoScalarsFromArrayRecursive(
            $this->formatDataRecursive($this->items, 0, $this->max_recursion_depth)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->toArray(), $options);
    }

    /**
     * Performs a recursive data traversal to the maximum specified level of nesting and converts the values to
     * Arrays + formats the date.
     *
     * @param array|Traversable $data      Данные
     * @param int               $depth     Текущая глубина обхода
     * @param int               $max_depth Максимальная глубина обхода
     *
     * @return array
     */
    protected function formatDataRecursive($data, $depth = 0, $max_depth = 3)
    {
        $map_closure = function ($value) use ($depth, $max_depth) {
            // Convert to array if available
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            if ($value instanceof DateTime) {
                return $value->format($this->date_format);
            } elseif ((is_array($value) || $value instanceof Traversable)
                      && $depth < $max_depth) {
                return $this->formatDataRecursive($value, ++$depth, $max_depth);
            }

            return $value;
        };

        return array_map($map_closure, $data);
    }

    /**
     * Recompiles the array only with simple data types and arrays.
     *
     * @param array $data
     */
    protected function clearNoScalarsFromArrayRecursive($data)
    {
        $result = [];

        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $result[$key] = $this->clearNoScalarsFromArrayRecursive($item);
            } elseif (is_scalar($item) || $item === null) {
                $result[$key] = $item;
            }
        }

        return $result;
    }
}
