<?php

class Router {
    public static function route($url){
       //controllers
       $controller = (isset($url[0]) && $url[0] != '')? ucwords($url[0]) : DEFAULT_CONTROLLER;
       $controller_name = $controller;
       array_shift($url);

       // Actions
       $action = (isset($url[0]) && $url[0] != '')? $url[0] .'Action' : 'indexAction';
       $action_name = $action;
       array_shift($url);

       // params
       $queryParams = $url;
       //print_r($url);
        if(class_exists($controller_name)){
            $dispatch = new $controller($controller_name,$action);
            if(method_exists($controller,$action)){
                call_user_func_array([$dispatch,$action],$queryParams);
            }
            else{
                self::redirect('');
                //die('Este metodo no existe en el controlador \"' .$controller_name. '\"');
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            die('<div class="alert-danger">Pagina no encontrada</div>');
        }
    }

    public static function redirect($location){
        if(!headers_sent()){
            header('Location: ' . PROOT . $location);
            exit();
        } else {
            echo "<script type='text/javascript'>";
            echo " window.location.href = '" .PROOT . $location."';";
            echo "</script>";
            echo "<noscript>";
            echo "<meta http-equiv='refresh' content='0;url='".$location."' />";
            echo "</noscript>";exit;

        }
    }
}
