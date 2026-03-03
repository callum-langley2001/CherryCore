<?php

declare(strict_types=1);

namespace Cherry\Router;

interface RouterInterface
{
    /**
     * Add a route to the routing table.
     *
     * @param string $route
     * @param array  $params
     * @return void
     */
    public function add(string $route, array $params): void;

    /**
     * Dispatch the route, create a controller object and execute the default method of the controller.
     *
     * @param string $url
     * @return void
     */
    public function dispatch(string $url): void;
}
