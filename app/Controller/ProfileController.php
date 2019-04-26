<?php

namespace Nobiiru\Controller;

use Nobiiru\View;


class ProfileController
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

    public function uploadUserImage($request) {

        if (isset($_FILES['image']['name'])) {
            $saveto = $_SERVER['DOCUMENT_ROOT'] . "/../public/images/avatars/$this->user.jpg";
            move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
            $typeok = TRUE;
            switch ($_FILES['image']['type']) {
                case "image/gif":
                    $src = imagecreatefromgif($saveto);
                    break;
                case "image/jpeg":
                    //Как обычный, так и прогрессивный JPEG-формат
                case "image/pjpeg":
                    $src = imagecreatefromjpeg($saveto);
                    break;
                case "image/png":
                    $src = imagecreatefrompng($saveto);
                    break;
                default:
                    $typeok = FALSE;
                    break;
            }
            if ($typeok) {
                list($w, $h) = getimagesize($saveto);
                $max = 100;
                $tw = $w;
                $th = $h;
                if ($w > $h && $max < $w) {
                    $th = $max / $w * $h;
                    $tw = $max;
                } elseif ($h > $w && $max < $h) {
                    $tw = $max / $h * $w;
                    $th = $max;
                } elseif ($max < $w) {
                    $tw = $th = $max;
                }
                $tmp = imagecreatetruecolor($tw, $th);
                imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
                //imageconvolution($tmp, array(array(–1, –1, –1),array(–1, 16, –1), array(–1, –1, –1)), 8, 0);
                imagejpeg($tmp, $saveto);
                imagedestroy($tmp);
                imagedestroy($src);

                $this->view->redirect('profile');
            }
        }
    }

    public function changeUserDescription($request){

        if (!$this->loggedin) die();

        $result = queryMysql("SELECT * FROM profiles WHERE user='$this->user'");

        if (isset($_POST['text'])) {
            $text = sanitizeString($_POST['text']);
            $text = preg_replace('/\s\s+/', ' ', $text);
            if ($result->num_rows) {
                queryMysql("UPDATE profiles SET text='$text' where user='$this->user'");
            } else {
                queryMysql("INSERT INTO profiles VALUES('$this->user', '$text')");
            }
        }


        $this->view->redirect('profile');

    }


    public function index()
    {
        if (!$this->loggedin) die();

        $profile = queryMysql("SELECT * FROM profiles WHERE user='$this->user'");


        if ($profile->num_rows) {
            $row = $profile->fetch_array(MYSQLI_ASSOC);
            $text = stripslashes($row['text']);
        }  else {
            $text = "";
        }

        $avatarsPath = $_SERVER['DOCUMENT_ROOT'] . "/../public/images/avatars/";




        $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

        //showProfile($this->user);

        $this->view->render('me', 'default', [
            'loggedin' => $this->loggedin,
            'signup' => false,
            'text'=> $text,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user,
        ]);

    }
}
