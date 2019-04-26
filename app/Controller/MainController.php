<?php

namespace Nobiiru\Controller;

use Nobiiru\View;

class MainController {

    public $view;
    public $loggedin;
    public $user;
    public function __construct()
    {
        $this->view = new View();

        $userstr = ' (Guest)';
        if (isset($_SESSION['user'])) {
            $this->user = $_SESSION['user'];
            $this->loggedin = TRUE;
            $userstr = " ($this->user)";
        } else {
            $this->loggedin = FALSE;
        }
    }

    public function notFound() {

        $this->view->render('404','default',[
            'loggedin' => $this->loggedin,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function index() {

        $this->view->render('index', 'default',[
            'loggedin' => $this->loggedin,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function signup() {

/*
        $error = $user = $pass = "";

        if (isset($_SESSION['user'])) destroySession();
        if (isset($_POST['user'])) {
            $user = sanitizeString($_POST['user']);
            $pass = sanitizeString($_POST['pass']);
            if ($user == "" || $pass == "")
                $error = "Данные введены не во все поля<br><br>";
            else {
                $result = queryMysql("SELECT * FROM members WHERE user='$user'");
                if ($result->num_rows)
                    $error = "Такое имя уже существует<br><br>";
                else {
                    queryMysql("INSERT INTO members VALUES('$user','$pass')");
                    die("<h4>Account created</h4>Please Log in.<br> <br>");
                }
            }
        }*/


            $this->view->render('signup','default', [
            'loggedin' => false,
            'appname' => getenv('APP_NAME'),
            'signup' => false,
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function signupPost($request){
        $error = "Непредвиденная ошибка";
        $user = "";
        $pass = "";
        if (isset($_SESSION['user'])) destroySession();
        if (isset($_POST['user'])) {
            $user = sanitizeString($_POST['user']);
            $pass = sanitizeString($_POST['pass']);
            if ($user == "" || $pass == "")
                $error = "Данные введены не во все поля<br><br>";
            else {
                $result = queryMysql("SELECT * FROM members WHERE user='{$user}'");
                if ($result->num_rows)
                    $error = "Такое имя уже существует<br><br>";
                else {
                    $registered = queryMysql("INSERT INTO members VALUES('{$user}','{$user}')");

                    if ($registered) {

                        $_SESSION['user'] = $user;
                        $_SESSION['pass'] = $pass;

                        $this->view->redirect('');
                    }

                }
            }
        }

        echo $error;
    }



    public function login() {


        $userstr = ' (Guest)';
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $loggedin = TRUE;
            $userstr = " ($user)";
        } else {
            $loggedin = FALSE;
        }

        $this->view->render('login','login', [
            'loggedin' => $loggedin,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло'
        ]);
    }

    public function loginPost() {
        $error = $user = $pass = "";
        if (isset($_POST['user']))
        {
            $user = sanitizeString($_POST['user']);
            $pass = sanitizeString($_POST['pass']);
            if ($user == "" || $pass == "")
            {
                $error = "Not all fields were entered<br>";
                // Данные введены не во все поля
            }
            else
            {
                $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
                if ($result->num_rows == 0)
                {
                    $error = "<span class='error'>Username/Password invalid</span><br><br>";
                    // Ошибка при вводе пары "имя пользователя — пароль"
                }
                else
                {
                    $_SESSION['user'] = $user;
                    $_SESSION['pass'] = $pass;
                    die("You are now logged in." .
                        "Please <a href='members.php?view=$user'>" .
                        "click here</a> to continue.<br><br>");
                    // Вы уже вошли на сайт. Пожалуйста, щелкните на этой ссылке
                }
            }
        }
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
