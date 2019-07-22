<?php

define('DEBUG',true);

define('DB_HOST','185.224.138.206'); //dbase host use IP to avoid dns lockup
define('DB_NAME','u723114805_test'); //dbname
define('DB_USER','u723114805_admin'); //dbase user
define('DB_PASSWORD','TuT72GznR'); //dbase password 

define('DEFAULT_CONTROLLER','Home');// definimos el controlador pro defecto si no esta definido en la url

define('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller use thie layout     

define('PROOT', '/prueba/');// site root disrectory set thie to '/'

define('SITE_TITLE','Prueba MVC Framework'); // if not defined the site title use this

define('CURRENT_USER_SESSION_NAME','JdqTyrArregjgRjhvfAVjhfy');// session name for loggen in user
define('REMEMBER_ME_COOKIE_NAME','y7T63Rtdghfdr6899Utyvfdr9');// cookie name for looggen in user remember me
define('REMEMBER_ME_COOKIE_EXPIRY',604800);// session in seconds during live 30 days 