<?php

namespace Nobiiru\Controller;

use Nobiiru\View;


class MembersController
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

        $users = [];

        $result = queryMysql("SELECT user FROM members ORDER BY user");
        $num = $result->num_rows;

        for ($j = 0; $j < $num; ++$j) {

            $row = $result->fetch_array(MYSQLI_ASSOC);


            if ($row['user'] == $this->user)
                continue;



            $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$this->user'");
            $t1 = $result1->num_rows;
            $result1 = queryMysql("SELECT * FROM friends WHERE user='$this->user' AND friend='" . $row['user'] . "'");
            $t2 = $result1->num_rows;

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

            // Стрелка вправо, проявляет интерес к дружбе с вами
            if (!$t1) {
           //     echo " [<a href='members.php?add=" . $row['user'] . "'>$follow</a>]";
            } else {
           //     echo " [<a href='members.php?remove=" .$row['user'] . "'>drop</a>]";
            }
            // Снять заинтересованность в дружбе
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

        $remove = sanitizeString($url);
        queryMysql("DELETE FROM friends WHERE user='$url' AND friend='$this->user'");

        $this->view->redirect('users');

    }

    public function addFriend(){

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/add/', '', $url);

        $add = sanitizeString($url);
        $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$this->user'");

        if (!$result->num_rows)
            queryMysql("INSERT INTO friends VALUES ('$add', '$this->user')");

        $this->view->redirect('users');
    }

    public function showProfile(){



        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/id/', '', $url);

        $result = queryMysql("SELECT * FROM profiles WHERE user='{$url}'");

        if ($result->num_rows) {

                $row = $result->fetch_assoc();
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
