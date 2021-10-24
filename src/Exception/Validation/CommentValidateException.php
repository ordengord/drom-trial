<?php

namespace CommentService\Exception\Validation;

use CommentService\Exception\AbstractCommentServiceException;

class CommentValidateException extends AbstractCommentServiceException
{
    protected const PREFIX_MESSAGE = "Ошибки при проверке комментария";
}