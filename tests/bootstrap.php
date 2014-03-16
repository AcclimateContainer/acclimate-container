<?php

// Ensure PHP 5.4+ for testing
if (PHP_VERSION_ID < 50400) {
    die('Please use PHP 5.4+ for testing. Currently, you are using PHP ' . PHP_VERSION . '.');
}

// Include Composer autoloader
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Acclimate\\Container\\Test\\', __DIR__);
