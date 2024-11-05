<?php

namespace App\Models;

class DeletePerson extends BaseModel{
    public function delete($data){
        $params=[];
        $params[]=$data['id'];
        $stmt = $this->db->prepare("DELETE FROM persons WHERE id=?");
        $stmt->execute($params);
        $deletedRows = $stmt->rowCount();

        if ($deletedRows > 0) {
            return 'done';
        }else{
            return 'error';
        }
    }
}