<?php
if ($_SERVER['HTTP_HOST'] == 'www.yuubbb.com' && $_SERVER['HTTP_HOST'] == 'yuubbb.com'){
    header("Location: https://yuubbb.com".$_SERVER['REQUEST_URI']);
}
define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__));

// load configuraciones y helpers funciones
require_once(ROOT . DS .'config' .DS . 'config.php');
//include ROOT . DS .'config' .DS . 'conexion.php';
require_once(ROOT . DS . 'app' . DS . 'libs' . DS . 'helpers' . DS . 'functions.php');

// Autoload classes
function autoload($className){
    if(file_exists(ROOT . DS .'core' . DS . $className . '.php')){
        require_once(ROOT . DS .'core' . DS . $className . '.php');
    }elseif (file_exists(ROOT . DS .'app' . DS .'controllers' . DS . $className . '.php')){
        require_once(ROOT . DS .'app' . DS .'controllers' . DS . $className . '.php');
    }elseif (file_exists(ROOT . DS .'app' . DS .'models' . DS . $className . '.php')){
        require_once(ROOT . DS .'app' . DS .'models' . DS . $className . '.php');
    }elseif (file_exists(ROOT . DS .'app' . DS .'controllers' . DS . $className . '.php')){
        require_once(ROOT . DS .'app' . DS .'controllers' . DS . $className . '.php');
    }elseif (file_exists(ROOT . DS .'app' . DS .'class' . DS . $className . '.php')){
        require_once(ROOT . DS .'app' . DS .'class' . DS . $className . '.php');
    }
}
spl_autoload_register('autoload');

session_start();
//print_r($_SERVER);
$url = isset($_SERVER['REDIRECT_URL']) ? explode('/',ltrim($_SERVER['REDIRECT_URL'],'/')): [];//REQUEST_URI
/*echo "<pre>";
print_r($url);*/
array_shift($url);array_shift($url);
 /*if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
     Users::loginFromCookie();
 }*/
// router
Router::route($url);
