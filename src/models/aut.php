<?php

namespace App\Models;

class Aut extends BaseModel{
    private static string $token='';



    public function getToken($l=32){
        return bin2hex(random_bytes($l));
    }

    public function aut($data){
        $params=[];
        $query='';
        
        
        if($data['checkBox']){
            $params[]=$this->getToken(10);
            $params[]=$data['login'];
            $params[]=$data['pass'];
            $query="UPDATE users SET token=? WHERE login=? AND pass=?";
        }else{
            // $params[]='';
            // $params[]=$data['login'];
            // $params[]=$data['pass'];
            // $query="UPDATE users SET token=? WHERE login=? AND pass=?";
            $params[]=$data['login'];
            $params[]=$data['pass'];
            $query="SELECT * FROM users WHERE login=? AND pass=?";
        }
                        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $updatedRows = $stmt->rowCount();

        if ($updatedRows > 0) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['aut']=true;
            if($data['checkBox']){
                setcookie('aut',$params[0],time()+864000,'/');
            }
            return $data['login'];
        }
        return 'error';
    }

    public function autoAut(){
        if(isset($_COOKIE['aut'])){
            $stmt = $this->db->prepare("SELECT * FROM users WHERE token=?");
            $stmt->bindValue(1,$_COOKIE['aut']);
            $stmt->execute();
            $temp=$stmt->fetch(\PDO::FETCH_ASSOC);
            if($temp){
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['aut']=true;
                
                $temp2=$this->getToken(10);
                Aut::$token=$temp2;
                $stmt = $this->db->prepare("UPDATE users SET token=? WHERE login=? AND pass=?");
                $stmt->bindValue(1,$temp2);
                $stmt->bindValue(2,$temp['login']);
                $stmt->bindValue(3,$temp['pass']);
                $stmt->execute();
                setcookie('aut',$temp2,time()+864000,'/');
            }
            return $temp['login'];
        }
        // else{
        //     if (session_status() == PHP_SESSION_NONE) {
        //         session_start();
        //     }
        //     $_SESSION['aut']=false;
        // }
    }

    public function exit(){
        if(isset($_COOKIE['aut'])){
            $stmt = $this->db->prepare("SELECT * FROM users WHERE token=?");
            $stmt->bindValue(1,Aut::$token);
            $stmt->execute();
            $temp=$stmt->fetch(\PDO::FETCH_ASSOC);
            if($temp){
                $stmt = $this->db->prepare("UPDATE users SET token='' WHERE login=?");
                // $stmt->bindValue(1,'');
                $stmt->bindValue(1,$temp['login']);
                // $stmt->bindValue(3,$temp['pass']);
                $stmt->execute();
            }
            setcookie('aut',' ',time()-3600);
        }
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['aut']=false;
        unset($_SESSION['aut']);
        session_destroy();
        return 'error';
    }
}