<?php

include_once __DIR__ . '/../src/mc/route.php';
include_once __DIR__ . '/../src/mc/router.php';

use Mc\Route;
use \Mc\Router;

#[Route('index')]
function index(array $params){
    echo __FUNCTION__ . " function";
}

#[Route('about')]
function about(array $params){
    echo __FUNCTION__ . " function";
}


class user {
    #[Route('user/all')]
    public static function all(array $params){
        echo __METHOD__ . " method";
    }

    #[Route('user/view')]
    public static function view(array $params) {
        echo __METHOD__ . " method with params: " . json_encode($params);
    }
}

Router::init();

Router::run();
