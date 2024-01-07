<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Random\RandomException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Arrays
{
    /**
     * @param array<int, string> $set
     * @param array<int, string> $unwanted
     *
     * @return array<int, string>
     */
    public static function removeFromSet(array $set, array $unwanted): array
    {
        $result = [];
        foreach ($set as $char) {
            if (!in_array($char, $unwanted, true)) {
                $result[] = $char;
            }
        }
        return $result;
    }

    /**
     * @param array<int, string> $set
     *
     * @throws RandomException
     */
    public static function pickOne(array $set): string
    {
        $max = count($set) - 1;
        if ($max < 1) {
            throw new RandomException('empty set');
        }
        $index = random_int(0, $max);
        return $set[$index];
    }
}
