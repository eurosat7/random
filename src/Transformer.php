<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Eurosat7\Random\Exception\OutOfRandomException;
use Throwable;

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
            static fn(string $value): string => mb_strtolower($value, 'UTF-8'),
            $set,
        );
    }

    /**
     * @param array<int, string> $set
     *
     * @return array<int, string>
     * @throws OutOfRandomException
     */
    public static function toRandomcase(array $set): array
    {
        return array_map(
            static fn(string $value): string => self::randomCase($value),
            $set,
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
            static fn(string $value): string => mb_strtoupper($value, 'UTF-8'),
            $set,
        );
    }

    /**
     * @throws OutOfRandomException
     */
    private static function randomCase(string $value): string
    {
        try {
            $isUppercase = random_int(0, 1) === 0;
        } catch (Throwable $e) {
            throw new OutOfRandomException($e->getMessage(), (int)$e->getCode(), $e);
        }

        if ($isUppercase) {
            return mb_strtoupper($value, 'UTF-8');
        }

        return mb_strtolower($value, 'UTF-8');
    }
}
