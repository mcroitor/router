<?php

include_once __DIR__ . '/../src/mc/router.php';

use Mc\Router;

Router::init();

Router::get('/api/users/{id}', function () {
    return Router::json([
        'action' => 'view',
        'pathParams' => Router::getPathParams(),
        'query' => Router::getQueryParams()
    ]);
});

Router::post('/api/echo', function () {
    return Router::json([
        'action' => 'echo',
        'body' => Router::getBody()
    ]);
});

echo Router::run();
