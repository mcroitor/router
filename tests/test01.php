<?php

include_once "../src/mc/router.php";

function index(array $params){
    echo __FUNCTION__ . " function";
}

function about(array $params){
    echo __FUNCTION__ . " function";
}

class user {
    public static function all(array $params){
        echo __METHOD__ . " method";
    }

    public static function view(array $params) {
        echo __METHOD__ . " method with params: " . json_encode($params);
    }
}

\Mc\Router::load(__DIR__ . "/routes.json");

\Mc\Router::run();
