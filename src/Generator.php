<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Random\RandomException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Generator
{
    /**
     * @throws RandomException
     */
    public static function numerical(int $length = 8): string
    {
        return self::generate(
            sets: [
                Charsets::numeric()
            ],
            length: $length
        );
    }

    /**
     * @param array<int, array<int, string>> $sets
     *
     * @throws RandomException
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function generate(array $sets, int $length, bool $shuffle = true): string
    {
        $result = [];
        $count = 0;
        while ($count < $length) {
            $count++;
            foreach ($sets as $set) {
                $result[] = Arrays::pickOne($set);
                // we do not remove used elements!
            }
        }
        if ($shuffle) {
            $result = Shuffle::shuffle($result);
        }
        $result = array_slice($result, 0, $length);
        // no condition in the loop is faster
        return \implode('', $result);
    }

    /**
     * @throws RandomException
     */
    public static function password(int $length = 16): string
    {
        return self::generate(
            sets: [
                Charsets::numeric(),
                Charsets::alphanumeric(),
                Transformer::toUppercase(Charsets::alphanumeric()),
                Charsets::special(),
            ],
            length: $length
        );
    }
}
