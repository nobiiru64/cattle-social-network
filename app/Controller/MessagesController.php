<?php

namespace Cattle\Controller;

use Cattle\View;
use Cattle\Model\Messages;


class MessagesController
{
    public $view;
    public $loggedin;
    public $user;
    public function __construct() {
        $this->view = new View();
        $this->auth = \Cattle\App::auth();
        if ($_SESSION) $this->user = $_SESSION['user'];
        if ($_SESSION['user'])
            $this->loggedin = TRUE;
    }

    public function index()
    {

        if (!$this->loggedin) die();

        if (isset($_GET['view'])) {
            $view = sanitizeString($_GET['view']);
        } else {
            $view = $this->loggedin;
        }

        if ($view != "") {
            if ($view == $this->user) {
                $name1 = $name2 = "Your"; // Ваши
            } else {
                $name1 = "<a href='members.php?view=$view'>$view</a>'s";
                $name2 = "$view's";
            }


            if (isset($_GET['erase'])) {
                $id = sanitizeString($_GET['erase']);
                Messages::delete($id, $this->user);
            }


            $result = Messages::get($this->user);
            $num = $result;
            $messages = [];
            print_r($result);
            for ($j = 0 ; $j < $num ; ++$j)
            {
                $row = $result->fetch_array();

                if ($row[3] == 0 || $row[1] == $this->user || $row[2] == $this->user)
                {
                    $messages[] = $row;
                    //  echo date('d.m.y H:i:s', $row[4]);
                    //  echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
                    if ($row['pm'] == 0) {
                        //    echo "Написал: &quot;{$row['message']}&quot; ";
                    } else {
                        //   echo "Написал (PM): <span class='whisper'>" . "&quot;{$row['message']}&quot;</span> ";
                    }


                    if ($row['recip'] == $this->user) {
                        //  echo "[<a href='messages.php?view=$view" ."&erase={$row['id']}>erase</a>]";
                    }

                }

            }
            // Обновить сообщения
            "<a class='button' href='friends.php?view=$view'>View $name2 friends</a>";
        }

        $this->view->render('messages', 'default', [
            'loggedin' => $this->loggedin,
            'signup' => false,
            //   'text'=> $text,
            'action' => "/messages/{$this->user}",
            'message_count' => $num,
            'member'=> false,
            'messages' => $messages,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user,
            //  'avatar'=> $avatar
        ]);

    }

    public function sendMessage() {

        $url = '';

        if (isset($_POST['text']))
        {
            $text = sanitizeString($_POST['text']);
            if ($text != "")
            {
                $pm = substr(sanitizeString($_POST['pm']),0,1);
                $time = time();
                queryMysql("INSERT INTO messages VALUES(NULL, '$this->user','$url', '$pm', $time, '$text')");
            }

        }
    }

    public function removeMessage(){

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/messages/', '', $url);


        if (isset($_GET['erase']))
        {
            $erase = sanitizeString($_GET['erase']);
            queryMysql("DELETE FROM messages WHERE id=$erase AND recip='{$this->user}'");
        }

        $this->view->redirect("messages/{$url}");
    }

    public function showMessagesPost(){

        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/messages/', '', $url);

        $view = $this->user;

        if (isset($url)) {

            $view = sanitizeString($url);

            if ($view == '') $view = $this->user;

        }

        if (isset($_POST['text']))
        {
            $text = sanitizeString($_POST['text']);

            if ($text != "")
            {
                $pm = substr(sanitizeString($_POST['pm']),0,1);
                $time = time();
                queryMysql("INSERT INTO messages VALUES(NULL, '{$this->user}','{$view}', '$pm', $time, '$text')");
            }


        }


        $this->view->redirect("messages/{$url}");
    }


    public function showMessages(){
        $url = $_SERVER['REQUEST_URI'];
        $url = str_replace('/messages/', '', $url);
        $url = rtrim($url,'/');

        $profile = queryMysql("SELECT * FROM profiles WHERE user='{$url}'");


        if ($profile->num_rows) {
            $row = $profile->fetch_array(MYSQLI_ASSOC);
            $member_text = stripslashes($row['text']);
        }  else {
            $member_text = "";
        }

        if (!$this->loggedin) die();

        else $view = $this->loggedin;





        if ($view != "")
        {
            if ($view == $this->user) $name1 = $name2 = "Your"; // Ваши
            else
            {
                $name1 = "<a href='members.php?view=$view'>$view</a>'s";
                $name2 = "$view's";
            }


            // Сообщения

            if (isset($_GET['erase']))
            {
                $erase = sanitizeString($_GET['erase']);
                queryMysql("DELETE FROM messages WHERE id=$erase AND recip='{$url}'");
            }
            $query = "SELECT * FROM messages WHERE recip='{$url}' ORDER BY time DESC";
            $result = queryMysql($query);
            $num = $result->num_rows;
            $messages = [];
            for ($j = 0 ; $j < $num ; ++$j)
            {
                $row = $result->fetch_array();

                if ($row[3] == 0 || $row[1] == $this->user || $row[2] == $this->user)
                {
                    $messages[] = $row;
                    //  echo date('d.m.y H:i:s', $row[4]);
                    //  echo " <a href='messages.php?view=$row[1]'>$row[1]</a> ";
                    if ($row['pm'] == 0) {
                        //    echo "Написал: &quot;{$row['message']}&quot; ";
                    } else {
                        //   echo "Написал (PM): <span class='whisper'>" . "&quot;{$row['message']}&quot;</span> ";
                    }


                    if ($row['recip'] == $this->user) {
                        //  echo "[<a href='messages.php?view=$view" ."&erase={$row['id']}>erase</a>]";
                    }

                }

            }
            // Обновить сообщения
            "<a class='button' href='friends.php?view=$view'>View $name2 friends</a>";
        }




        $this->view->render('messages', 'default', [
            'loggedin' => $this->loggedin,
            'signup' => false,
            //   'text'=> $text,
            'member' => $url,
            'action' => "/messages/{$url}",
            'message_count' => $num,
            'member_text'=> $member_text,
            'messages' => $messages,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user,
            //  'avatar'=> $avatar
        ]);
    }


}

