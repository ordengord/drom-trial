<?php

namespace CommentService\ServerRequest;

use CommentService\Exception\ServerRequestException;

/**
 * Класс содержащий информацию о сервере на который передаются комментарии
 */
class ServerRequestConfig
{
    const DEFAULT_HOST = 'http://example.com';

    /**
     * @var string url
     */
    protected string $host;

    /**
     * Заголовки http Запроса, используемые повсеместно
     * при обращении к этому серверу
     * @var array
     */
    protected array $commonHeaders;

    /**
     * Характеризует тип ответа сервера -
     * на момент написания только json, но мб еще xml опишу
     * @var string
     */
    protected string $responseType;

    /**
     * Информация о конкретных роутах и их настройках
     * @var RouteConfig[]
     */
    protected array $routes;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->host = $config['host'] ?? self::DEFAULT_HOST;
        $this->commonHeaders = $config['headers'] ?? [];
        foreach ($config['routes'] as $targetName => $route) {
            $this->routes[$targetName] = new RouteConfig($route);
        }
        $this->responseType = $config['response_type'];
    }

    /**
     * @return mixed|string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return array|mixed
     */
    public function getCommonHeaders(): array
    {
        return $this->commonHeaders;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    /**
     * @param string $routeName
     * @return RouteConfig
     * @throws ServerRequestException
     */
    public function route(string $routeName): RouteConfig
    {
        return $this->routes[$routeName] ?? throw new ServerRequestException('Метод не существует');
    }

    /**
     * @param string $routeName
     * @param RouteConfig $routeConfig
     */
    public function setRouteConfig(string $routeName, RouteConfig $routeConfig)
    {
        $this->routes[$routeName] = $routeConfig;
    }

}