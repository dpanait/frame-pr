<?php

class Login extends Controller{
    //private $api_request = null;
    private $_sessionName, $_cookieName, $_usersAdd;

    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        //$this->load_model("Apirequest");
        $this->db_multi = DB_MULTI::getInstance();
        $this->api_request = new Apirequest($this->db_multi->_db_bullcard,$this->db_multi->_db_buygest);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_usersAdd = new UsersAdd();
    }

    public function indexAction(){
       
        $validation = new Validate();
        if($_POST){
	       
            if($_POST["type_form"] == "login"){
                //login
                $data = new stdClass();
                $data->email = $_POST['email'];
                $data->password = $_POST['password'];
    
                $api = (object)$this->api_request->login($data);
            } else {
	            if(isset($_POST["regEmail"])){
                    // registrar usuario
                    $data = new stdClass();
                    $data->email = $_POST['regEmail'];
                    $data->password = $_POST['regPassword'];
        
                    $api = (object)$this->api_request->signup($data);
                    $api->login_status = $api->user_created;
                 }

            }           
            if($api->login_status){
                Session::set($this->_sessionName, $api->data_user["users_id"]);
                //$_SESSION['users_id'] = $api->data_user["users_id"];
                //dnd("redirect");
                $hash = md5((int)uniqid() + rand(0, 100) );
                //$user_agent = Session::uagent_no_version();
                Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);

                if($api->step != null){
                    
                    switch($api->step){
                        case"1":
                            Router::redirect('login/paso2/'.$api->data_user["users_id"]);
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
                
            } else {
                //añadimos el error para mostrarlo
                $validation->addError($api->msg); 
            }
        }
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('login/index');
      
    }

    public function paso2Action($params = []){

        if(!Session::exists(CURRENT_USER_SESSION_NAME)){
            Router::redirect('');
        }
        $validation = new Validate();
        $users_id = Session::get(CURRENT_USER_SESSION_NAME);
        $a_view = [];
        // select users_data
        $a_view["profile_users"] = (object)$this->_usersAdd->get_login_user($users_id);
        //print_r($a_view["profile_users"]);
        //print_r($_POST);
        if(isset($_POST["cardNumber"])){

            // declaramos las variables necesaia para completar el registro
            $data = new stdClass();
            $data->cardNumber = Input::get("cardNumber");
            $data->name = Input::get("name");
            $data->telephone = Input::get("telephone");
            $data->nif = Input::get("nif");
            $data->users_id = $users_id;
            // guardamos los dataos del registro
            $api = (object)$this->api_request->signup_complete($data);
            //print_r($api);
            //$this->view->render('login/paso2');
            if($api->status){
                // si se han guardado los datos redireccionamos a gustos
                Router::redirect('login/gustos'); 
            } else {
                //echo $this->_usersAdd->find_users_attempts($users_id);
                if($this->_usersAdd->find_users_attempts($users_id) > 10){
                    $a_view["num_attempts"] = $this->_usersAdd->find_users_attempts($users_id);
                    $validation->addError("Demasiados intentos para guadar tarjeta, porfavor pongase en contacto con el administrador.");

                }
                
                ($api->msg != "") ? $validation->addError($api->msg) : ""; 
                //$this->view->displayErrors = $validation->displayErrors();
                //$this->view->render('login/paso2');
            }
            $_POST = array();
            
        }
        foreach($_POST as $post){
            print_r($post);
            unset($post);
            array_unshift($_POST);
        }
        $_POST = array();
        //print_r($_POST);
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('login/paso2',$a_view);
               
    }
    public function gustosAction(){
        if(!Session::exists(CURRENT_USER_SESSION_NAME)){
            Router::redirect('');
        }
        $a_view = [];
        $users_id = Session::get(CURRENT_USER_SESSION_NAME);
        // select users_data
        $a_view["profile_users"] = (object)$this->_usersAdd->get_login_user($users_id);

        if($_POST){
            //echo "USER_SESSION_ID: ".$users_id."<br>";
            //print_r($_POST);
            $a_gustos = [];
            foreach($_POST as $key => $val){
                $a_gustos[]= ucwords($key);
            }
            //print_r($a_gustos);
            $data = new stdClass();
            $data->users_id = $users_id;
            $api = (object)$this->api_request->preferences($data, $a_gustos);
            //var_dump($api);
            if($api->status){
                // si se han guardado los datos redireccionamos a perfil
                Router::redirect('login/adisfrutar'); 
            }
        }

        $this->view->render('login/gustos',$a_view);
        
    }
    public function adisfrutarAction(){
        if(!Session::exists(CURRENT_USER_SESSION_NAME)){
            Router::redirect('');
        }
        $users_id = Session::get(CURRENT_USER_SESSION_NAME);
        $data = [
            "name"=>"A disfrutar",
            "cant" => 12,
            "profile_users" => (object)$this->_usersAdd->get_login_user($users_id),
        ];
        $this->view->render('login/adisfrutar',$data);
    }
    /*public function logoutAction(){
        Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        Router::redirect("");
    }  */  

}