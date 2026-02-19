<?php

declare(strict_types=1);

$files = [
    __DIR__ . '/src/Arrays.php',
    __DIR__ . '/src/Charsets.php',
    __DIR__ . '/src/Transformer.php',
    __DIR__ . '/src/Exception/EmptySetException.php',
    __DIR__ . '/src/Exception/LogicException.php',
    __DIR__ . '/src/Exception/OutOfRandomException.php',
];

foreach ($files as $file) {
    if (is_file($file)) {
        opcache_compile_file($file);
    }
}
