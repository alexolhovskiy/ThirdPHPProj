<?php


namespace App\Models;

class GetSearch extends BaseModel{
    public function getSearch($data){
        $condition = [];
        $params = [];
    
        if($data['name'] !== ''){
            $condition[] = 'name = :name';
            $params[':name'] = $data['name'];
        }
        if($data['surname'] !== ''){
            $condition[] = 'surname = :surname';
            $params[':surname'] = $data['surname'];
        }
        if($data['job'] !== ''){
            $condition[] = 'job = :job';
            $params[':job'] = $data['job'];
        }
    
        if(($data['dateFrom'] !== '') && ($data['dateTo'] !== '')){
            $condition[] = 'date >= :fdate AND date <= :tdate';
            $params[':fdate'] = $data['dateFrom']; 
            $params[':tdate'] = $data['dateTo'];   
        } else {
            if($data['dateFrom'] !== ''){
                $condition[] = 'date >= :fdate';
                $params[':fdate'] = $data['dateFrom'];
            }
            if($data['dateTo'] !== ''){
                $condition[] = 'date <= :tdate';
                $params[':tdate'] = $data['dateTo'];
            }
        }
    
        $query = "SELECT * FROM persons";
    
        // Добавляем WHERE только если есть условия
        if (!empty($condition)) {
            $query .= " WHERE " . implode(' AND ', $condition);//соединяем строки через " AND "
        }
        //$query .=конкотенация строк через . - как +=
    
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
    
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}