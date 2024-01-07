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
     * @param array<int, string> $set
     *
     * @return array<int, string>
     *
     * @throws RandomException
     */
    public static function shuffle(array $set): array
    {
        $len = count($set);
        for ($i = $len * 2; $i >= 0; $i--) {
            $a = random_int(0, $len);
            $b = random_int(0, $len);
            [$set[$a], $set[$b]] = [$set[$b], $set[$a]];
        }
        return $set;
    }
}
