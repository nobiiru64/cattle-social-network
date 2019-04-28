<?php

if (!function_exists('test')) {
    function test(){
        echo 'test';
    }
}

if (!function_exists('asset')) {
    function asset($file){
        echo getenv('APP_URL') . '/' . $file;
        return null;
    }
}

if (!function_exists('getUserAvatar')) {
    function getUserAvatar(){
        echo (file_exists($_SERVER['DOCUMENT_ROOT'] . "/../public/images/avatars/".$_SESSION['user'].'.jpg')) ?
             "/images/avatars/" . $_SESSION['user'] . '.jpg' :  "/images/noavatar.png";
    }
}

if (!function_exists('getAvatar')) {
    function getAvatar($user){
        echo (file_exists($_SERVER['DOCUMENT_ROOT'] . "/../public/images/avatars/".$user.'.jpg')) ?
            "/images/avatars/" . $user . '.jpg' :  "/images/noavatar.png";
    }
}


if (!function_exists('destroySession')) {
    function destroySession(){
        $_SESSION = array();

        if (session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time() - 2592000, '/');

        session_destroy();
    }
}
