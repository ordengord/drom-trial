<?php

require_once __DIR__ . '/vendor/autoload.php';

use TaskOne\DirectoryCalculator;

$default = __DIR__;

$directoriesList = array_slice($argv, 1);

$directoriesList = array_filter($directoriesList, 'is_dir');

if (empty($directoriesList))
    $directoriesList = array($default);

$count = array_reduce($directoriesList, [DirectoryCalculator::class, 'calculate'], 0);

echo $count . PHP_EOL;
