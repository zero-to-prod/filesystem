<?php
/** @noinspection PhpParamsInspection */

namespace Tests\Unit;

use org\bovigo\vfs\vfsStream;
use SplFileInfo;
use Tests\TestCase;
use Zerotoprod\Filesystem\Filesystem;

class GetFilesByExtensionTest extends TestCase
{
    private $root;

    protected function setUp(): void
    {
        $structure = [
            'documents' => [
                'test1.txt' => 'content1',
                'test2.txt' => 'content2',
                'test.pdf' => 'pdf content',
                'test.doc' => 'doc content',
                'noextension' => 'no extension content',
                'hidden.txt' => 'hidden content',
                'subdirectory' => [
                    'subfile.txt' => 'sub content'
                ]
            ]
        ];

        $this->root = vfsStream::setup('root', 0755, $structure);
    }

    /** @test */
    public function finds_files_with_specific_extension(): void
    {
        $files = Filesystem::getFilesByExtension(
            vfsStream::url('root/documents'),
            'txt'
        );

        $this->assertCount(3, $files);
        foreach ($files as $file) {
            $this->assertInstanceOf(SplFileInfo::class, $file);
        }

        $this->assertArrayHasKey('test1.txt', $files);
        $this->assertArrayHasKey('test2.txt', $files);
        $this->assertArrayHasKey('hidden.txt', $files);
    }

    /** @test */
    public function returns_empty_array_for_non_existent_extension(): void
    {
        $files = Filesystem::getFilesByExtension(
            vfsStream::url('root/documents'),
            'xyz'
        );

        $this->assertEmpty($files);
    }

    /** @test */
    public function ignores_subdirectories(): void
    {
        $files = Filesystem::getFilesByExtension(
            vfsStream::url('root/documents'),
            'txt'
        );

        $this->assertArrayNotHasKey('subfile.txt', $files);
    }

    /** @test */
    public function handles_empty_directory(): void
    {
        vfsStream::newDirectory('empty', 0755)->at($this->root);

        $files = Filesystem::getFilesByExtension(
            vfsStream::url('root/empty'),
            'txt'
        );

        $this->assertEmpty($files);
    }

    /** @test */
    public function handles_different_extension_case(): void
    {
        vfsStream::newFile('test.TXT')
            ->at($this->root->getChild('documents'))
            ->setContent('uppercase extension');

        $files = Filesystem::getFilesByExtension(
            vfsStream::url('root/documents'),
            'txt'
        );

        $this->assertArrayNotHasKey('test.TXT', $files);
    }
}