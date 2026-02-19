<?php

require_once __DIR__ . '/vendor/autoload.php';

use Eurosat7\Random\Charsets;
use Eurosat7\Random\Transformer;
use Eurosat7\Random\Arrays;

function benchmark(string $name, callable $callable, int $iterations = 10000) {
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

benchmark('Charsets::alphanumeric', function() {
    Charsets::alphanumeric();
}, 100000);

benchmark('Charsets::nonexplosives', function() {
    Charsets::nonexplosives();
}, 100000);

benchmark('Transformer::toRandomcase (alphanumeric)', function() {
    $set = Charsets::alphanumeric();
    Transformer::toRandomcase($set);
}, 10000);

benchmark('Arrays::pickOne (alphanumeric)', function() {
    $set = Charsets::alphanumeric();
    Arrays::pickOne($set);
}, 100000);
