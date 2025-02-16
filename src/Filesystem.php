<?php

namespace Zerotoprod\Filesystem;

use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Filesystem
{
    public static function getFilesByExtensionRecursive(string $directory, string $extension): array
    {
        $files = [];
        $RecursiveIteratorIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );

        /** @var SplFileInfo $fileInfo */
        foreach ($RecursiveIteratorIterator as $fileInfo) {
            if (!$fileInfo->isDir() && $fileInfo->getExtension() === $extension) {
                $files[$fileInfo->getFilename()] = $fileInfo;
            }
        }

        return $files;
    }

    public static function getFilesByExtension(string $directory, string $extension): array
    {
        $files = [];

        /** @var SplFileInfo $fileInfo */
        foreach (new DirectoryIterator($directory) as $fileInfo) {
            if (!$fileInfo->isDot() && !$fileInfo->isDir() && $fileInfo->getExtension() === $extension) {
                $files[$fileInfo->getFilename()] = $fileInfo;
            }
        }

        return $files;
    }
}