<?php

declare(strict_types=1);

$files = [
    __DIR__ . '/Arrays.php',
    __DIR__ . '/Charsets.php',
    __DIR__ . '/Transformer.php',
    __DIR__ . '/Exception/EmptySetException.php',
    __DIR__ . '/Exception/LogicException.php',
    __DIR__ . '/Exception/OutOfRandomException.php',
];

foreach ($files as $file) {
    if (is_file($file)) {
        opcache_compile_file($file);
    }
}
