# PHP router

[![License: Unlicense](https://img.shields.io/badge/License-Unlicense-blue.svg)](UNLICENSE)

The `router` class do simple thing: routes by `label` to the callable. The callable need to be registered.
Historically this router is GET method based.

REST API support (method + path) is also available now. Legacy `?q=` mode is preserved for backward compatibility.

All methods of `router` class are static. Default route param is `q`.

## Prerequisites

- route name is composed from one (the `function` or `label` name) or two words (the `class method` name), separated by slash. All other words in route are function / method parameters. Examples:
  - `home` - route to callable labeled by `home`.
  - `about/company` - can be: callable labeled `about` with param _['company']_; callable labeled `about/company`;
  - `about/strategy` - can be: callable labeled `about` with param _['strategy']_; callable labeled `about/strategy`;
  - `user/view/2` - can be: callable labeled `user` with param _['view', 2]_; callable labeled `user/view` with param _[2]_;
- two-word labeled callable is prioritized
- callable use an array of strings parameter

## Example of route description

```php

class post {
    public static function all(array $params) { echo "show all posts"; }
    public static function view(array $params) { echo "show post {$params[0]}"; }
    public static function edit(array $params) { echo "edit post {$params[0]}"; }
}

// routes description
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
```

Usage examples for provided routes:

- `https://localhost:8000/?q=post/all`
- `https://localhost:8000/?q=post/view/1/2/3`
- `https://localhost:8000/?q=post/edit/5`
- `https://localhost:8000/?q=about`

## Attribute usage example

```php
use Mc\Route;
use Mc\Router;

#[Route("about")]
function about(array $params) {
    echo "about function called";
}

class post {
    #[Route("post/all")]
    public static function all(array $params) { echo "show all posts"; }

    #[Route("post/view")]
    public static function view(array $params) { echo "show post {$params[0]}"; }

    #[Route("post/edit")]
    public static function edit(array $params) { echo "edit post {$params[0]}"; }
}

// register routes
Router::init();

// process route
Router::run();
```

Usage examples for provided routes:

- `https://localhost:8000/?q=post/all`
- `https://localhost:8000/?q=post/view/1/2/3`
- `https://localhost:8000/?q=post/edit/5`
- `https://localhost:8000/?q=about`

You can combine attributes with route registration.

## Testing

For testing you can start embedded PHP server in the project:

```shell
php -t ./tests/ -S localhost:8000
```

Open one of the specified URL-s after this.

- `http:://localhost:8000/test.php?q=test`
- `http:://localhost:8000/test.php?q=test/function`
- `http:://localhost:8000/test.php?q=test/do`
- `http:://localhost:8000/test01.php?q=about`
- `http:://localhost:8000/test01.php?q=user/all`
- `http:://localhost:8000/test01.php?q=user/view`
- `http:://localhost:8000/test02.php?q=about`
- `http:://localhost:8000/test02.php?q=user/all`
- `http:://localhost:8000/test02.php?q=user/view`

REST testing examples (Phase 1):

- `http:://localhost:8000/test03.php/api/health` (GET)
- `http:://localhost:8000/test03.php/api/users` (GET)
- `curl -i -X POST http://localhost:8000/test03.php/api/users`
- `curl -i -X PUT http://localhost:8000/test03.php/api/users` (expects `405 Method Not Allowed`)
- `curl -i -X GET http://localhost:8000/test03.php/api/missing` (expects `404 Not Found`)

REST testing examples (Phase 2):

- `curl -i -X GET "http://localhost:8000/test04.php/api/users/42?expand=posts"`
- `curl -i -X POST http://localhost:8000/test04.php/api/echo -H "Content-Type: application/json" -d "{\"name\":\"mihail\",\"role\":\"admin\"}"`
- `curl -i -X POST http://localhost:8000/test04.php/api/echo -H "Content-Type: application/x-www-form-urlencoded" -d "name=mihail&role=admin"`

REST testing examples (Phase 3, attributes):

- `curl -i -X GET http://localhost:8000/test05.php/api/attr/health`
- `curl -i -X GET "http://localhost:8000/test05.php/api/attr/users/42?expand=posts"`
- `curl -i -X POST http://localhost:8000/test05.php/api/attr/users -H "Content-Type: application/json" -d "{\"name\":\"mihail\"}"`

Attribute route examples:

```php
#[Route('/api/attr/health')]
function health() {
    return Router::json(['status' => 'ok']);
}

#[Route('/api/attr/users/{id}', methods: ['GET'])]
function user_view() {
    return Router::json(['id' => Router::getPathParams()['id'] ?? null]);
}
```

## Migration notes

- Legacy mode keeps working: `?q=about`, `?q=user/view/11`.
- `register($route, $handler)` remains and maps to `GET` for compatibility.
- Prefer REST mode for new code: `Router::get('/api/users/{id}', ...)`, `Router::post(...)`.
- For attributes, old `#[Route('about')]` still works; for REST use `#[Route('/api/users/{id}', methods: ['GET'])]`.
- API errors now use JSON payload:

```json
{"error":{"code":"not_found","message":"Not Found","status":404}}
```

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

## License

This project is released under the Unlicense. See `UNLICENSE`.

SPDX-License-Identifier: Unlicense

## interface

```php
namespace Mc;

/**
 * this router class is based on $_GET
 * <URL> ::= http[s]://<domain>/?<route-name>[/params]
 */
class Router
{
    /**
     * set routes
     * @param array $routes
     */
    public static function init(array $routes = []);

    /**
     * load routes from JSON file
     */
    public static function load(string $jsonfile = "routes.json");

    /**
     * register a new route.
     */
    public static function register(string $route_name, callable $route_method);

    /**
     * register route for one or many HTTP methods
     */
    public static function match(array $methods, string $path, callable $route_method);

    public static function get(string $path, callable $route_method);
    public static function post(string $path, callable $route_method);
    public static function put(string $path, callable $route_method);
    public static function patch(string $path, callable $route_method);
    public static function delete(string $path, callable $route_method);
    public static function options(string $path, callable $route_method);

    /**
     * request helpers
     */
    public static function getPathParams(): array;
    public static function getQueryParams(): array;
    public static function getBody(): array;

    /**
     * build JSON response payload
     */
    public static function json($data, int $status = 200): string;

    /**
     * rewrite default param name
     */
    public static function setParam(string $param): void;

    /**
     * entry point for routing! Returns route value.
     */
    public static function run(): string;
}
```
