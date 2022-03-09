<?php

declare(strict_types=1);

namespace CommentService\Serializer;

use CommentService\Comment\BaseComment;
use CommentService\Comment\CommentInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class JsonCommentSerializer implements CommentSerializerInterface
{
    public function serialize(CommentInterface $comment): string
    {
        return $this->getSerializer()->serialize($comment, 'json');
    }

    public function deserialize(string $commentData): CommentInterface
    {
        return $this->getSerializer()->deserialize($commentData, BaseComment::class, 'json');
    }

    /**
     * @param string $commentsData
     * @return CommentInterface[]
     */
    public function deserializeArray(string $commentsData): array
    {
        return $this->getSerializer()->deserialize(
            $commentsData,
            'CommentService\Comment\BaseComment\BaseComment[]',
            'json'
        );
    }

    private function getSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        return new Serializer($normalizers, $encoders);
    }
}