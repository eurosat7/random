<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Eurosat7\Random\Exception\OutOfRandomException;
use Throwable;

class Shuffle
{
    /**
     * Fisher–Yates
     *
     * @param array<int, string> $set
     *
     * @return array<int, string>
     *
     * @throws OutOfRandomException
     */
    public static function shuffle(array $set): array
    {
        $len = count($set) - 1;
        for ($b = $len; $b > 0; $b--) {
            try {
                $a = random_int(0, $b);
            } catch (Throwable $e) {
                throw new OutOfRandomException($e->getMessage(), (int) $e->getCode(), $e);
            }
            [$set[$a], $set[$b]] = [$set[$b], $set[$a]];
        }
        return $set;
    }
}
