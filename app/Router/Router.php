<?php

namespace app\Router;

class Router {
    private $routes = [];

    public function add($method, $path, $callback) {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'callback' => $callback,
        ];
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($method === $route['method'] && preg_match($this->convertPathToRegex($route['path']), $uri, $matches)) {
                array_shift($matches);
                return call_user_func_array($route['callback'], $matches);
            }
        }

        http_response_code(404);
        echo "404 - Page not found.";
    }

    private function convertPathToRegex($path) {
        // Convert path params like {id} to regex
        return '#^' . preg_replace('#\{(\w+)\}#', '(\d+)', $path) . '$#';
    }
}