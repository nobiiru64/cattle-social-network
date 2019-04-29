<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Friends extends Database {

    public static function getAll(){

        $db = static::getDB();

        $stmt = $db->query('SELECT * FROM friends');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

