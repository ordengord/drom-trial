<?php

declare(strict_types=1);

namespace CommentService\Serializer;

use CommentService\Comment\BaseComment;
use CommentService\Comment\CommentInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class XmlCommentSerializer implements CommentSerializerInterface
{
    public function serialize(CommentInterface $comment): string
    {
        return $this->getSerializer()->serialize($comment, 'xml');
    }

    public function deserialize(string $commentData): CommentInterface
    {
        return $this->getSerializer()->deserialize($commentData, BaseComment::class, 'xml');
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
            'xml'
        );
    }

    private function getSerializer(): Serializer
    {
        $encoders = [new XmlEncoder()];
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        return new Serializer($normalizers, $encoders);
    }
}