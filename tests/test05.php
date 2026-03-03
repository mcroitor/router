<?php

include_once __DIR__ . '/../src/mc/route.php';
include_once __DIR__ . '/../src/mc/router.php';

use Mc\Route;
use Mc\Router;

#[Route('/api/attr/health')]
function attr_health()
{
    return Router::json(['source' => 'attribute', 'status' => 'ok']);
}

#[Route('/api/attr/users/{id}', methods: ['GET'])]
function attr_user_view()
{
    return Router::json([
        'source' => 'attribute',
        'action' => 'view',
        'pathParams' => Router::getPathParams(),
        'query' => Router::getQueryParams()
    ]);
}

class AttrController
{
    #[Route('/api/attr/users', methods: ['POST'])]
    public static function createUser()
    {
        return Router::json([
            'source' => 'attribute',
            'action' => 'create',
            'body' => Router::getBody()
        ]);
    }
}

Router::init();
echo Router::run();
