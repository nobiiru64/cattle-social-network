<?php

namespace Cattle;





class App {

    public static $router;

    public static $db;

    public static $routes = [];

    public static $loggedin;

    public static function init(){
        session_start();
        static::bootstrap();
        self::run();
    }

    public static function auth(){



        $userstr = ' (Guest)';
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            self::$loggedin = TRUE;
            $userstr = " ($user)";
        } else {
            self::$loggedin = false;
        }
    }

    public static function bootstrap(){

        include '../routes/web.php';
        $dotenv = (\Dotenv\Dotenv::create(__DIR__.'/..'))->load();
     //   static::$router = new Cattle\Router();
        static::$db = new \Cattle\Database();

        self::auth();
    }

    public function post($url, $callback) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            self::$routes[$url] = [$callback, 'post'];
        }

    }

    public function get($url, $callback){
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            self::$routes[$url] = [$callback, 'get'];

        }
    }

    public function run() {
        self::installCheck();
        $url = explode('/', $_SERVER['REQUEST_URI']);


        if ($_SERVER['REQUEST_URI'] == '/'){
            $mainUrl = '/';
        } else {
            $mainUrl = rtrim($_SERVER['REQUEST_URI'],'/');
        }

        $id = 0;

        foreach ( self::$routes as $key => $route) {




            $RouteUrl = $key;
            $routeNew = explode('/', $RouteUrl);

            if ($routeNew[1] === $url[1]) {


                if (reset($route) instanceof \Closure) {
                    echo 'function';
                } else {

                    $controller = $route;
                    if (count($url) > 2 && $url[1] !== 'api') {
                        if (isset($url[2]) && empty($url[2])) {
                            $controller = self::$routes["/{$url[1]}/"];
                        } else {
                            $controller = self::$routes["/{$url[1]}/:user"];
                        }
                    }

                    $methodType = $controller[1];
                    $controller = explode('@',$controller[0]);
                    $className = $controller[0];
                    $method = $controller[1];

                    if (!$className || strlen($className) <= 0) {

                        //    $className = '\\Webpractik\\Api\\Error';
                    }



                    if (!class_exists($className)) {

                        //    $response = new \Webpractik\Api\NotFoundRoute($this->sefVariables);
                    } else {
                        $response = new $className();

                        if ($methodType == "get" && $_SERVER['REQUEST_METHOD'] === "GET") {
                            $response->$method();
                        } elseif ($methodType == "post" && $_SERVER['REQUEST_METHOD'] === "POST") {
                            $response->$method($_REQUEST);
                        }
                    }
                }
            }
        }

    }


    public function installCheck(){

        function checkAvailable() {
            $installed = queryWithResponse("SELECT * FROM members LIMIT 1;");
           // if (!$installed) echo 'Не установленно!';
          //  if (!$installed) Header('Location: install.php');
        }
        function queryWithResponse($query){
            global $connection;
          //  $result = $connection->query($query);
           // return ($result) ? true : false;
        }

        checkAvailable();
    }

    public function map(){

    }
}
