<?php

namespace CommentService\ServerRequest;

use CommentService\Exception\InvalidConfigException;

class RouteConfig
{
    protected string $uri;

    protected string $requestMethod;

    protected array $headers;

    protected array $successCodes = [];

    public function __construct(array $routeData)
    {
        $this->uri = $routeData['uri'];
        $this->requestMethod = $routeData['method'];
        $this->headers = $routeData['headers'];
        $this->successCodes = $routeData['success_codes'];
    }

    public function __get(string $attribute)
    {
        return property_exists($this, $attribute)
            ? $this->$attribute
            : throw new InvalidConfigException('Не существующее свойство класса');
    }

    public function __set(string $targetAttribute, mixed $targetValue)
    {
        if (!property_exists($this, $targetAttribute))
            throw new InvalidConfigException('Не существующее свойство класса');

        if (gettype($this->$targetAttribute) !== gettype($targetValue))
            throw new InvalidConfigException('Несоответствие типов изменяемого значения');

        $this->$targetAttribute = $targetValue;
    }
}