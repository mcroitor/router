# PHP router

The `router` class do simple thing: routes by `label` to the callable. The callable need to be registered.
This router is GET method based. 

All methods of `router` class are static. Default route param is `q`.

Prerequisites:

 * route name is composed from one (the `function` or `label` name) or two words (the `class method` name), separated by slash. All other words in route are function / method parameters. Examples:
   * `home` - route to callable labeled by `home`.
   * `about/company` - can be: callable labeled `about` with param _['company']_; callable labeled `about/company`;
   * `about/strategy` - can be: callable labeled `about` with param _['strategy']_; callable labeled `about/strategy`;
   * `user/view/2` - can be: callable labeled `user` with param _['view', 2]_; callable labeled `user/view` with param _[2]_;
 * two-word labeled callable is prioritized
 * callable use an array of strings parameter

Example of route description:

```php

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
\mc\router::init($routes);

// process route
\mc\router::run();
```

Usage examples for provided routes:

 * `https://localhost:8000/?q=post/all`
 * `https://localhost:8000/?q=post/view/1/2/3`
 * `https://localhost:8000/?q=post/edit/5`
 * `https://localhost:8000/?q=about`

For testing you can start embedded PHP server in the project:

```shell
php -t ./tests/ -S localhost:8000
```

Open one of the specified URL-s after this.

## project usage

You can use my simple [module manager](https://github.com/mcroitor/module_manager),
just include in `modules.json`:

```json
[{
    "user" : "mcroitor",
    "repository" : "router",
    "branch" : "master",
    "source" : "./src"
}]
```

and install it.

## interface

```php
namespace mc;

/**
 * this router class is based on $_GET
 * <URL> ::= http[s]://<domain>/?<route-name>[/params]
 */
class router
{
    /**
     * set routes
     * @param array $routes
     */
    public static function init(array $routes);

    /**
     * load routse from JSON file
     */
    public static function load(string $jsonfile = "routes.json");

    /**
     * register a new route.
     */
    public static function register(string $route_name, callable $route_method);

    /**
     * rewrite default param name
     */
    public static function set_param(string $param);

    /**
     * entry point for routing!
     */
    public static function run();
}
```