<?php

use PHPUnit\Framework\TestCase;
use TaskOne\DirectoryCalculator;

class TaskOneTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        mkdir(__DIR__ . '/dir_1');
        mkdir(__DIR__ . '/dir_2');
        mkdir(__DIR__ . '/dir_3');
        mkdir(__DIR__ . '/dir_4');

        file_put_contents(__DIR__ . '/dir_1/11.txt', 1); //1
        file_put_contents(__DIR__ . '/dir_1/12.txt', 2); //3

        mkdir(__DIR__ . '/dir_1/dir_11');
        file_put_contents(__DIR__ . '/dir_1/dir_11/111.txt', 3); //6
        file_put_contents(__DIR__ . '/dir_1/dir_11/112.txt', 'blablatext'); //6
        mkdir(__DIR__ . '/dir_1/dir_11/dir_111');
        file_put_contents(__DIR__ . '/dir_1/dir_11/dir_111/1111.txt', '4'); //10

        file_put_contents(__DIR__ . '/dir_2/21.txt', 5); //15
        file_put_contents(__DIR__ . '/dir_2/22.txt', 6); //21
        file_put_contents(__DIR__ . '/dir_2/23.txt', 7); //28
        file_put_contents(__DIR__ . '/dir_2/24.txt', -1); //27

        file_put_contents(__DIR__ . '/dir_3/31.txt', -0.5); //26.5
        file_put_contents(__DIR__ . '/dir_3/32.txt', 0.5); //27
    }

    public function testTaskOne()
    {
        $directories = [
            __DIR__ . '/dir_1',
            __DIR__ . '/dir_2',
            __DIR__ . '/dir_3',
            __DIR__ . '/dir_4'
        ];

        $count = array_reduce($directories, [DirectoryCalculator::class, 'calculate'], 0);

        $this->assertEquals($count, (float) 27);

        $twiceDirectories = array_merge($directories, $directories);

        $count = array_reduce($twiceDirectories, [DirectoryCalculator::class, 'calculate'], 0);

        $this->assertEquals($count, (float) 54);

    }

    public function tearDown(): void
    {
        parent::tearDown(); // TODO: Change the autogenerated stub
        
        $this->removeAll(__DIR__ . '/dir_1');
        $this->removeAll(__DIR__ . '/dir_2');
        $this->removeAll(__DIR__ . '/dir_3');
        $this->removeAll(__DIR__ . '/dir_4');
    }
    
    protected function removeAll($dir)
    {
        if (substr($dir, strlen($dir) - 1, 1) != '/') {
            $dir .= '/';
        }
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::removeAll($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dir);
    }
}