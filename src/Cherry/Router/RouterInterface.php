<?php 

namespace Cherry\Router;

/**
 * Interface RouterInterface
 * 
 * @package Cherry
 * @subpackage Router
 * @author Callum Langley <callumlangley9@gmail.com>
 * @link https://github.com/callum-langley/CherryCore
 */
interface RouterInterface
{
    /**
     * Add a route to the router
     * 
     * @param string $route The route to add
     * @param array $params The route parameters
     * @return void 
     */
    public function add(string $route, array $params): void;

    /**
     * Disaptch the route and create a controller object.
     * Executes the defined method of the controller.
     * 
     * @param string $url The url to dispatch
     * @return void
     */
    public function dispatch(string $url) : void;
}