<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Eurosat7\Random\Charsets;
use Eurosat7\Random\Transformer;
use Eurosat7\Random\Arrays;

function benchmark(string $name, callable $callable, int $iterations = 10000): void
{
    // warmup run to populate caches and trigger JIT compilation
    for ($i = 0; $i < 100; $i++) {
        $callable();
    }

    gc_collect_cycles();
    $startTime = microtime(true);
    $startMemory = memory_get_usage();

    for ($i = 0; $i < $iterations; $i++) {
        $callable();
    }

    $endTime = microtime(true);
    $endMemory = memory_get_usage();
    $peakMemory = memory_get_peak_usage();

    printf("Benchmark: %s\n", $name);
    printf("Iterations: %d\n", $iterations);
    printf("Time: %.6f seconds\n", $endTime - $startTime);
    printf("Memory Usage Change: %d bytes\n", $endMemory - $startMemory);
    printf("Peak Memory: %d bytes\n", $peakMemory);
    echo "-----------------------------------\n";
}

echo "Starting Benchmarks...\n\n";

benchmark('Charsets::alphanumeric', static function () {
    Charsets::alphanumeric();
}, 100000);

benchmark('Charsets::nonexplosives', static function () {
    Charsets::nonexplosives();
}, 100000);

// pre-compute the charset outside the loop to benchmark only the transformation
$alphanumericSet = Charsets::alphanumeric();

benchmark('Transformer::toRandomcase (alphanumeric)', static function () use ($alphanumericSet) {
    Transformer::toRandomcase($alphanumericSet);
}, 10000);

benchmark('Arrays::pickOne (alphanumeric)', static function () use ($alphanumericSet) {
    Arrays::pickOne($alphanumericSet);
}, 100000);
