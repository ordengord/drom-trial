<?php

namespace CommentService\ServerRequest;

use CommentService\Exception\ServerRequestException;
use CommentService\Exception\ServerResponseException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class CommentRequest
{
    protected Client $client;
    protected ServerRequestConfig $config;
    protected string $targetRoute;

    public function __construct(ServerRequestConfig $config, string $targetRoute)
    {
        $this->config = $config;
        $this->client = new Client(['base_uri' => $this->config->getHost()]);
        $this->targetRoute = $targetRoute;
    }

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
    public function parseResponse(Response $response)
    {
        if (!in_array(
            $response->getStatusCode(),
            $this->config->route($this->targetRoute)->successCodes
        ))
            throw new ServerResponseException();

        //TODO Сервер может и не в json-е возращать
        return json_decode($response->getBody(), true);
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

}