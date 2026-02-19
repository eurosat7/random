<?php

declare(strict_types=1);

namespace Eurosat7\Random\Test;

use Eurosat7\Random\Shuffle;
use PHPUnit\Framework\TestCase;
use Throwable;

class ShuffleTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testShuffleResultContainsAllElements(): void
    {
        $set = ['a', 'b', 'c', 'd', 'e'];
        $shuffled = Shuffle::shuffle($set);

        self::assertCount(5, $shuffled);
        foreach ($set as $element) {
            self::assertContains($element, $shuffled);
        }
    }

    /**
     * @throws Throwable
     */
    public function testShuffleActuallyShuffles(): void
    {
        $set = range('a', 'z');
        $shuffled = Shuffle::shuffle($set);

        self::assertNotEquals($set, $shuffled, 'Shuffled set should not be equal to original set (with high probability)');
    }

    /**
     * @throws Throwable
     */
    public function testShuffleDistribution(): void
    {
        $set = ['1', '2', '3'];
        $iterations = 1000;
        $results = [];

        for ($i = 0; $i < $iterations; $i++) {
            $probe = Shuffle::shuffle($set);
            $key = implode('-', $probe);
            $results[$key] = ($results[$key] ?? 0) + 1;
        }

        // There are 3! = 6 possible permutations
        self::assertCount(6, $results, 'All possible permutations should be generated with enough iterations');

        $expectedAverage = $iterations / 6;
        $tolerance = $expectedAverage * 0.5; // High tolerance for statistical variance

        foreach ($results as $count) {
            self::assertGreaterThan($expectedAverage - $tolerance, $count);
            self::assertLessThan($expectedAverage + $tolerance, $count);
        }
    }
}
