<?php

header("Access-Control-Allow-Origin: http://your-frontend-domain.com");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once(__DIR__.'/../vendor/autoload.php');

use App\Controller\Controller;

if(session_status()==PHP_SESSION_NONE){
    session_start();
    $autoautController=new Controller();
    $autoautController->autoAut();
    // echo json_encode($autoautController->autoAut());
}


if($_SERVER['REQUEST_METHOD']=='GET'){
    if(trim(str_replace('/','',$_SERVER['REQUEST_URI']))==''){
        require'index.html';
        exit();
    }

    switch(strtok(str_replace('/app','',$_SERVER['REQUEST_URI']),'?')){
        default:
            header('Location: /page404.html');
            exit();

    }

}elseif($_SERVER['REQUEST_METHOD']=='POST'){

    switch(strtok(str_replace('/app','',$_SERVER['REQUEST_URI']),'?')){

        case '/all':
            $getAllController=new Controller();
            echo json_encode($getAllController->getAll());
            break;
        case '/add':
            $controller=new Controller();
            // Читаем содержимое тела запроса
            $json = file_get_contents('php://input');

            // Декодируем JSON в ассоциативный массив
            $data = json_decode($json, true);
            echo json_encode($controller->add($data));
            break;
        case '/edit':
            $controller=new Controller();
            // Читаем содержимое тела запроса
            $json = file_get_contents('php://input');

            // Декодируем JSON в ассоциативный массив
            $data = json_decode($json, true);
            echo json_encode($controller->edit($data));
            break;
        case '/delete':
            $controller=new Controller();
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            echo json_encode($controller->delete($data));
            break;
        case '/search':
            $controller=new Controller();
            // Читаем содержимое тела запроса
            $json = file_get_contents('php://input');

            // Декодируем JSON в ассоциативный массив
            $data = json_decode($json, true);
            echo json_encode($controller->getSearch($data));
            break;
        case '/reg':
            $controller=new Controller();
            // Читаем содержимое тела запроса
            $json = file_get_contents('php://input');

            // Декодируем JSON в ассоциативный массив
            $data = json_decode($json, true);
            echo json_encode($controller->reg($data));
            break;
        case '/aut':
            $controller=new Controller();
            // Читаем содержимое тела запроса
            $json = file_get_contents('php://input');

            // Декодируем JSON в ассоциативный массив
            $data = json_decode($json, true);
            echo json_encode($controller->aut($data));
            break;
        case '/exit':
            $controller=new Controller();
            echo json_encode($controller->exit());
            break;
        default:
            header('Location: /page404.html');
            exit();

    }
}
