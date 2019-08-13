<?php

define('DEBUG',true);

define('DB_HOST_BULLCARD','77.81.116.38'); //dbase host use IP to avoid dns lockup
define('DB_NAME_BULLCARD','z_bullcard'); //dbname
define('DB_USER_BULLCARD','yuubbbroot'); //dbase user
define('DB_PASSWORD_BULLCARD','Ahyooqu1Sheuchie'); //dbase password 

define('DB_HOST_BUYGEST','77.81.116.38'); //dbase host use IP to avoid dns lockup
define('DB_NAME_BUYGEST','YUB_global_test'); //dbname
define('DB_USER_BUYGEST','yuubbbroot'); //dbase user
define('DB_PASSWORD_BUYGEST','Ahyooqu1Sheuchie'); //dbase password 

//conexion para dos base de datos
$config_bullcard=array(
    'DB_HOST'=>'77.81.116.38',
    'DB_USERNAME'=>'yuubbbroot',
    'DB_PASSWORD'=>'Ahyooqu1Sheuchie',
    'DB_DATABASE'=>'z_bullcard'
  );
$config_buygest=array(
      'DB_HOST'=>'77.81.116.38',
      'DB_USERNAME'=>'yuubbbroot',
      'DB_PASSWORD'=>'Ahyooqu1Sheuchie',
      'DB_DATABASE'=>'YUB_global_test'
    );

define('DEFAULT_CONTROLLER','Home');// definimos el controlador pro defecto si no esta definido en la url

define('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller use thie layout     

define('PROOT', '/api-bullcard/api_web/');// site root disrectory set thie to '/'
define("URLPUBLIC",'/api-bullcard/api_web/public/'); //cargar todos los archivos js css img

define('SITE_TITLE','Bull Card'); // if not defined the site title use this

define('CURRENT_USER_SESSION_NAME','JdqTyrArregjgRjhvfAVjhfy');// session name for loggen in user
define('REMEMBER_ME_COOKIE_NAME','y7T63Rtdghfdr6899Utyvfdr9');// cookie name for looggen in user remember me
define('REMEMBER_ME_COOKIE_EXPIRY',604800);// session in seconds during live 30 days 
