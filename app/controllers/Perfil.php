<?php

class Perfil extends Controller{
    private $_usersAdd;
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        //$this->load_model("Apirequest");
        $this->db_multi = DB_MULTI::getInstance();
        $this->api_request = new Apirequest($this->db_multi->_db_bullcard,$this->db_multi->_db_buygest);
        $this->_usersAdd = new UsersAdd();
    }
    public function indexAction($params = []){
        // si no esta la session iniciada mandamos al home
        if(!Session::exists(CURRENT_USER_SESSION_NAME)){
            Router::redirect('');
        }
        $users_id = $_SESSION[CURRENT_USER_SESSION_NAME];
        $data = new stdClass();
        $data->users_id = $users_id;
        $api = (object)$this->api_request->get_data_user($data);
        $a_view = [];
        // select users_data
        $a_view["profile_users"] = (object)$this->_usersAdd->get_login_user($users_id);
        //$a_view["refresh"] = false;
        $a_view["refresh"] = false;
        if($api->status){
            $users_data = $api->users_data;
            /*echo "<pre>";
            print_r($users_data);
            print_r($users_data["data"]->entry_firstname);*/
            $a_view["name"] = $users_data["data"]->entry_firstname;
            $a_view["tarjetas"] =  isset($users_data["nums_tarjetas"])?$users_data["nums_tarjetas"]:[];
           
        }
        $this->view->render("perfil/index",$a_view);
    }
    public function editAction(){
        // si no esta la session iniciada mandamos al home
        if(!Session::exists(CURRENT_USER_SESSION_NAME)){
            Router::redirect('');
        } 
        $validation = new Validate();
        $users_id = $_SESSION[CURRENT_USER_SESSION_NAME];
        $data = new stdClass();
        $data->users_id = $users_id;
        $api = (object)$this->api_request->get_data_user($data);
        $a_view = [];
        // select users_data
        $a_view["profile_users"] = (object)$this->_usersAdd->get_login_user($users_id);
        $a_view["back"] = false;
        $a_view["msg"] = "";
        //$a_view["refresh"] = false;
        //echo "<pre>";
        //var_dump($api);
        if($api->status){
            $users_data = $api->users_data;
            /*echo "<pre>";
            print_r($users_data);
            print_r($users_data["data"]->entry_firstname);*/
            $a_view["name"] = $users_data["data"]->entry_firstname;
            $a_view["tarjetas"] = isset($users_data["nums_tarjetas"])?$users_data["nums_tarjetas"]: [];
        
            $a_view["users_data"] = $users_data["data"];
           
        }

        if($_POST){
            //print_r($_POST);
            $data = new stdClass();
            $data->users_id = $users_id;
            $data->name = Input::get('name');
            $data->email = Input::get('email');
            $data->telephone = Input::get('telephone');
            $data->nif = Input::get('nif');
            $data->password_new = Input::get('password_new');
            $data->password_old = Input::get('password_old');
            $data->password_new_check = Input::get('password_new_check');
            $api = (object)$this->api_request->save_data_user($data);
            /*echo gettype($api);
            echo $api->status."<br>";
            */
            //echo " <pre>";
            //print_r($api);
            if($api->status){
                $a_view["msg"] = $api->msg;
                $validation->addError(["Datos actualizados","bg-danger"]);
                $a_view["back"] = true;
            } else {
                $a_view["msg"] = "A ocurrido un error.";
                $validation->addError($api->msg);
                $a_view["back"] = false;
            }
            
            $_POST = array();
        }
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render("perfil/edit",$a_view);

    }
} 