<?php

namespace App\Models;

class AddPerson extends BaseModel{
    public function add($data){
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

                                $stmt = $this->db->prepare("INSERT INTO persons (name,surname,date,job) VALUES(?,?,?,?)");
                                $stmt->execute($params);
                                $addedRows = $stmt->rowCount();
                                if ($addedRows > 0) {
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