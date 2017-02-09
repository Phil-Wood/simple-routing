<?php
namespace App\Core;

use App\Core\Url;

class Routing {


    /**
     * An array of all set routes
     * 
     * @var array
     */
    protected static $routes = array();



    /**
     * The instance of the Url method
     * 
     * @var Url $rl
     */
    protected static $url;



    /**
     * The error404 callback function
     * @var callable $error404
     */
    protected static $error404;



    /**
     * If a route has been matched
     * @var bool
     */
    protected static $foundMatch;



    /**
     * Set the error404 callback
     * 
     * @param callable $callBack
     */
    public static function setError404(callable $callBack){
        self::$error404 = $callBack;
    }



    /**
     * Set a route and associate a callback
     * 
     * @param string $route
     * @param callable $callback
     */
    public static function set(string $route, callable $callBack) {
        if(self::checkForDuplicateRoute($route)) {
            die("A duplicate Route for \"$route\" has been set!");
        }
        self::$routes[] = ['route' => $route, 'callBack' => $callBack];
    }



    /**
     * Check for duplicatate routes
     * 
     * @param  string $route
     * @return bool
     */
    public static function checkForDuplicateRoute (string $route) : bool {
        for($i = 0; $i < count(self::$routes); $i++){
            if(self::$routes[$i]['route'] === $route){
                return true;
            }
        }
        return false;
    }



    /**
     * Check if $route matchs a set route and call $callback
     * If no match is found, call self::$error404
     */
    public static function match() {

        self::$url = new Url();

        for($i = 0; $i < count(self::$routes); $i++){
            if(self::$routes[$i]['route'] === '/' . implode('/', self::$url->getPaths())) {
                self::$routes[$i]['callBack']();
                self::$foundMatch = true;
            }
        }
        if(!self::$foundMatch) {
            if (is_callable(self::$error404)) {
                call_user_func(self::$error404);
            }
            else {
                echo "Not Found!";
            }
        }
    }
}