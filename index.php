<?php

include_once "../src/mc/router.php";

class post {
    public static function all(array $params) { echo "show all posts"; }
    public static function view(array $params) { echo "show post {$params[0]}"; }
    public static function edit(array $params) { echo "edit post {$params[0]}"; }
}

$routes = [
    "post/all" => "post::all",
    "post/view" => "post::view",
    "post/edit" => "post::edit",
    "about" => function() { echo "about function called"; }
];

// register routes
\Mc\Router::init($routes);

// process route
\Mc\Router::run();