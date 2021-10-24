<?php
return [
    'commentary' => [
        /* Класс комментария */
        'class' => 'CommentService\Comment\BaseComment',
    ],
    /* Информация о взаимодействии с сервером */
    'server' => [
        'host' => 'http://example.com',
        'headers' => [],
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
    ]
];