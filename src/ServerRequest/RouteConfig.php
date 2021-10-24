<?php

namespace CommentService\ServerRequest;

use CommentService\Exception\InvalidConfigException;

class RouteConfig
{
    /**
     * uri Обращения к серверу
     * @var string
     */
    protected string $uri;

    /**
     * Метод
     * @var string
     */
    protected string $requestMethod;

    /**
     * Хедеры только этого роута
     * @var array
     */
    protected array $headers;

    /**
     * Статус-коды успеха ответа сервера по этому роуту
     * @var array
     */
    protected array $successCodes = [];

    /**
     * @param array $routeData
     */
    public function __construct(array $routeData)
    {
        $this->uri = $routeData['uri'];
        $this->requestMethod = $routeData['method'];
        $this->headers = $routeData['headers'];
        $this->successCodes = $routeData['success_codes'];
    }

    /**
     * @param string $attribute
     * @return mixed
     * @throws InvalidConfigException
     */
    public function __get(string $attribute)
    {
        return property_exists($this, $attribute)
            ? $this->$attribute
            : throw new InvalidConfigException('Не существующее свойство класса');
    }

    /**
     * @param string $targetAttribute
     * @param mixed $targetValue
     * @throws InvalidConfigException
     */
    public function __set(string $targetAttribute, mixed $targetValue)
    {
        if (!property_exists($this, $targetAttribute))
            throw new InvalidConfigException('Не существующее свойство класса');

        if (gettype($this->$targetAttribute) !== gettype($targetValue))
            throw new InvalidConfigException('Несоответствие типов изменяемого значения');

        $this->$targetAttribute = $targetValue;
    }
}