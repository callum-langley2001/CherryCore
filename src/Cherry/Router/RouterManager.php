<?php

declare(strict_types=1);

namespace Cherry\Router;

use Cherry\Yaml\YamlConfig;
use Cherry\Router\Router;

/**
 * Class RouterManager
 * 
 * @package Cherry
 * @subpackage RouterManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class RouterManager extends Router
{
    /**
     * Dispatches a route based on the given URL.
     *
     * @param string $url The URL to dispatch the route for.
     * @return void
     */
    public static function dispatchRoute(string $url)
    {
        $router = new Router();
        $routes = YamlConfig::file('routes.yaml');
        if (
            is_array($routes)
            && !empty($routes)
        ) {
            $args = [];
            foreach ($routes as $key => $route) {
                if (
                    isset($route['namespace'])
                    && $route['namespace'] != ''
                ) {
                    $args = [
                        'namespace' => $route['namespace'],
                    ];
                } elseif (
                    isset($route['controller'])
                    && $route['controller'] != ''
                ) {
                    $args = [
                        'controller' => $route['controller'],
                        'action' => $route['action'],
                    ];
                }
                if (isset($key)) {
                    $router->add($key, $args);
                }
            }
            $router->dispatch($url);
        }
    }
}
