<?php

include_once __DIR__ . '/../src/mc/router.php';

use Mc\Router;

Router::init();

Router::get('/api/health', function () {
    return Router::json(['status' => 'ok', 'method' => 'GET']);
});

Router::get('/api/users', function () {
    return Router::json(['action' => 'list', 'method' => 'GET']);
});

Router::post('/api/users', function () {
    return Router::json(['action' => 'create', 'method' => 'POST']);
});

echo Router::run();
