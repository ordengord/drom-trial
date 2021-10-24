<?php

namespace CommentService\Exception;

class ServerRequestException extends AbstractCommentServiceException
{
    protected const PREFIX_MESSAGE = "Не удалось отправить запрос на сервер";
}