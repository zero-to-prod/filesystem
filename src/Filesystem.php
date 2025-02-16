<?php

namespace Zerotoprod\Filesystem;

use DirectoryIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class Filesystem
{

    public static function getFilesByExtension(string $directory, string $extension): array
    {
        $files = [];

        /** @var SplFileInfo $SplFileInfo */
        foreach (new DirectoryIterator($directory) as $SplFileInfo) {
            if (!$SplFileInfo->isDot() && !$SplFileInfo->isDir() && $SplFileInfo->getExtension() === $extension) {
                $files[$SplFileInfo->getFilename()] = $SplFileInfo;
            }
        }

        return $files;
    }

    public static function getFilesByExtensionRecursive(string $directory, string $extension): array
    {
        $files = [];
        $RecursiveIteratorIterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );

        /** @var SplFileInfo $fileInfo */
        foreach ($RecursiveIteratorIterator as $SplFileInfo) {
            if (!$SplFileInfo->isDir() && $SplFileInfo->getExtension() === $extension) {
                $files[$SplFileInfo->getFilename()] = $SplFileInfo;
            }
        }

        return $files;
    }
}