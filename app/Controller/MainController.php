<?php

namespace Cattle\Controller;

use Cattle\View;
use Cattle\Model\Members;


class MainController {

    public $view;
    public $loggedin;
    public $user;
    public $auth;
    public function __construct()
    {
        $this->view = new View();
        $this->auth = \Cattle\App::auth();
        if ($_SESSION) $this->user = $_SESSION['user'];
    }

    public function notFound() {

        $this->view->render('404','default',[
            'loggedin' => \Cattle\App::$loggedin,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function index() {

        $this->view->render('index', 'default',[
            'loggedin' => \Cattle\App::$loggedin,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function signup() {

        $this->view->render('signup','default', [
            'loggedin' => false,
            'appname' => getenv('APP_NAME'),
            'signup' => false,
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function signupPost($request) {

        if (isset($_SESSION['user'])) destroySession();
        if (isset($_POST['user']))
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            if ($user == "" || $pass = "") {
                $error = "Данные введены не во все поля";
            } else {
                if (!Members::exist($user)) {
                    $registered = Members::create($user, $pass);

                    if ($registered) {
                        $_SESSION['user'] = $user;
                        $_SESSION['pass'] = $pass;

                        $this->view->redirect('');
                    }
                } else {
                    $error = "Такое имя уже существует";
                }
            }

        echo $error;
    }



    public function login() {

        $this->view->render('login','login', [
            'loggedin' => \Cattle\App::$loggedin,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло'
        ]);
    }

    public function loginPost() {

        $error = "";
        $user = $_POST['user'];
        $pass = $_POST['pass'];
        if (isset($_POST['user'])) {

            if ($user == "" || $pass == "") {
                $error = "Not all fields were entered";
            } else {
                if (!Members::auth($user, $pass)) {
                    $error = "Username/Password invalid";
                } else {

                    $_SESSION['user'] = $user;
                    $_SESSION['pass'] = $pass;

                    $error = "success";

                  //  $error = "You are now logged in." .  "Please <a href='members.php?view=$user'>" .  "click here</a> to continue.<br><br>";

                }

            }
        }

        echo $error;
    }

    public function logout(){
        if (isset($_SESSION['user']))
        {
            destroySession();

            echo "<div class='main'>You have been logged out. Please " .
                "<a href='index.php'>click here</a> to refresh the screen.";

            header('Location: /');
        }
        else {
            echo "<div class='main'><br>" .
                "You cannot log out because you are not logged in";
            header('Location: /login');
        }


    }
}
