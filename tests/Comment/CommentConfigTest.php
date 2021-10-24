<?php

use PHPUnit\Framework\TestCase;
use CommentService\Comment\CommentConfig;
use CommentService\Comment\BaseComment;

class CommentConfigTest extends TestCase
{
    public function testConfig()
    {
        $commentConfig = new CommentConfig([
            'class' => CommentService\Comment\BaseComment::class,
        ]);
        $this->assertEquals($commentConfig->className, BaseComment::class);
    }

}