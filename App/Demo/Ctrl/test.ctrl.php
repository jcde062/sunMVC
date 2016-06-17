<?php
function __autoload($classname){
    $filename = "../Model/".$classname.".class.php";
    if(is_file($filename)){
        include $filename;
    }else{
    	die("file not exits");
    }
}

$test1 = new login();
$test1 -> checkLogin();

menber::getMenbers();

user::getUser();


?>