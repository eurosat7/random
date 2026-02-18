<?php

declare(strict_types=1);

namespace Eurosat7\Random;

class Charsets
{
    /**
     * @return array<int, string>
     */
    public static function hexadecimal(): array
    {
        return [
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
        return [
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
        return [
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
        return [
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
        return Arrays::removeFromSet(
            self::lowercase(),
            [
                ... self::explosives(),
                ... self::vowels(),
            ],
        );
    }

    /**
     * @return array<int, string>
     */
    public static function lowercase(): array
    {
        return range('a', 'z');
    }

    /**
     * @return array<int, string>
     */
    public static function uppercase(): array
    {
        return range('A', 'Z');
    }

    /**
     * @return array<int, string>
     */
    public static function alphanumeric(): array
    {
        return [
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
        return [
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
        return [
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
        return [
            "\r",
            "\n",
            "\t",
            ' ',
        ];
    }
}
