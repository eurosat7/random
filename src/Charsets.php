<?php

declare(strict_types=1);

namespace Eurosat7\Random;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Charsets
{
    /**
     * @return array<int, string>
     */
    public static function hexadecimal(): array
    {
        return // range('0', 'f');
            [
                '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
                'a', 'b', 'c', 'd', 'e', 'f'
            ];
    }

    /**
     * @return array<int, string>
     */
    public static function numeric(): array
    {
        return // range('0', '9');
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    }

    /**
     * @return array<int, string>
     */
    public static function special(): array
    {
        return [
            '!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>',
            '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function umlaut(): array
    {
        return ['ä', 'ö', 'ü', 'ß'];
    }

    /**
     * @return array<int, string>
     */
    public static function nonexplosives(): array
    {
        return Arrays::removeFromSet(
            self::alphanumeric(),
            [... self::explosives(), ... self::vowels()]
        );
    }

    /**
     * @return array<int, string>
     */
    public static function alphanumeric(): array
    {
        return range('a', 'z');
    }

    /**
     * @return array<int, string>
     */
    public static function explosives(): array
    {
        return ['b', 'd', 'g', 'k', 'p', 't'];
    }

    /**
     * @return array<int, string>
     */
    public static function vowels(): array
    {
        return ['a', 'e', 'i', 'o', 'u'];
    }

    /**
     * @return array<int, string>
     */
    public static function whitespace(): array
    {
        return ["\r", "\n", "\t", ' '];
    }
}
