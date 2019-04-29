<?php

namespace Cattle\Model;

use Cattle\Core\Database;
use PDO;

class Messages extends Database {


    public static function get($user) {
        "SELECT * FROM messages WHERE recip='{$user}' ORDER BY time DESC";
    }

    public static function delete($id, $user) {
        "DELETE FROM messages WHERE id={$id} AND recip='{$user}'";
    }
}
