<?php
require_once '../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__.'/..');
$dotenv->load();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Настройка базы данных</title>
    </head>
    <body>
    <h3>Установка...</h3>
    <form action="install.php" method="post">
        <input type="hidden" name="install">
        <button>Установить</button>
    </form>
    <br><br>
<?php


if (isset($_POST['install']) && $_SERVER['REQUEST_METHOD'] == "POST") {

    $connection = mysqli_connect("127.0.0.1", "root", "123123", "sv_social");

    function createTable($name, $query){
        queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
        echo "Таблица '$name' создана или уже существовала<br>";
    }

    function queryMysql($query){
        global $connection;
        $result = $connection->query($query);
        if (!$result) die($connection->error);
        return $result;
    }


     createTable('members',
         'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
         user VARCHAR(16), 
                pass VARCHAR(16),
                 INDEX(user(6))'
     );

    createTable('feed',
        'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                user VARCHAR(16),
                message VARCHAR(255),
                created_at datetime
                '

            );
     createTable('messages',
         'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                 auth VARCHAR(16),
                 recip VARCHAR(16),
                 pm CHAR(1),
                 time INT UNSIGNED,
                 message VARCHAR(4096),
                 INDEX(auth(6)),
                 INDEX(recip(6))'
     );

     createTable('friends',
         'user VARCHAR(16),
                friend VARCHAR(16),
                INDEX(user(6)),
                INDEX(friend(6))'
     );

     createTable('profiles',
         'user VARCHAR(16),
                text VARCHAR(4096),
                INDEX(user(6))'
     );

     $end = '<br>...Завершена. <br>';
     $end.= '(Рекомендуется удалить файл install.php после установки)';
     echo $end;
}
?>
</body>
</html>
