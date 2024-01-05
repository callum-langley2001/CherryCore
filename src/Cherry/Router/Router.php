<?php

declare(strict_types=1);

namespace Cherry\Router;

use Cherry\Router\Exception\RouterBadMethodCallException;
use Cherry\Router\RouterInterface;

/**
 * Class Router
 * 
 * @package Cherry
 * @subpackage Router
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements RouterInterface
 * @see RouterInterface
 * @see RouterBadMethodCallException
 */
class Router implements RouterInterface
{
    /**
     * @var array $routes The routes
     */
    protected array $routes = [];

    /**
     * @var array $params The route parameters
     */
    protected array $params = [];

    /**
     * Adds a suffix to the controller class provided by the route
     * @var string $suffix
     */
    protected string $suffix = 'Controller';

    /**
     * @inheritDoc
     */
    public function add(string $route, array $params = []): void
    {
        $this->routes[$route] = $params;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(string $url): void
    {
        if ($this->match($url)) {
            $controllerString = $this->params['controller'];
            $controllerString = $this->transformToUpperCamelCase($controllerString);
            $controllerString = $this->getNamespace($controllerString);

            if (class_exists($controllerString)) {
                $controllerObject = new $controllerString();
                $action = $this->params['action'];
                $action = $this->transformToLowerCamelCase($action);

                if (\is_callable([$controllerObject, $action])) {
                    $controllerObject->$action();
                } else {
                    throw new RouterBadMethodCallException("Method $action in controller $controllerString not found");
                }
            } else {
                throw new RouterBadMethodCallException("Controller class $controllerString not found");
            }
        } else {
            throw new RouterBadMethodCallException('No route matched', 404);
        }
    }

    /**
     * Transforms a string to upper camel case.
     *
     * @param string $string The input string to transform.
     * @return string The transformed string in upper camel case.
     */
    public function transformToUpperCamelCase(string $string): string
    {
        return str_replace(
            ' ',
            '',
            ucwords(
                str_replace(
                    '-',
                    ' ',
                    $string
                )
            )
        );
    }

    /**
     * Transforms a string to lower camel case.
     * 
     * @param string $string The input string to transform.
     * @return string The transformed string in lower camel case.
     */
    public function transformToLowerCamelCase(string $string): string
    {
        return \lcfirst($this->transformToUpperCamelCase($string));
    }

    /**
     * Match the route against the url in the routing table
     * Set the $this->params property if a route is found
     * 
     * @param string $url The route URL
     * @return bool True if a match found, false otherwise
     */
    private function match(string $url): bool
    {
        // Loop through the items in the routing table
        foreach ($this->routes as $route => $params) {
            // Check if route matches url
            if (preg_match($route, $url, $matches)) {
                // Loop through $matches array
                foreach ($matches as $key => $value) {
                    // If the key matches a param in the routing table add it to $params
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Retrieves the namespace for the given string.
     *
     * @param string $string The string to retrieve the namespace for.
     * @return string The namespace for the given string.
     */
    public function getNamespace(string $string): string
    {
        $namespace = 'App\Controllers\\';
        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'];
        }
        return $namespace;
    }
}