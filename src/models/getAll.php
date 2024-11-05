<?php


namespace App\Models;


class GetAll extends BaseModel{
    public function getAll(){
        $stmt = $this->db->prepare("SELECT * FROM persons");
        $stmt->execute();

        // Возвращаем результат
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}