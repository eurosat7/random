<?php
declare(strict_types=1);

namespace Eurosat7\Random;

class Charsets
{
    /**
     * @return string[]
     */
    public static function numeric(): array
    {
        return range('0', '9');
    }

    /**
     * @return string[]
     */
    public static function alphanumeric(): array
    {
        return range('a', 'z');
    }

    /**
     * @return string[]
     */
    public static function special(): array
    {
        return [
            '!', '"', '#', '$', '%', '&', '\'', '(', ')', '*', '+', ',', '-', '.', '/', ':',
            ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~',
        ];
    }

    /**
     * @return string[]
     */
    public static function umlaut(): array
    {
        return [
            'ä', 'ö', 'ü', 'ß'
        ];
    }

    /**
     * @return string[]
     */
    public static function vowels(): array
    {
        return ['a', 'e', 'i', 'o', 'u'];
    }

    /**
     * @return string[]
     */
    public static function explosives(): array
    {
        return [
            ['b', 'd', 'g', 'k', 'p', 't']
        ];
    }

    /**
     * @return string[]
     */
    public static function nonexplosives(): array
    {
        return Transformer::removeFromSet(
            self::alphanumeric(),
            [... self::explosives(), ... self::vowels()]
        );
    }

    /**
     * @return string[]
     */
    public static function whitespace(): array
    {
        return ["\r", "\n", "\t", " "];
    }
}