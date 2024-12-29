<?php

// $routes =  require basePath("routes.php");

// if (array_key_exists($uri, $routes)) {
//     require basePath($routes[$uri]);
// }
// else {
//     http_response_code(404);
//     require basePath($routes["404"]);
// }

class Router
{
    protected $routes = [];


    /**
     * Add Get Route
     * 
     * @param string $method
     * @param string $uri
     * @param string $controller
     */
    public function registerRoute($method, $uri, $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
        ];
    }

    /**
     * Add Get Route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add Post Route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }


    /**
     * Add Put Route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    /**
     * Add Delete Route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }


    /**
     * Load Error Page
     * @param int $httpStatus
     * @return void
     */
    public function error($httpStatus = 404){
        http_response_code($httpStatus);
        loadView("error/$httpStatus");
        exit;
    }


    /**
     * Add Request Route
     * 
     * @param string $uri
     * @param string $uri
     * @return void
     */
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === $method) {
                require basePath($route["controller"]);
                return;
            }
        }
        $this->error();
    }
}
