<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Feed extends Database
{

    public static function getAll()
    {

        $db = static::getDB();

        $stmt = $db->query('SELECT * FROM feed ORDER BY id desc LIMIT 10');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($user, $text)
    {
        $db = static::getDB();
        $stmt = $db->query("INSERT INTO feed VALUES('','{$user}', '{$text}', NOW())");
        return $stmt;
    }

    public static function delete($user, $id)
    {
        $db = static::getDB();

        $stmt = $db->query("DELETE FROM feed WHERE id='{$id}' AND user='{$user}'");
        return $stmt;
    }
}

