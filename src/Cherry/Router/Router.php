<?php

declare(strict_types=1);

namespace Cherry\Router;

use Cherry\Router\RouterInterface;
use Exception;

class Router implements RouterInterface
{
    /**
     * Returns an array of routes from the routing table.
     * @var array
     */
    protected array $routes = [];

    /**
     * Returns an array of route parameters.
     * @var array
     */
    protected array $params = [];

    /**
     * Adds a suffix on the controller name.
     * @abstract
     */
    protected string $controllerSuffix = 'controller';

    /**
     * @inheritDoc
     */
    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * @inheritDoc
     * 
     * @throws Exception
     */
    public function dispatch(string $url): void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformUpperCamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString();
                $action = $this->params['action'];
                $action = $this->transformCamelCase($action);

                if (\is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new Exception();
                }
            } else {
                throw new Exception();
            }
        } else {
            throw new Exception();
        }
    }

    /**
     * Transforms a string to UpperCamelCase format.
     *
     * @param string $string
     * @return string
     */
    public function transformUpperCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Transforms a string to camelCase format.
     * 
     * @param string $string
     * @return string
     */
    public function transformCamelCase(string $string): string
    {
        return \lcfirst($this->transformUpperCamelCase($string));
    }

    /**
     * Matches the url to the routes in the routing table, setting the {$this->params} property.
     *
     * @param string $url
     * @return bool
     */
    private function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $param) {
                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Builds a namespace string based on the controller name and the namespace parameter from the routing table.
     *
     * @param string $string
     * @return string
     */
    public function getNamespace(string $string): string
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}
