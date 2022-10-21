<?php

include_once "../src/mc/router.php";

use \mc\router;

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

router::init($routes);

router::run();
