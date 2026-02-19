<?php

declare(strict_types=1);

namespace Eurosat7\Random;

class Charsets
{
    /** @var array<string, array<int, string>> */
    private static array $cache = [];

    /**
     * @return array<int, string>
     */
    public static function hexadecimal(): array
    {
        return self::$cache['hexadecimal'] ??= [
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function numeric(): array
    {
        return self::$cache['numeric'] ??= [
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function special(): array
    {
        return self::$cache['special'] ??= [
            '!',
            '"',
            '#',
            '$',
            '%',
            '&',
            '\'',
            '(',
            ')',
            '*',
            '+',
            ',',
            '-',
            '.',
            '/',
            ':',
            ';',
            '<',
            '=',
            '>',
            '?',
            '@',
            '[',
            '\\',
            ']',
            '^',
            '_',
            '`',
            '{',
            '|',
            '}',
            '~',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function german(): array
    {
        return self::$cache['german'] ??= [
            'ä',
            'ö',
            'ü',
            'Ä',
            'Ö',
            'Ü',
            'ß',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function nonexplosives(): array
    {
        return self::$cache['nonexplosives'] ??= Arrays::removeFromSet(
            self::lowercase(),
            [
                ...self::explosives(),
                ...self::vowels(),
            ],
        );
    }

    /**
     * @return array<int, string>
     */
    public static function lowercase(): array
    {
        return self::$cache['lowercase'] ??= range('a', 'z');
    }

    /**
     * @return array<int, string>
     */
    public static function uppercase(): array
    {
        return self::$cache['uppercase'] ??= range('A', 'Z');
    }

    /**
     * @return array<int, string>
     */
    public static function alphanumeric(): array
    {
        return self::$cache['alphanumeric'] ??= [
            ...self::lowercase(),
            ...self::uppercase(),
            ...self::numeric(),
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function explosives(): array
    {
        return self::$cache['explosives'] ??= [
            'b',
            'd',
            'g',
            'k',
            'p',
            't',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function vowels(): array
    {
        return self::$cache['vowels'] ??= [
            'a',
            'e',
            'i',
            'o',
            'u',
        ];
    }

    /**
     * @return array<int, string>
     */
    public static function whitespace(): array
    {
        return self::$cache['whitespace'] ??= [
            "\r",
            "\n",
            "\t",
            ' ',
        ];
    }
}
