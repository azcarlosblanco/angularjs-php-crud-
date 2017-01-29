<?php
/**
 * miniJSON
 * - a very super simple, basic json php framework.
 *
 * Router
 *
 */
class router
{

    var $app;
    var $root;
    var $routes;

    /**
     * Constructor
     * @param $app
     * @param $root
     * @param $routes
     */
    public function __construct($app, $root, $routes)
    {
        $this->app = $app;
        $this->root = $root;
        $this->routes = $routes;
    }

    /**
     * Route
     */
    public function route()
    {

        // Get requested URI
        $requestURI = $_SERVER['REQUEST_URI'];

        // Loop trough routes
        foreach ($this->routes as $k => $v) {

            // If route uri containts wildcard, set parameter
            $parameter = "";
            if (strpos($v['uri'], '*')) {
                $_requestURI = dirname($requestURI);
                $uri = dirname($v['uri']);
                $parameter = basename($requestURI);
            } else {
                $_requestURI = $requestURI;
                $uri = $v['uri'];
            }

            // Match route
            if ($_requestURI == $this->root.$uri) {

                // Check token if required
                if ($v['requires_token']) {
                    // Check token
                    if (!$this->app->valid_token()) {
                        $this->app->response(null, 401);
                        return;
                    }
                }

                // Execute
                $request = explode('@', $v['call']);
                $this->app->response($request[1]::$request[0]($parameter), 200);

                return;
            }
        }

        // No match, return error
        $this->app->response('Invalid request', 404);

    }

}
