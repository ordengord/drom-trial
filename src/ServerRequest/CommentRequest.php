<?php

namespace CommentService\ServerRequest;

use CommentService\Comment\CommentInterface;
use CommentService\CommentService;
use CommentService\Exception\ServerRequestException;
use CommentService\Exception\ServerResponseException;
use CommentService\Serializer\CommentSerializerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class CommentRequest
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * Настройки связанные с обращением к серверу
     * @var ServerRequestConfig
     */
    protected ServerRequestConfig $config;

    private CommentSerializerInterface $serializer;

    /**
     * Целевой урл (create/update/index)
     * @var string
     */
    protected string $targetRoute;

    /**
     * @param ServerRequestConfig $config
     * @param string $targetRoute
     */
    public function __construct(
        ServerRequestConfig $config,
        string $targetRoute,
        CommentSerializerInterface $serializer
    ) {
        $this->config = $config;
        $this->client = new Client(['base_uri' => $this->config->getHost()]);
        $this->targetRoute = $targetRoute;
        $this->serializer = $serializer;
    }

    /**
     * Выполняет запрос на сервер
     * @param array|null $bodyData
     * @return Response
     * @throws ServerRequestException
     */
    public function execute(?array $bodyData = null): Response
    {
        $routeConfig = $this->config->route($this->targetRoute);

        $options = $this->buildOptions($bodyData);// Отдельный класс

        try {
            return $this->client->request(
                $routeConfig->requestMethod,
                $routeConfig->uri,
                $options
            );
        } catch (GuzzleException $exception) {
            throw new ServerRequestException($exception->getMessage());
        }
    }

    /**
     * @param array|null $bodyData
     * @return array
     * @throws ServerRequestException
     */
    protected function buildOptions(?array $bodyData)
    {
        $options = [
            'headers' => array_merge(
                $this->config->getCommonHeaders(),
                $this->config->route($this->targetRoute)->headers
            )
        ];

        if ($bodyData)
            $options['json'] = $bodyData;

        return $options;
    }

    /**
     * @param Response $response
     * @return array
     */
    public function parseResponse(Response $response): CommentInterface
    {
        if (!in_array(
            $response->getStatusCode(),
            $this->config->route($this->targetRoute)->successCodes
        )) {
            throw new ServerResponseException();
        }

        $stringBody = $response->getBody();

        return $this->targetRoute === CommentService::INDEX_ROUTE_NAME
            ? $this->serializer->deserializeArray($stringBody)
            : $this->serializer->deserialize($stringBody);
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

}