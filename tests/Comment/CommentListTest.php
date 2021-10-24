<?php

use CommentService\Comment\CommentList;
use CommentService\Comment\BaseComment;
use PHPUnit\Framework\TestCase;

class CommentListTest extends TestCase
{
    public function testInit()
    {
        $commentsData = [
            [
                'id' => 1,
                'name' => "Комментарий один",
                'text' => 'Комментаридзе'
            ],
            [
                'id' => 2,
                'name' => "Комментарий два",
                'text' => 'Комментаридзедва'
            ],
            [
                'id' => 2,
                'name' => "Комментарий два",
                'text' => 'Комментаридзедва'
            ]
        ];

        $list = new CommentList(BaseComment::class, $commentsData);

        $this->assertSame($list->count(), 3);
    }
}