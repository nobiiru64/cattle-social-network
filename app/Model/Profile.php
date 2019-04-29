<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Profile extends Database {

    public static function get($user){

        $db = static::getDB();

        $stmt = $db->query("SELECT * FROM profiles WHERE user='{$user}'");
        $profle = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return reset($profle);

    }

    public static function getAll(){

        $db = static::getDB();

        $stmt = $db->query('SELECT * FROM friends');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($user, $text){

        $db = static::getDB();
        $stmt = $db->query("INSERT INTO profiles VALUES('{$user}', '{$text}')");
        return $stmt;

    }

    public static function update($user, $text){

        $db = static::getDB();
        $stmt = $db->query("UPDATE profiles SET text='{$text}' where user='{$user}'");

        return $stmt;

    }
}
