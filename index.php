<?php

define('DS',DIRECTORY_SEPARATOR);
define('ROOT',dirname(__FILE__));

// load configuraciones y helpers funciones
require_once(ROOT . DS .'config' .DS . 'config.php');
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
    }
}
spl_autoload_register('autoload');

session_start();
//print_r($_SERVER);
$url = isset($_SERVER['REDIRECT_URL']) ? explode('/',ltrim($_SERVER['REDIRECT_URL'],'/')): [];//REQUEST_URI
//echo "<pre>";
array_shift($url);
 if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
     Users::loginFromCookie();
 }
// router
Router::route($url);
