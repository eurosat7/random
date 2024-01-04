<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Random\RandomException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Transformer
{
    /**
     * @param array<int, string> $set
     *
     * @return array<int, string>
     */
    public static function toLowercase(array $set): array
    {
        return array_map(
            static fn(string $value): string => strtolower($value),
            $set
        );
    }

    /**
     * @param array<int, string> $set
     *
     * @return array<int, string>
     *
     * @throws RandomException
     */
    public static function toRandomcase(array $set): array
    {
        return array_map(
            static fn(string $value): string => self::randomCase($value),
            $set
        );
    }

    /**
     * @param array<int, string> $set
     *
     * @return array<int, string>
     */
    public static function toUppercase(array $set): array
    {
        return array_map(
            static fn(string $value): string => strtoupper($value),
            $set
        );
    }

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
     * @throws RandomException
     */
    private static function randomCase(string $value): string
    {
        return random_int(0, mt_getrandmax()) % 2 === 0 ? strtoupper($value) : strtolower($value);
    }
}
