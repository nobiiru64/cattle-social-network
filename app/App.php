<?php

namespace Nobiiru;



class App {

    public $routes;
    public $loggedin;

    public function __construct()
    {
        session_start();
        $userstr = ' (Guest)';
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
            $this->loggedin = TRUE;
            $userstr = " ($this->user)";
        } else {
            $this->loggedin = false;
        }

        $this->routes = [];


    }

    public function post($url, $callback) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->routes[$url] = [$callback, 'post'];
        }

    }

    public function get($url, $callback){
        if ($_SERVER['REQUEST_METHOD'] == "GET") {
            $this->routes[$url] = [$callback, 'get'];

        }
    }

    public function run() {
        $this->installCheck();
        $url = explode('/', $_SERVER['REQUEST_URI']);


        if ($_SERVER['REQUEST_URI'] == '/'){
            $mainUrl = '/';
        } else {
            $mainUrl = rtrim($_SERVER['REQUEST_URI'],'/');
        }

        $id = 0;
        foreach ($this->routes as $key => $route) {




            $RouteUrl = $key;
            $routeNew = explode('/', $RouteUrl);

            if ($routeNew[1] === $url[1]) {


                if (reset($route) instanceof \Closure) {
                    echo 'function';
                } else {

                    $controller = $route;
                    if (count($url) > 2 && $url[1] !== 'api') {
                        if (isset($url[2]) && empty($url[2])) {
                            $controller = $this->routes["/{$url[1]}/"];
                        } else {
                            $controller = $this->routes["/{$url[1]}/:user"];
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
            if (!$installed) echo 'Не установленно!';
            if (!$installed) Header('Location: install.php');
        }
        function queryWithResponse($query){
            global $connection;
            $result = $connection->query($query);
            return ($result) ? true : false;
        }

        checkAvailable();
    }

    public function map(){

    }
}
