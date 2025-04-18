<?php

include_once __DIR__ . "/../src/mc/router.php";

use \Mc\Router;

class oops
{
    public static function do()
    {
        echo "oops::do static method called" . PHP_EOL;
    }
}

function test_function()
{
    echo "oops function called" . PHP_EOL;
}

$routes = [
    "test" => function (array $params) {
        echo "test function called with params " . json_encode($params) . PHP_EOL;
    },
    "test/function" => "test_function",
    "test/do" => "oops::do"
];

Router::init($routes);

Router::run();
