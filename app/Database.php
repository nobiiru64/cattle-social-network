<?php

namespace Cattle;

use PDO;

class Database {



    public $db;

    protected static function getDB()
    {

        $settings = self::getPDOSettings();

        static $db = null;
        if ($db === null) {

            $db = new PDO($settings['dsn'], $settings['user'], $settings['pass']);
            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $db;
    }

    public function sanitazeString($var){
        $db = self::getDB();
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return $db->quote($var);
    }


   private static function getPDOSettings(){

       $config = include "Config.php";
       $result['dsn'] = "{$config['type']}:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
       $result['user'] = $config['user'];
       $result['pass'] = $config['pass'];
       return $result;

   }
}
