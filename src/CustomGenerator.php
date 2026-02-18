<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Eurosat7\Random\Exception\InvalidLengthException;
use Eurosat7\Random\Exception\LogicException;

class CustomGenerator
{
    /**
     * @throws LogicException
     */
    public static function easy(int $length = 16): string
    {
        if ($length < 1) {
            throw new InvalidLengthException('length must be greater than 0');
        }
        return Generator::generate(
            sets: [
                Charsets::numeric(),
                Charsets::lowercase(),
            ],
            length: $length
        );
    }

    /**
     * Allows Umlauts
     *
     * @throws LogicException
     */
    public static function passwordDE(int $length = 16): string
    {
        if ($length < 1) {
            throw new InvalidLengthException('length must be greater than 0');
        }
        return Generator::generate(
            sets: [
                Charsets::numeric(),
                Charsets::lowercase(),
                Charsets::uppercase(),
                [
                    ...Charsets::special(),
                    ...Charsets::german(),
                ],
            ],
            length: $length
        );
    }

    /**
     * @throws LogicException
     */
    public static function speakable(int $length = 8): string
    {
        if ($length < 1) {
            throw new InvalidLengthException('length must be greater than 0');
        }
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
