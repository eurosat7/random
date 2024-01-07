<?php

declare(strict_types=1);

namespace Eurosat7\Random;

use Random\RandomException;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class Shuffle
{
    /**
     * Fisher–Yates
     *
     * @param array<int, string> $set
     *
     * @return array<int, string>
     *
     * @throws RandomException
     */
    public static function shuffle(array $set): array
    {
        $len = count($set) - 1;
        for ($b = $len; $b > 0; $b--) {
            $a = random_int(0, $b);
            [$set[$a], $set[$b]] = [$set[$b], $set[$a]];
        }
        return $set;
    }
}
