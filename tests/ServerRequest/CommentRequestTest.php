<?php
//
//use PHPUnit\Framework\TestCase;
//use CommentService\ServerRequest\CommentRequest;
//use CommentService\ServerRequest\ServerRequestConfig;
//use GuzzleHttp\Psr7\Response;
//use GuzzleHttp\Psr7\Utils;
//
//class CommentRequestTest extends TestCase
//{
//    /**
//     * @dataProvider provideNewComment
//     */
//    public function testRequest($name, $text, $config)
//    {
//        $serverConfig = new ServerRequestConfig($config);
//        $stream = Utils::streamFor(json_encode(["id" => 1]));
//        $fakeResponse = new Response(201, ['Content-Type' => 'application/json'], $stream);
//
//        $fakeClient = $this->getMockBuilder(\GuzzleHttp\Client::class)
//            ->disableOriginalConstructor()
//            ->onlyMethods(['request'])
//            ->getMock();
//
//        $fakeClient->expects($this->once())
//            ->method('request')
//            ->will($this->returnValue($fakeResponse));
//
//        $commentRequest = new CommentRequest($serverConfig, 'create');
//
//        $commentRequest->setClient($fakeClient);
//
//        $response = $commentRequest->execute(['name' => $name, 'text' => $text]);
//
//        $this->assertEquals($commentRequest->parseResponse($response)['id'], 1);
//
//    }
//
//    public function provideNewComment()
//    {
//        return [
//            ['Коммент1', 'Текст1', [
//                'host' => 'http://example.com',
//                'headers' => [
//                    'X-Real-IP' => '10.10.10.10',
//                    'Authorization: cghjgcsadghfhjghjfghgj'
//                ],
//                'routes' => [
//                    'index' => [
//                        'uri' => '/comments',
//                        'method' => 'GET',
//                        'headers' => [],
//                        'success_codes' => [200]
//                    ],
//                    'create' => [
//                        'uri' => '/comment',
//                        'method' => 'POST',
//                        'headers' => [
//                            'Content-Type: application/json'
//                        ],
//                        'success_codes' => [200, 201]
//                    ],
//                    'update' => [
//                        'uri' => '/comment/{id}',
//                        'method' => 'PUT',
//                        'headers' => [
//                            'Content-Type: application/json'
//                        ],
//                        'success_codes' => [200]
//                    ]
//                ],
//                'response_type' => 'json'
//            ]]
//        ];
//    }
//}