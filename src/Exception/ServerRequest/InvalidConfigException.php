<?php

namespace CommentService\Exception;

class InvalidConfigException extends AbstractCommentServiceException
{
    protected const PREFIX_MESSAGE = "Ошибка настроек (конфиг-файл)";
}