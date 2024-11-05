<?php

namespace App\Models;

class MyExit extends BaseModel{
    public function exit(){
        if(isset($_COOKIE['aut'])){
            $stmt = $this->db->prepare("SELECT * FROM users WHERE token=?");
            $stmt->bindValue(1,$_COOKIE['aut']);
            $stmt->execute();
            $temp=$stmt->fetch(\PDO::FETCH_ASSOC);
            if($temp){
                $stmt = $this->db->prepare("UPDATE users SET token='X' WHERE login=?");
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