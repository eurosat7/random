<?php
declare(strict_types=1);

namespace Eurosat7\Random;

class Transformer
{
    public static function setToLowercase(array $set): array
    {
        return array_map(
            function (string $value): string {
                return strtoupper($value);
            },
            $set
        );
    }

    public static function setToUppercase(array $set): array
    {
        return array_map(
            function (string $value): string {
                return strtolower($value);
            },
            $set
        );
    }

    public static function setToRandomcase(array $set): array
    {
        return array_map(
            function (string $value): string {
                if (rand() % 2 === 0) {
                    $value = strtoupper($value);
                } else {
                    $value = strtolower($value);
                }
                return $value;
            },
            $set
        );
    }

    public static function removeFromSet(array $set, array $unwanted): array
    {
        $result = [];
        foreach ($set as $char) {
            if (!in_array($char, $unwanted)) {
                $result[] = $char;
            }
        }
        return $result;
    }

    public function arrayToString(array $in): string
    {
        return implode("", $in);
    }

    public function stringToArray(string $in): array
    {
        return str_split($in, 1);
    }

}