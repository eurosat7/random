<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Random\RandomException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class CustomGenerator
{
    /**
     * @throws RandomException
     */
    public static function easy(int $length = 16): string
    {
        return Generator::generate(
            sets: [
                Charsets::numeric(),
                Charsets::alphanumeric(),
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
        return Generator::generate(
            sets: [
                Charsets::numeric(), Charsets::alphanumeric(),
                Transformer::toUppercase(Charsets::alphanumeric()),
                [
                    ...Charsets::special(),
                    ... Charsets::umlaut(),
                    ... Transformer::toUppercase(Charsets::umlaut())
                ],
            ],
            length: $length
        );
    }

    /**
     * @throws RandomException
     */
    public static function speakable(int $length = 8): string
    {
        $suffix = self::getSuffix($length);

        $result = Generator::generate(
            sets: [
                Charsets::explosives(),
                Charsets::vowels(),
                Charsets::nonexplosives(),
            ],
            length: $length - $suffix,
            shuffle: false
        );
        $result .= Generator::generate(
            sets: [
                Charsets::numeric(),
            ],
            length: $suffix
        );
        return ucfirst($result);
    }

    public static function getSuffix(int $length): int
    {
        $suffix = (int) ceil(sqrt($length)) - 1;
        if ($suffix < 1) {
            return 1;
        }
        if ($suffix > 3) {
            return 3;
        }
        return $suffix;
    }
}
