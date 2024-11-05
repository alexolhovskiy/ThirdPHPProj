<?php

namespace App\Models;

class EditPerson extends BaseModel{
    public function edit($data){
        $params=[];

        if($data['name']!=='' && !preg_match('/[\W\d\s]/',$data['name'])){
            $params[]=$data['name'];
            
            if($data['surname']!=='' && !preg_match('/[\W\d\s]/',$data['surname'])){
                $params[]=$data['surname'];
                
                if($data['date']!==''){
                    $parts = explode('-', $data['date']);
                    
                    if (count($parts) == 3) {
                        if(checkdate($parts[1], $parts[2], $parts[0])){
                            $params[]=$data['date'];

                            if($data['job']!=='' && !preg_match('/[\W\d\s]/',$data['job'])){
                                $params[]=$data['job'];

                                $params[]=$data['id'];

                                $stmt = $this->db->prepare("UPDATE persons SET name=?,surname=?,date=?,job=? WHERE id=?");
                                $stmt->execute($params);

                                $updatedRows = $stmt->rowCount();

                                if ($updatedRows > 0) {
                                    return 'done';
                                }
                            }
                        }
                    }
                }
            }
        }
        return 'error';
    }   
}