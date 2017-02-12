<?php
namespace App\Core;

use App\Core\Url;

class Routing
{

    /**
     * An array of all set routes
     * 
     * @var array $routes
     */
    protected static $routes = array();


    /**
     * Current path array of set route
     * 
     * @var array $pathArray
     */
    protected static $pathArray = array();


    /**
     * Current method of set route
     * 
     * @var array $pathArray
     */
    protected static $routeMethod = array();


    /**
     * The instance of the Url object
     * 
     * @var Url $url
     */
    protected static $url;


    /**
     * The http request method
     * 
     * @var $requestMethod
     */
    protected static $requestMethod;


    /**
     * The error404 callback function
     * 
     * @var callable $error404
     */
    protected static $error404;



    /**
     * If a route has been matched
     * @var bool
     */
    protected static $foundMatch;


    /**
     * The key of the matched route
     * @var int
     */
    protected static $matchedKey;


    /**
     * Set the error404 callback
     * 
     * @param callable $callBack
     */
    public static function setError404(callable $callBack)
    {
        self::$error404 = $callBack;
    }


    /**
     * Implement error404 callback
     */
    public static function error404()
    {
        if (is_callable(self::$error404)) {
            call_user_func(self::$error404);
        } else {
            echo "Not Found!"; // Replace with call to error system
        }
    }



    /**
     * HTTP method GET
     * Set a route and associate a callback
     * 
     * @param string $path
     * @param callable $callback
     */
    public static function get(string $path, callable $callBack)
    {
        self::storeRoute('GET', $path, $callBack);
    }


    /**
     * HTTP method POST
     * Set a route and associate a callback
     * 
     * @param string $path
     * @param callable $callback
     */
    public static function post(string $path, callable $callBack)
    {
        self::storeRoute('POST', $path, $callBack);
    }


    /**
     * HTTP method DELETE
     * Set a route and associate a callback
     * 
     * @param string $path
     * @param callable $callback
     */
    public static function delete(string $path, callable $callBack)
    {
        self::storeRoute('DELETE', $path, $callBack);
    }


    /**
     * Store the method, path and callback
     * Check to see if the path has already been set
     * 
     * @param  string $method
     * @param  string $path
     * @param  callable $callBack
     */
    public static function storeRoute(string $method, string $path, callable $callBack)
    {
        self::$url = Url::Instance();
        self::$requestMethod = self::$url->getMethod();
        self::$routeMethod = $method;
        self::$pathArray = explode('/', trim($path,'/'));

        if (self::checkForDuplicatePath()) {
            die("A duplicate Route for \"$path\" has been set!"); // Replace with call to error system
        } else {
            self::$routes[] = ['method' => $method, 'path' => self::$pathArray, 'callBack' => $callBack];
        }
    }



    /**
     * Check for duplicate paths
     * 
     * @param  string $method
     * @return bool
     */
    public static function checkForDuplicatePath () : bool
    {
        for ($i = 0; $i < count(self::$routes); $i++) {
            if (self::$routes[$i]['path'] === self::$pathArray && self::$routes[$i]['method'] === self::$routeMethod) {
                return true;
            }
        }
        return false;
    }



    /**
     * Check if current path matchs a set path and implement $callback
     * If no match is found, call self::$error404
     */
    public static function match()
    {
        self::sortRoutes();

        /*
        echo '<pre>';
        print_r(self::$routes);
        echo '</pre>';
        */
       
       echo '<pre>'; print_r(self::$url->getPaths()); echo '</pre>';

        foreach (self::$routes as $key => $route) {
            if ($route['path'] === self::$url->getPaths() &&
                $route['method'] === self::$requestMethod) {
                    self::$matchedKey = $key;
                    self::$foundMatch = true;
                    break;
            } elseif ($route['path'] === self::$url->getPaths() &&
                $route['method'] !== self::$requestMethod) {
                    self::$matchedKey = $key;
                    self::$foundMatch = true;
            }
        }

        if (isset(self::$matchedKey)) {
            self::$routes[self::$matchedKey]['callBack']();
        } else {
            self::error404();
        }
    }



    /**
     * Sort the routes by path count - largest first
     */
    public static function sortRoutes()
    {
        usort(self::$routes, function ($a, $b) : int {
            $a = count($a['path']);
            $b = count($b['path']);
            return ($a == $b) ? 0 : (($a < $b) ? 1 : - 1);
        });
    }
}