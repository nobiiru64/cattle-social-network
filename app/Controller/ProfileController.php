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
                $ratio = $w / $h;

                $targetWidth = $targetHeight = min(100, max($w, $h));

                if ($ratio < 1) {
                    $targetWidth = $targetHeight * $ratio;
                } else {
                    $targetHeight = $targetWidth / $ratio;
                }

                $srcWidth = $w;
                $srcHeight = $h;
                $srcX = $srcY = 0;

                $targetWidth = $targetHeight = min($w, $h, 100);

                if ($ratio < 1) {
                    $srcX = 0;
                    $srcY = ($w / 2) - ($h / 2);
                    $srcWidth = $srcHeight = $w;
                } else {
                    $srcY = 0;
                    $srcX = ($w / 2) - ($h / 2);
                    $srcWidth = $srcHeight = $h;
                }

                $tmp = imagecreatetruecolor($targetWidth, $targetHeight);
                imagecopyresampled($tmp, $src, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $srcWidth, $srcHeight);
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
