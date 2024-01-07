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
     * Tries to get one of each set then the rest is unbiased
     *
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
        foreach ($sets as $set) {
            $count++;
            $result[] = Arrays::pickOne($set);
        }
        $superset = array_merge(...$sets);
        while ($count < $length) {
            $count++;
            $result[] = Arrays::pickOne($superset);
        }
        if ($shuffle) {
            $result = Shuffle::shuffle($result);
        }
        $result = array_slice($result, 0, $length);
        return \implode('', $result);
    }

    /**
     * Tries to use each set evenly, the length of each set does not matter
     *
     * @param array<int, array<int, string>> $sets
     *
     * @throws RandomException
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function generateBiased(array $sets, int $length, bool $shuffle = true): string
    {
        $result = [];
        $count = 0;
        while ($count < $length) {
            $count++;
            foreach ($sets as $set) {
                $result[] = Arrays::pickOne($set);
            }
        }
        if ($shuffle) {
            $result = Shuffle::shuffle($result);
        }
        $result = array_slice($result, 0, $length);
        return \implode('', $result);
    }

    /**
     * @throws RandomException
     */
    public static function password(int $length = 16): string
    {
        return self::generateBiased(
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
