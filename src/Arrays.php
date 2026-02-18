<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Eurosat7\Random\Exception\EmptySetException;
use Eurosat7\Random\Exception\LogicException;
use Eurosat7\Random\Exception\OutOfRandomException;
use Throwable;

class Arrays
{
    /**
     * @param array<int, string> $set
     * @param array<int, string> $unwanted
     *
     * @return array<int, string>
     */
    public static function removeFromSet(array $set, array $unwanted): array
    {
        return array_values(array_diff($set, $unwanted));
    }

    /**
     * @param array<int, string> $set
     *
     * @throws LogicException
     */
    public static function pickOne(array $set): string
    {
        $max = count($set) - 1;
        if ($max < 0) {
            throw new EmptySetException('set must not be empty');
        }
        try {
            $index = random_int(0, $max);
        } catch (Throwable $e) {
            throw new OutOfRandomException($e->getMessage(), (int) $e->getCode(), $e);
        }

        return $set[$index];
    }
}
