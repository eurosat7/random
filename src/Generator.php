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
     * @param string[] $set
     * @throws RandomException
     */
    private static function pickOne(array $set): string
    {
        $max = count($set) - 1;
        if ($max < 1) {
            throw new RandomException('empty set');
        }
        $index = random_int(0, $max);
        return ($set[$index]);
    }

    /**
     * @param string[][] $sets
     * @throws RandomException
     * @SuppressWarnings("boolean")
     */
    public static function generate(array $sets, int $length, bool $shuffle = true): string
    {
        $result = [];
        while (count($result) < $length) {
            foreach ($sets as $set) {
                $result [] = self::pickOne($set); // we do not remove used elements!
            }
        }
        if ($shuffle) {
            shuffle($result);
        }
        $result = array_slice($result, 0, $length);
        return Transformer::arrayToString($result);
    }

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
     * @throws RandomException
     */
    public static function password(int $length = 16): string
    {
        return self::generate(
            sets: [
                Charsets::numeric(),
                Charsets::alphanumeric(),
                Transformer::setToUppercase(Charsets::alphanumeric()),
                Charsets::special(),
            ],
            length: $length
        );
    }

    /**
     * Allows Umlauts
     *
     * @throws RandomException
     */
    public static function passwordDE(int $length = 16): string
    {
        return self::generate(
            sets: [
                Charsets::numeric(),
                Charsets::alphanumeric(),
                Transformer::setToUppercase(Charsets::alphanumeric()),
                [...Charsets::special(), ... Charsets::umlaut(), ... Transformer::setToUppercase(Charsets::umlaut())],
            ],
            length: $length
        );
    }

    /**
     * @throws RandomException
     */
    public static function easy(int $length = 16): string
    {
        return self::generate(
            sets: [
                Charsets::numeric(),
                Charsets::alphanumeric(),
            ],
            length: $length
        );
    }

    /**
     * @throws RandomException
     */
    public static function speakable(int $length = 8): string
    {
        $suffix = (int)ceil(sqrt($length)) - 1;
        if ($suffix < 1) $suffix = 1;
        if ($suffix > 3) $suffix = 3;

        $result = self::generate(
            sets: [
                Charsets::explosives(),
                Charsets::vowels(),
                Charsets::nonexplosives(),
            ],
            length: $length - $suffix,
            shuffle: false
        );
        $result .= self::generate(
            sets: [
                Charsets::numeric(),
            ],
            length: $suffix
        );
        return ucfirst($result);
    }
}