<?php
declare(strict_types=1);

namespace Eurosat7\Random;

use Random\RandomException;

class Generator
{
    /**
     * @throws RandomException
     */
    private static function pickOne(array $set): string
    {
        $max = count($set) - 1;
        $index = random_int(0, $max);
        return ($set[$index]);
    }

    /**
     * @param string[][] $sets
     * @throws RandomException
     */
    public static function generate(array $sets, int $length, bool $shuffle = true): string
    {
        $result = '';
        while (strlen($result) < $length) {
            foreach ($sets as $set) {
                $result .= self::pickOne($set); // we do not remove used elements!
            }
        }
        if ($shuffle) {
            $result = str_shuffle($result); // this shuffle does not need to be "secure" - the source is already secure.
        }
        return substr($result, 0, $length);
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
                [... Charsets::umlaut(), ... Transformer::setToUppercase(Charsets::umlaut())],
                Charsets::special(),
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
        $suffix = ceil(sqrt($length)) - 1;
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