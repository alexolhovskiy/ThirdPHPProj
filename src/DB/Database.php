<?php

namespace App\DB;

class Database {
    private static $connection = null;

    // Метод для получения соединения с БД
    public static function getConnection() {
        if (self::$connection === null) {
            $dsn = 'mysql:host=localhost;port=3306;dbname=test'; // Ваши настройки БД
            $username = 'root';
            $password = 'root';
            try {
                // Создаем новое подключение PDO
                self::$connection = new \PDO($dsn, $username, $password);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                return "Connection failed: " . $e->getMessage();
            }
        }
        return self::$connection;
    }
}
