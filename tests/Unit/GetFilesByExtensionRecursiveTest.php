<?php

namespace Tests\Unit;

use org\bovigo\vfs\vfsStream;
use SplFileInfo;
use Tests\TestCase;
use UnexpectedValueException;
use Zerotoprod\Filesystem\Filesystem;

class GetFilesByExtensionRecursiveTest extends TestCase
{
    private $root;
    private $testStructure = [
        'test_dir' => [
            'file1.txt' => 'content1',
            'file2.txt' => 'content2',
            'document.pdf' => 'pdf content',
            'image.jpg' => 'jpg content',
            'subdir' => [
                'file3.txt' => 'content3',
                'another.pdf' => 'more pdf content',
                'nested' => [
                    'deep.txt' => 'deep content'
                ]
            ],
            'empty_dir' => []
        ]
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->root = vfsStream::setup('root', null, $this->testStructure);
    }

    /** @test */
    public function basic_functionality(): void
    {
        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            'txt'
        );

        $this->assertCount(4, $result);
        $fileNames = array_map(static function ($file) {
            return $file->getFilename();
        }, $result);

        $this->assertContains('file1.txt', $fileNames);
        $this->assertContains('file2.txt', $fileNames);
        $this->assertContains('file3.txt', $fileNames);
        $this->assertContains('deep.txt', $fileNames);
    }

    /** @test */
    public function empty_directory(): void
    {
        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir/empty_dir',
            'txt'
        );

        $this->assertEmpty($result);
    }

    /** @test */
    public function file_names_are_used_as_array_keys(): void
    {
        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            'txt'
        );

        $this->assertArrayHasKey('file1.txt', $result);
        $this->assertArrayHasKey('file2.txt', $result);
        $this->assertArrayHasKey('file3.txt', $result);
        $this->assertArrayHasKey('deep.txt', $result);

        foreach ($result as $file) {
            $this->assertInstanceOf(SplFileInfo::class, $file);
        }
    }

    /** @test */
    public function no_matching_files(): void
    {
        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            'xyz'
        );

        $this->assertEmpty($result);
    }

    /** @test */
    public function specific_extension(): void
    {
        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            'pdf'
        );

        $this->assertCount(2, $result);
        $fileNames = array_map(static function ($file) {
            return $file->getFilename();
        }, $result);

        $this->assertContains('document.pdf', $fileNames);
        $this->assertContains('another.pdf', $fileNames);
    }

    /** @test */
    public function empty_extension(): void
    {
        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            ''
        );

        $this->assertEmpty($result);
    }

    /** @test */
    public function non_existent_directory(): void
    {
        $this->expectException(UnexpectedValueException::class);

        Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/non_existent_dir',
            'txt'
        );
    }

    /** @test */
    public function case_sensitive_extension(): void
    {
        vfsStream::create([
            'test_dir' => [
                'uppercase.TXT' => 'uppercase content'
            ]
        ], $this->root);

        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            'txt'
        );

        $fileNames = array_map(static function ($file) {
            return $file->getFilename();
        }, $result);

        $this->assertNotContains('uppercase.TXT', $fileNames);
    }

    /** @test */
    public function directory_with_special_characters(): void
    {
        vfsStream::create([
            'test_dir' => [
                'special@#$' => [
                    'special.txt' => 'special content'
                ]
            ]
        ], $this->root);

        $result = Filesystem::getFilesByExtensionRecursive(
            $this->root->url().'/test_dir',
            'txt'
        );

        $fileNames = array_map(static function ($file) {
            return $file->getFilename();
        }, $result);

        $this->assertContains('special.txt', $fileNames);
    }
}