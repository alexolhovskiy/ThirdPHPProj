<?php

if(preg_match('/\.(?:png|jpg|jpeg|gif|css|js|html)$/',$_SERVER['REQUEST_URI'])){
    return false;
}else{
    require __DIR__ . '/public/index.php';
}