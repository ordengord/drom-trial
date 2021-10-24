<?php

namespace CommentService\Exception;

class ServerResponseException extends AbstractCommentServiceException
{
    protected const PREFIX_MESSAGE = "Ошибка на стороне сервера: ";
}