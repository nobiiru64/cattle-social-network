<?php

namespace Cattle\Controller;

use Cattle\Controller;
use Cattle\View;
use Cattle\Model\Profile;


class ProfileController
{

    public $view;
    public $loggedin;
    public $user;
    public $auth;

    public function __construct()
    {
        $this->view = new View();
        $this->auth = \Cattle\App::auth();
        if ($_SESSION) $this->user = $_SESSION['user'];

        if ($_SESSION['user']) $this->loggedin = TRUE;


    }

    public function index()
    {
        if (!$this->loggedin)
            die();


        if (!$profile = Profile::get($this->user)) {
            $test = '';
        } else {
            $text = stripslashes($profile['text']);

        }

        $avatarsPath = $_SERVER['DOCUMENT_ROOT'] . "/../public/images/avatars/";

        $text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

        $this->view->render('me', 'default', [
            'loggedin' => true,
            'signup' => false,
            'text'=> $text,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'user'=> $this->user,
        ]);

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
}
