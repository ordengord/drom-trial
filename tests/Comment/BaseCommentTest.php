<?php

use CommentService\Comment\BaseComment;
use PHPUnit\Framework\TestCase;
use CommentService\Exception\Validation\CommentValidateException;

class BaseCommentTest extends TestCase
{
    public function testValidationOk()
    {
        $commentData = [
            'text' => 'Пыщ пыщ комментарий',
            'name' => 'Первый'
        ];

        $comment = new BaseComment($commentData);

        $this->assertEquals(
            $comment->getName(),
            'Первый'
        );

        $this->assertTrue(is_null($comment->getId()));
    }

    public function testValidationFailed()
    {
        $commentData = [
            'text' => 'Пыщ пыщ комментарий',
            'id' => 124
        ];

        $this->expectException(CommentValidateException::class);

        $comment = new BaseComment($commentData);
    }
}