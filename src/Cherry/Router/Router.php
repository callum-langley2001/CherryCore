<?php

declare(strict_types=1);

namespace Cherry\Router;

use Cherry\Router\RouterInterface;
use Cherry\Router\Exception\RouterException;
use Cherry\Router\Exception\RouterBadMethodCallException;

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
     * Adds a route to the routing table.
     *
     * @param string $route The route to add
     * @param array $params The parameters to associate with the route
     */
    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * Dispatches the given URL to a controller object.
     *
     * This method takes a given URL, matches it against the routing table, and then dispatches the request to a controller object.
     * If the URL matches a route in the routing table, it sets the params property of the Router object to the matched route's parameters.
     * It then attempts to instantiate the controller object and call the default method of the controller.
     * If any errors occur while instantiating the controller object or calling the default method, the method will throw a RouterException or RouterBadMethodCallException.
     * If the URL does not match any route in the routing table, the method will throw a RouterException.
     *
     * @param string $url The URL to dispatch
     * @throws RouterException If the URL does not match any route in the routing table
     * @throws RouterBadMethodCallException If any errors occur while instantiating the controller object or calling the default method
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
                    throw new RouterBadMethodCallException();
                }
            } else {
                throw new RouterException();
            }
        } else {
            throw new RouterException();
        }
    }

    /**
     * Transforms a string to upper camel case format.
     *
     * The function first replaces all hyphens with spaces, then uppercases the first letter of each word,
     * and finally removes all spaces.
     *
     * @param string $string The string to transform
     * @return string The transformed string in upper camel case format
     */
    public function transformUpperCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Transforms a string to camel case format.
     *
     * The function first transforms a string to upper camel case format using the transformUpperCamelCase method,
     * and then lowercases the first letter of the resulting string.
     *
     * @param string $string The string to transform
     * @return string The transformed string in camel case format
     */
    public function transformCamelCase(string $string): string
    {
        return \lcfirst($this->transformUpperCamelCase($string));
    }

    /**
     * Gets the namespace of a controller.
     *
     * This method takes a controller name string and returns its fully qualified namespace.
     * If the 'namespace' parameter is present in the routing table, it is appended to the namespace.
     *
     * @param string $string The controller name string
     * @return string The fully qualified namespace of the controller
     */
    public function getNamespace(string $string): string
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }

    /**
     * Matches a given URL against the routing table.
     *
     * This method loops through the routing table and checks if the given URL matches any of the routes.
     * If a match is found, it sets the params property of the Router object to the matched route's parameters,
     * and then returns true. If no match is found, it returns false.
     *
     * @param string $url The URL to match against the routing table
     * @return bool True if the URL matches any route in the routing table, false otherwise
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
}
