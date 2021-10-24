<?php

namespace CommentService;

use CommentService\ServerRequest\ServerRequestConfig;
use CommentService\Comment\CommentConfig;

class Config
{
    protected CommentConfig $commentConfig;
    protected ServerRequestConfig $serverConfig;

    public function __construct(array $config)
    {
        $this->serverConfig = new ServerRequestConfig($config['server']);
        $this->commentConfig = new CommentConfig($config['commentary']);
    }

    public function server(): ServerRequestConfig
    {
        return $this->serverConfig;
    }

    public function comment(): CommentConfig
    {
        return $this->commentConfig;
    }
}