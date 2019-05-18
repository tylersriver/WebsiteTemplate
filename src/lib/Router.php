<?php

/**
 * Class Router
 *
 * Class to handle routes through
 * the application
 */
class Router
{
    /**
     * These are the available routes in the system. This serves
     * as a whitelist and only matching controller and action
     * will be executed
     * @var array
     */
    private static $controllers = [
        'pages' => [
            'overview',
            'error',
            'login'
        ],
        'user' => [
            'login',
            'logout'
        ]
    ];

    /**
     * Calls the given controller and action if available
     * @param $controller
     * @param $action
     * @return mixed
     */
    public static function Call($controller, $action)
    {
        if(!array_key_exists($controller, self::$controllers)
            or !in_array($action, self::$controllers[$controller])) {
            $controller = 'pages';
            $action = 'error';
        }

        $controller = ucfirst($controller) . 'Controller';
        $controller = new $controller();
        return $controller->{$action}();
    }
}

/**
 * Wrapper Router to make calling actions easier
 * @param $controller
 * @param $action
 * @return mixed
 */
function call($controller, $action)
{
    return Router::Call($controller, $action);
}