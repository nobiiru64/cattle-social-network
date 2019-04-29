<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Users extends Database {

    public static function getAll(){

        $db = static::getDB();

        $stmt = $db->query('SELECT user FROM members ORDER BY user');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function followed($user, $friend) {
        $db = static::getDB();

        $stmt = $db->query("SELECT * FROM friends WHERE user='{$friend}' AND friend='{$user}'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function following($user, $friend) {

        $db = static::getDB();

        $stmt = $db->query("SELECT * FROM friends WHERE user='{$user}' AND friend='{$friend}'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public static function isFriends($user, $friend) {

        $db = static::getDB();

        $stmt = $db->query("SELECT * FROM friends WHERE user='{$friend}' AND friend='{$user}'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);


    }

    public static function addFriend($user, $friend){
        $db = static::getDB();

        $stmt = $db->query("INSERT INTO friends VALUES ('{$friend}', '{$user}')");
        return true;

    }

    public static function removeFriend($user, $friend){

        $db = static::getDB();

        $stmt = $db->query("DELETE FROM friends WHERE user='{$user}' AND friend='{$friend}'");

        return true;

    }

    public static function show($user) {

        $db = static::getDB();

        $stmt = $db->query("SELECT * FROM profiles WHERE user='{$user}'");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}

