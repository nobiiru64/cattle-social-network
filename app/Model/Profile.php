<?php

namespace Cattle\Model;

use Cattle\Database;
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
}
