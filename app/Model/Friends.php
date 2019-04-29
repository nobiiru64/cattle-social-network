<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Friends extends Database {

    public static function getFollowers($user) {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM friends WHERE user='{$user}'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getFollowing($user) {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM friends WHERE user='{$user}'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}

