<?php

namespace Cattle\Model;

use Cattle\Database;
use PDO;

class Members extends Database {

    public static function getAll(){

        $db = static::getDB();

        $stmt = $db->query('SELECT * FROM friends');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exist($user){

        $db = static::getDB();
        $result = $db->query("SELECT * FROM members WHERE user='{$user}'");
        return $result->rowCount();

    }

    public function create($user, $pass) {

        $db = static::getDB();
        $result = $db->query("INSERT INTO members VALUES('{$user}','{$pass}')");
        return $result;

    }

    public function auth($user , $pass) {



        $db = static::getDB();
        $result = $db->query("SELECT user,pass FROM members WHERE user='{$user}' AND pass='{$pass}'");
        return $result->rowCount();


    }
}
