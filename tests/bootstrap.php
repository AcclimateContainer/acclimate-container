<?php

// Ensure PHP 5.4+ for testing
if (PHP_VERSION_ID < 50400) {
    die('Please use PHP 5.4+ for testing. Currently, you are using PHP ' . PHP_VERSION . '.');
}

$reportingLevel = error_reporting();
error_reporting($reportingLevel ^ E_USER_WARNING);

// Include Composer autoloader
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->addPsr4('Acclimate\\Container\\Test\\', __DIR__);
