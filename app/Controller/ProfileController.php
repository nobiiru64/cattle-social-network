<?php

namespace Cattle\Controller;

use Cattle\Controller;
use Cattle\View;
use Cattle\Model\Profile;

/**
 * Profile Class
 *
 */
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
        if ($_SESSION['user'])
            $this->loggedin = TRUE;
    }

    /**
     * Profile index me.php
     *
     * @return mixed
     */

    public function index()
    {
        if (!$this->loggedin)
            die();

        $text = "";
        $profile = Profile::get($this->user);

        if ($profile)
            $text = stripslashes(preg_replace('/\s\s+/', ' ', $profile['text']));

        $this->view->render('me', 'default', [
            'loggedin' => $this->loggedin,
            'appname' => getenv('APP_NAME'),
            'userString' => 'Хелло',
            'text'=> $text,
            'user'=> $this->user,
        ]);

    }

    /**
     * upload image
     *
     * @return mixed
     */

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

    public function changeUserDescription($request) {

        if (!$this->loggedin) die();
        $text = "";
        $result = Profile::get($this->user);

        if (isset($_POST['text'])) {
            $text = \Cattle\Core\Database::sanitazeString($_POST['text']);
            $text = preg_replace('/\s\s+/', ' ', $_POST['text']);
            if ($result) {
                Profile::update($this->user, $text);
            } else {
                Profile::create($this->user, $text);
            }
        }

        $this->view->redirect('profile');

    }
}
