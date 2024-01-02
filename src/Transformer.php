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
     * @param string[] $set
     * @return string[]
     */
    public static function setToLowercase(array $set): array
    {
        return array_map(
            fn(string $value): string => strtolower($value),
            $set
        );
    }

    /**
     * @param string[] $set
     * @return string[]
     */
    public static function setToUppercase(array $set): array
    {
        return array_map(
            fn(string $value): string => strtoupper($value),
            $set
        );
    }

    /**
     * @param string[] $set
     * @return string[]
     * @throws RandomException
     */
    public static function setToRandomcase(array $set): array
    {
        return array_map(
            fn(string $value): string => random_int(0, mt_getrandmax()) % 2 === 0 ? strtoupper($value) : strtolower($value),
            $set
        );
    }

    /**
     * @param string[] $set
     * @param string[] $unwanted
     * @return string[]
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
     * @param string[] $in
     */
    public function arrayToString(array $in): string
    {
        return implode('', $in);
    }

    /**
     * @return string[]
     */
    public function stringToArray(string $in): array
    {
        return str_split($in);
    }

}