# PHP router

This router is GET method based. Default route param is `q`.

Prerequisites:

 * route name is composed from one (the `function` or `label` name) or two words (the `class method` name), separated by slash. All other words in route are function / method parameters. Examples:
   * `home` - route to callable labeled by `home`.
   * `about/company` - can be: callable labeled `about` with param [`company`]; callable labeled `about/company`;
   * `about/strategy` - can be: callable labeled `about` with param [`strategy`]; callable labeled `about/strategy`;
   * `user/view/2` - can be: callable labeled `user` with param [`view`, 2]; callable labeled `user/view` with param [2];
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

\mc\router::init($routes);

\mc\router::run();