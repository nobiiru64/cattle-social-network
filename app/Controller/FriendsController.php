<?php

namespace Cattle\Controller;

use Cattle\Model\Friends;
use Cattle\View;

class FriendsController
{

    public $view;
    public $loggedin;
    public $user;

    public function __construct()
    {
        $this->view = new View();
        $this->auth = \Cattle\App::auth();
        if ($_SESSION) $this->user = $_SESSION['user'];
        if ($_SESSION['user'])
            $this->loggedin = TRUE;
    }

    public function index()
    {
        if (!$this->loggedin) die();

        $view = $this->user;

        if (isset($_GET['view'])) {
            $view = sanitizeString($_GET['view']);
        } else {

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
        $result = Friends::getFollowers($view);
        $num = count($result);
        $i=0;
        for ($j = 0; $j < $num; ++$j) {
            $i++;
            $row = $result[$i];
            $followers[$j] = $row['friend'];
        }

        $result = Friends::getFollowing($view);
        $num = count($result);
        $i=0;
        for ($j = 0; $j < $num; ++$j) {
            $i++;
            $row = $result[$i];
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
