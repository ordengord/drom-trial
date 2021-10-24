<?php

namespace CommentService\Exception;

use Exception;
use Throwable;

abstract class AbstractCommentServiceException extends Exception
{
    protected const PREFIX_MESSAGE = "Некорректная информация в настройках сервера";

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = static::PREFIX_MESSAGE . ": " . $message;
    }
}