<?php

declare(strict_types=1);

namespace Corbocal\Utilities\Tools;

final class Arrays
{
    private function __construct()
    {
    }

    /**
     * @param string $json the json string to flatten
     * @return array<mixed> the resulting flattened array
     */
    public static function flattenJson(string $json): array
    {
        /** @var array<mixed> */
        $array = \json_decode($json, true) ?? [];

        return self::flatten($array);
    }

    /**
     * @param array<mixed> $array
     * @return array<mixed> the resulting flattened array
     */
    public static function flattenArray(array $array): array
    {
        return self::flatten($array);
    }

    /**
     * @param array<mixed> $a the input array to flatten, which is recursively traversed
     * @param string $parentKey
     * @param string $keySeparator
     * @return array<mixed>
     */
    private static function flatten(array $a, string $parentKey = "", string $keySeparator = "."): array
    {
        $items = [];
        foreach ($a as $k => $v) {
            $new_key = $parentKey ? $parentKey . $keySeparator . $k : $k;
            if (\is_array($v) && \array_is_list($v)) {
                $child = $v;
                unset($v);
                if ($child) {
                    $items = \array_merge($items, self::flatten($child, $new_key, $keySeparator));
                }
            } else {
                $items[$new_key] = $v;
            }
        }

        return $items;
    }
}
