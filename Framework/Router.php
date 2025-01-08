<?php


namespace Framework;

use App\Controllers\ErrorController;
use Framework\Middleware\Authorize;

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
     * @param string $action
     * @param array $middleware
     * 
     * @return void
     */
    public function registerRoute($method, $uri, $action, $middleware = [])
    {
        list($controller, $controllerMethod) = explode('@', $action);
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod,
            'middleware' => $middleware
        ];
    }

    /**
     * Add Get Route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function get($uri, $controller, $middleware = [])
    {
        $this->registerRoute('GET', $uri, $controller, $middleware);
    }

    /**
     * Add Post Route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function post($uri, $controller, $middleware = [])
    {
        $this->registerRoute('POST', $uri, $controller, $middleware);
    }


    /**
     * Add Put Route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function put($uri, $controller, $middleware = [])
    {
        $this->registerRoute('PUT', $uri, $controller, $middleware);
    }

    /**
     * Add Delete Route
     * 
     * @param string $uri
     * @param string $controller
     * @param array $middleware
     * @return void
     */
    public function delete($uri, $controller, $middleware = [])
    {
        $this->registerRoute('DELETE', $uri, $controller, $middleware);
    }


    // /**
    //  * Load Error Page
    //  * @param int $httpStatus
    //  * @return void
    //  */
    // public function error($httpStatus = 404)
    // {
    //     http_response_code($httpStatus);
    //     loadView("error/$httpStatus");
    //     exit;
    // }


    /**
     * Add Request Route
     * 
     * @param string $uri
     * @param string $uri
     * @return void
     */
    public function route($uri)
    {
        $requestMethod = $_SERVER["REQUEST_METHOD"];

        if ($requestMethod === "POST" && isset($_POST['_method'])) {
            $requestMethod = strtoupper($_POST['_method']);
        }

        $uriSegments = explode("/", trim($uri, "/"));
        foreach ($this->routes as $route) {
            $routeSegments = explode("/", trim($route["uri"], "/"));
            $match = true;
            if (count($routeSegments) === count($uriSegments) && strtoupper($requestMethod === $route["method"])) {
                $params = [];
                $match = true;
                for ($i = 0; $i < count($uriSegments); $i++) {
                    if ($routeSegments[$i] !== $uriSegments[$i] && !preg_match("/{(.+?)}/", $routeSegments[$i])) {
                        $match = false;
                        break;
                    }
                    if (preg_match("/{(.+?)}/", $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
                if ($match) {

                    foreach ($route['middleware'] as $role) {
                        (new Authorize())->handle($role);
                    }

                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
            // if($route["uri"] === $uri && $route["method"] === $method)
            // {
            // $controller = 'App\\Controllers\\' . $route['controller'];
            // $controllerMethod = $route['controllerMethod'];
            // $controllerInstance = new $controller();
            // $controllerInstance->$controllerMethod();
            //     return;
            // }
        }
        ErrorController::notFound();
    }
}
