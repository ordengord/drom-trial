<?php

namespace TaskOne;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;

class DirectoryCalculator
{
    public static function calculate(float $count, string $directory)
    {
        $directoryIterator = new RecursiveDirectoryIterator($directory);
        $iterator = new RecursiveIteratorIterator($directoryIterator);

        foreach ($iterator as $fileInfo) {
            if ($fileInfo->isDir())
                continue;

            try {
                $fileObject = $fileInfo->openFile();
                $fileContent = $fileObject->fread($fileObject->getSize());
            } catch (Throwable $exception) {
                continue;
            }

            if (!is_numeric($fileContent))
                continue;

            $count += $fileContent;
        }

        return $count;
    }
}