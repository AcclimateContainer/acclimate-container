<?php

if (PHP_VERSION_ID < 50400) {
    die('Please use PHP 5.4 or later for testing. Currently, you are using PHP ' . PHP_VERSION . '.');
}

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Jeremeamia\Acclimate\Test', __DIR__);
