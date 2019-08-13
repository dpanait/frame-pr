<?php

class Home extends Controller{
    private $_sessionName, $_cookieName;
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
    }
    public function indexAction(){
        //dnd($_SESSION);
        $a_view["submit"] = false;
       
        if($_POST){
            //print_r($_POST);
            $users_id = Input::get("users_id");
            if($users_id > 0){
                // buscamos el paso donde se ha quedado el usuario
                $usersAdd = new UsersAdd();

                Session::set($this->_sessionName, $users_id);
                //$_SESSION['users_id'] = $api->data_user["users_id"];
                //dnd("redirect");
                $hash = md5((int)uniqid() + rand(0, 100) );
                //$user_agent = Session::uagent_no_version();
                Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);

                $step = $usersAdd->usersSteps($users_id);

                if($step != null){
                    
                    switch($step){
                        case"1":
                            Router::redirect('login/paso2/'.$users_id);
                        break;
                        case"2":
                            Router::redirect('login/gustos');
                        break;
                        case"3":
                            Router::redirect('login/adisfrutar');
                        break;
                    }
                } else {
                    // si el step esta en null redirigimos a perfil
                    Router::redirect('perfil/index');
                }
                $a_view["submit"] = true;
            }
            
        }
        $_POST = array();
        $this->view->render('home/index',$a_view);
        
    }
    public function homeAction(){

        $this->view->render('home/home');
    }
    public function errorAction(){

        $this->view->render('home/error');
    }
    public function cuatrosientosAction(){
        //dnd($_SESSION);
        $this->view->render('home/cuatro');
        
    }
}