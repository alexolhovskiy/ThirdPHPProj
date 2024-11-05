<?php

namespace App\Models;

class Reg extends BaseModel{

    public function getToken($l=32){
        return bin2hex(random_bytes($l));
    }

    public function reg($data){
        $params=[];

        if($data['login']!=='' && !preg_match('/[\s<>"\'\/\\`~,\.@#$%^&*()+={}[\]]/',$data['login'])){
            $params[]=$data['login'];
            
            $stmt = $this->db->prepare("SELECT * FROM users WHERE login=?");
            $stmt->bindValue(1,$data['login']);
            $stmt->execute();
            if($stmt->rowCount()===0){
                if($data['email']!=='' && preg_match('/[\w]+@[a-z]+\.[a-z]+/',$data['email'])){
                    $params[]=$data['email'];
    
                    if($data['pass']!=='' && strlen($data['pass'])>=6 && !preg_match('/[\s]/',$data['pass'])){
                        $params[]=$data['pass'];
                        if($data['checkBox']){
                            $params[]=$this->getToken(10);
                        }else{
                            $params[]='';
                        }
                        
                        $stmt = $this->db->prepare("INSERT INTO users (login,email,pass,token) VALUES(?,?,?,?)");

                        if ($stmt->execute($params)) {
                            if (session_status() == PHP_SESSION_NONE) {
                                session_start();
                            }
                            $_SESSION['aut']=true;
                            if($data['checkBox']){
                                setcookie('aut',$params[count($params)-1],time()+864000,'/');
                            }
                            return $data['login'];
                        }
                    }else{
                        return 'error pass';
                    }
                }
            }else{
                return 'error login exists';
            }
        }else{
            return 'error login';
        }
        return 'error';
    }
}