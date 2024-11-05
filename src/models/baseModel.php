<?php


namespace App\Models;

use App\DB\Database; //имя папки и имя файла должно было совпадать с пространством имен и классом: DB==DB; Database.php==Database!

class BaseModel {
    protected $db;

    public function __construct() {
        // Получаем соединение с базой данных из статического метода Database
        $this->db = Database::getConnection();
    }
}
