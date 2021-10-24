<?php

use PHPUnit\Framework\TestCase;
use CommentService\ServerRequest\ServerRequestConfig;

class ServerRequestConfigTest extends TestCase
{
    public function testRequestConfig()
    {
        $config = self::getServerConfig();

        $config = new ServerRequestConfig($config);

        /*
         * Было интересно посмотреть сколько % покрытия получится
         * на работе бы такое точно не стал писать
         */
        $this->assertEquals($config->getResponseType(), 'json');

        $this->assertEquals(count($config->getCommonHeaders()), 2);
    }

    public static function getServerConfig(): array
    {
        return [
            'host' => 'http://example.com',
            'headers' => [
                'X-Real-IP' => '10.10.10.10',
                'Authorization: cghjgcsadghfhjghjfghgj'
            ],
            'routes' => [
                'index' => [
                    'uri' => '/comments',
                    'method' => 'GET',
                    'headers' => [],
                    'success_codes' => [200]
                ],
                'create' => [
                    'uri' => '/comment',
                    'method' => 'POST',
                    'headers' => [
                        'Content-Type: application/json'
                    ],
                    'success_codes' => [200, 201]
                ],
                'update' => [
                    'uri' => '/comment/{id}',
                    'method' => 'PUT',
                    'headers' => [
                        'Content-Type: application/json'
                    ],
                    'success_codes' => [200]
                ]
            ],
            'response_type' => 'json'
        ];
    }
}