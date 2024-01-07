<?php

declare(strict_types=1);

use Eurosat7\Random\Shuffle;

include(dirname(__DIR__) . '/vendor/autoload.php');

$set = [];
$f = 1;
for ($n = 0; $n < 5; $n++) {
    $set[] = $n . '';
    $f *= $n + 1;
    for ($m = 1; $m < 5; $m++) {
        testbias($set, 1000 * $f);
    }
    echo "\n\n";
}

/**
 * @throws \Random\RandomException
 */
function testbias(array $set, int $iterations): void
{
    $result = [];
    for ($i = 0; $i < $iterations; $i++) {
        $probe = Shuffle::shuffle(array_merge($set, []));
        $key = implode('-', $probe);
        $result[$key] = ($result[$key] ?? 0) + 1;
    }
    ksort($result);
    $max = max($result);
    $min = min($result);
    $avg = array_sum($result) / count($result);
    $result['deviation'] = deviation($result);
    $result['max'] = $max;
    $result['min'] = $min;
    $result['avg'] = $avg;
    var_export($result);
    echo "\n\n";
}

/**
 * @param array<string, int> $set
 */
function deviation(array $set): float
{

    $count = count($set);
    $average = array_sum($set) / $count;
    $deviation = 0;

    foreach ($set as $item) {
        $deviation += ($item - $average) * ($item - $average);

    }
    if ($count < 2) return 0.0;
    return sqrt((1 / ($count - 1)) * $deviation);
}
