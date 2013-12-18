<?php

echo "here\n";

// Ensure PHP 5.4+ for testing
if (PHP_VERSION_ID < 50400) {
    die('Please use PHP 5.4+ for testing. Currently, you are using PHP ' . PHP_VERSION . '.');
}

// Include Composer autoloader
$loader = require __DIR__ . '/../vendor/autoload.php';

// Register another PSR-4-compliant autoloader for loading test classes
spl_autoload_register(function ($fqcn) {
    $prefix = 'Acclimate\\Container\\Test\\';
    $baseDir = __DIR__ . '/';

    $prefixLength = strlen($prefix);
    if (strncmp($prefix, $fqcn, $prefixLength) !== 0) {
        // Class doesn't match prefix
        return;
    }

    $className = substr($fqcn, $prefixLength);
    $filePath = $baseDir . str_replace('\\', '/', $className) . '.php';
    if (is_readable($filePath)) {
        require $filePath;
    }
});
