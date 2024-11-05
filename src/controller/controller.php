<?php



namespace App\Controller;

use App\Models\AddPerson;
use App\Models\Aut;
use App\Models\DeletePerson;
use App\Models\EditPerson;
use App\Models\GetAll;
use App\Models\GetSearch;
use App\Models\MyExit;
use App\Models\Reg;

class Controller{
    public function print(){
        return 'Controller';
    }
    


    public function getAll(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['aut']) && $_SESSION['aut'] === true){
            $getAllModel=new GetAll();
            return $getAllModel->getAll();
        }
        return ['no access'];
    }

    public function getSearch($data){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['aut']) && $_SESSION['aut'] === true){
            $getSearch=new GetSearch();
            return $getSearch->getSearch($data);
        }
        return ['no access'];
    }

    public function add($data){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['aut']) && $_SESSION['aut'] === true){
            $addPerson=new AddPerson();
            return $addPerson->add($data);
        }
        return 'no access';
    }

    public function edit($data){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['aut']) && $_SESSION['aut'] === true){
            $editPerson=new EditPerson();
            return $editPerson->edit($data);
        }
        return 'no access';
    }

    public function delete($data){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION['aut']) && $_SESSION['aut'] === true){
            $deletePerson=new DeletePerson();
            return $deletePerson->delete($data);
        }
        return 'no access';
    }

    public function autoAut(){
        $autoAut=new Aut();
        return $autoAut->autoAut();
    }





    public function reg($data){
        $reg=new Reg();
        return $reg->reg($data);
    }

    public function aut($data){
        $aut=new Aut();
        return $aut->aut($data);
    }

    public function exit(){
        $exit=new Aut;
        return $exit->exit();
    }

}