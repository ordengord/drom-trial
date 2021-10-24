<?php

namespace CommentService;

use CommentService\Exception\ServerResponseException;
use CommentService\ServerRequest\CommentRequest;
use CommentService\Comment\CommentInterface;
use CommentService\Comment\CommentList;

class CommentService
{
    protected const DEFAULT_CONFIG_PATH = __DIR__ . '/../../config/config.php';

    public const INDEX_ROUTE_NAME = 'index';

    public const CREATE_ROUTE_NAME = 'create';

    public const UPDATE_ROUTE_NAME = 'update';

    protected Config $config;

    public function __construct(?array $config = null)
    {
        $config = $config ?: $this->withDefaultConfig();
        $this->config = new Config($config);
    }

    protected function withDefaultConfig()
    {
        return require_once self::DEFAULT_CONFIG_PATH;
    }

    public function index(): CommentList
    {
        $request = $this->createRequest(self::INDEX_ROUTE_NAME);
        $response = $request->execute();
        return new CommentList(
            $this->config->comment()->className,
            $request->parseResponse($response)
        );
    }

    /**
     * Здесь неясно какой ответ возвращает сервер, но ожидаю вариант с возвращением id нового ресурса
     * в формате id: 1
     * Если бы я не чувствовал, что итак все несказанно переусложнил - реализовал бы проверки ^^
     * @param array $commentData
     */
    public function create(array $commentData): CommentInterface
    {
        $commentClassName = $this->config->comment()->className;
        $comment = new $commentClassName($commentData);

        $request = $this->createRequest(self::CREATE_ROUTE_NAME);
        $response = $request->execute( $comment->toRequestArray());

        $newCommentId = $request->parseResponse($response)['id'];

        $comment->setId($newCommentId);

        return $comment;
    }

    /**
     * @param array $commentData
     * @return CommentInterface
     * @throws \CommentService\Exception\ServerRequestException
     */
    public function update(array $commentData): CommentInterface
    {
        $commentClassName = $this->config->comment()->className;
        $comment = new $commentClassName($commentData);

        $routeConfig = $this->config->server()->route(self::UPDATE_ROUTE_NAME);
        $routeConfig->uri = str_replace('{id}', $comment->getId(), $routeConfig->uri);

        $this->config->server()->setRouteConfig(self::UPDATE_ROUTE_NAME, $routeConfig);

        $request = $this->createRequest(self::UPDATE_ROUTE_NAME);
        $response = $request->execute($comment->toRequestArray());

        return $request->parseResponse($response)
            ? $comment
            : throw new ServerResponseException();
    }

    /**
     * @param string $targetMethod
     * @return CommentRequest
     */
    protected function createRequest(string $targetMethod): CommentRequest
    {
        return new CommentRequest($this->config->server(), $targetMethod);
    }
}