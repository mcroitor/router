<?php

include_once __DIR__ . '/../src/mc/route.php';
include_once __DIR__ . '/../src/mc/router.php';

use mc\route;
use \mc\router;

#[route('index')]
function index(array $params){
    echo __FUNCTION__ . " function";
}

#[route('about')]
function about(array $params){
    echo __FUNCTION__ . " function";
}


class user {
    #[route('user/all')]
    public static function all(array $params){
        echo __METHOD__ . " method";
    }

    #[route('user/view')]
    public static function view(array $params) {
        echo __METHOD__ . " method with params: " . json_encode($params);
    }
}

router::init();

router::run();
