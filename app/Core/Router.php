<?php

namespace App\Core;

class Router
{
    protected $routes = [];
    protected $middlewares = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uri' => $uri,
            'controller' => $controller,
            'middleware' => $this->middlewares[$uri] ?? null
        ];
    }

    public function get($uri, $controller)
    {
        $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        $this->add('POST', $uri, $controller);
    }

    // NUEVO: proteger ruta
    public function middleware($uri, $callback)
    {
        $this->middlewares[$uri] = $callback;
    }

    public function dispatch($uri, $method)
    {
        foreach ($this->routes as $route) {

            // patrón con parámetros dinámicos
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route['uri']);
            $pattern = "#^{$pattern}$#";

            if (preg_match($pattern, $uri, $matches) && $route['method'] === strtoupper($method)) {

                array_shift($matches);

                // ejecutar middleware (protección de rol)
                if ($route['middleware']) {
                    call_user_func($route['middleware']);
                }

                $this->callAction(
                    ...explode('@', $route['controller']),
                    params: $matches
                );

                return;
            }
        }

        throw new \Exception("No route found for this URI.");
    }

    protected function callAction($controller, $action, $params = [])
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $action)) {
            throw new \Exception("{$controller} does not respond to action {$action}");
        }

        return call_user_func_array([$controller, $action], $params);
    }
}
