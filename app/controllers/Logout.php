<?php

class Logout extends Controller{
	
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
     
    }
    public function indexAction(){
	    Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        Router::redirect("");
    }
}	