<?php

namespace Nobiiru\Controller;

use Nobiiru\View;

class FriendsController
{

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

    public function index()
    {
        if (!$this->loggedin) die();

        if (isset($_GET['view'])) {
            $view = sanitizeString($_GET['view']);
        } else {
            $view = $this->user;
        }

        if ($view == $this->user) {
            $name1 = $name2 = "Your"; // Ваши
            $name3 = "You are"; // Вы
        } else {
            $name1 = "<a href='members.php?view=$view'>$view</a>'s";
            $name2 = "$view's";
            $name3 = "$view is";
        }


        $followers = [];
        $following = [];
        $result = queryMysql("SELECT * FROM friends WHERE user='$view'");
        $num = $result->num_rows;

        for ($j = 0; $j < $num; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $followers[$j] = $row['friend'];
        }

        $result = queryMysql("SELECT * FROM friends WHERE friend='$view'");
        $num = $result->num_rows;

        for ($j = 0; $j < $num; ++$j) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $following[$j] = $row['user'];
        }

        $mutual = array_intersect($followers, $following);
        $followers = array_diff($followers, $mutual);
        $following = array_diff($following, $mutual);

        $friends = false;
        if (sizeof($mutual) || sizeof($followers) || sizeof($following)) {
            $friends = true;
        }




        $this->view->render('friends', 'default', [
            'loggedin' => $this->loggedin,
            'signup' => false,
            'mutual' => $mutual,
            'friends' => $friends,
            'followers' => $followers,
            'following' => $following,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user,
        ]);

    }



}
