<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Feed extends Database {

    public static function getAll(){

        $db = static::getDB();

        $stmt = $db->query('SELECT * FROM feed ORDER BY id desc');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($user, $text) {
        $db = static::getDB();
        $stmt = $db->query("INSERT INTO feed VALUES('','{$user}', '{$text}', NOW())");
        return $stmt;
    }





}

