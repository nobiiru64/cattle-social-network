<?php

namespace Cattle\Controller;

use Cattle\Model\Users;
use Cattle\View;


class UsersController
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

        $users = [];

        $result = Users::getAll();
        $num = count($result);
        $i = 0;
        for ($j = 0; $j < $num; ++$j) {
            $i++;
            $row = $result[$i-1];


            if ($row['user'] == $this->user)
                continue;

            $result1 = Users::followed($this->user, $row['user']);
            $t1 = count($result1);
            $result1 = Users::following($this->user, $row['user']);
            $t2 = count($result1);

            $status = '';
            if (($t1 + $t2) > 1) $status = " &harr; is a mutual friend";
            // Двунаправленная стрелка, взаимный друг
            elseif ($t1) $status = " &larr; you are following";
            // Стрелка влево, вы заинтересованы в дружбе
            elseif ($t2) {
                $status = " &rarr; is following you";
                $follow = "recip";
            }

            $member = $row['user'];

            $users[$member] = $status;
            /*
             Стрелка вправо, проявляет интерес к дружбе с вами
             if (!$t1) {
                echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
            } else {
               echo " [<a href='members.php?remove=" .$row['user'] . "'>drop</a>]";
            }
             Снять заинтересованность в дружбе
            */
        }

        $this->view->render('users', 'default',[
            'loggedin' => $this->loggedin,
            'avatar' => '',
            'users'=> $users,
            'signup' => false,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user
        ]);
    }

    public function removeFriend() {

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/remove/', '', $url);

       // $remove = sanitizeString($url);
        Users::removeFriend($url,$this->user);

        $this->view->redirect('users');

    }

    public function addFriend(){

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/add/', '', $url);

       // $friend = \Cattle\Core\Database::sanitazeString($url);
        $result = Users::isFriends($this->user, $url);


        if (!count($result))
            Users::addFriend($this->user, $url);

        $this->view->redirect('users');
    }

    public function showProfile(){

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/id/', '', $url);

        $result = Users::show($url);

        $num = count($result);

        if ($num) {

                $row = reset($result);
                $text = stripslashes($row['text']);

            $avatarsPath = $_SERVER['DOCUMENT_ROOT'] . "/../public/images/avatars/";
            $imageLink = $avatarsPath . $url . ".jpg";
            $avatar = '';
            if (file_exists($imageLink)) {
                $member_avatar = "/images/avatars/" . $url . ".jpg";
            } else {
                $member_avatar = "/images/noavatar.png";
            }

            $member = $url;

            $this->view->render('profile', 'default',[
                'loggedin' => $this->loggedin,
                'signup' => false,
                'text'=> $text,
                'appname' => getenv('APP_NAME'),
                'userString' => 'Хелло',
                'user'=> $this->user,
                'member'=> $member,
                'member_avatar' => $member_avatar,
                'not_created' => false,
            ]);
        } else {
            $this->view->render('profile', 'default',[
                'loggedin' => $this->loggedin,
                'signup' => false,
                'appname' => getenv('APP_NAME'),
                'userString' => 'Хелло',
                'user'=> $this->user,
                'not_created' => true,
            ]);
        }


    }


}
