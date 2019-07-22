<?php

class Register extends Controller{
    public $_user,$username;
    public function __construct($controller, $action){
        parent::__construct($controller, $action);
        $this->load_model("Users");//,"findByUserName"
        $this->view->setLayout('default');
        //$this->_user = new Users();
    }

    public function loginAction(){
        $validation = new Validate();
        if($_POST){
            // form validation
            // validation
            $validation->check($_POST,[
                "username" => [
                    "display" => "Username",
                    "required" => true
                ],
                "password" => [
                    "display" => "Password",
                    "required" => true,
                    "min" => 5
                ]
            ]);
            //$validation = true;
            if($validation->passed()){
              $user = $this->UsersModel->findByUserName($_POST['username']);
              //dnd($user);
         
              if($user && password_verify(Input::get('password'),$user->password)){
                $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                $user->login($remember);
                Router::redirect('');
              } else {
                $validation->addError("Error con el usuario o contraseña"); 
              }
            }
        }
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('register/login');
    }

    public function bak_loginAction(){
        echo password_hash('coco00',PASSWORD_DEFAULT);
        
        $validation = new Validate();
        if($_POST){

            // validation
            $validation->check($_POST,[
                "username" => [
                    "display" => "Username",
                    "required" => true
                ],
                "password" => [
                    "display" => "Password",
                    "required" => true,
                    "min" => 5
                ]
            ]);
            //$validation = true;
            if($validation->passed()){

                //var_dump(($_POST));die('Register');
                print_r($_POST['username']);

                $this->UsersModel->findByUserName($_POST['username']);

                $user = $this->UsersModel->_userData;
                //var_dump($this->UsersModel);
                //var_dump($user);
                //echo "<br>";
                //echo $user->username;
                //echo "<br>";
                //echo $user->password;
                //die("User por fin");
                //$this->_user->findByUserName($_POST['username']);
                //var_dump($this->_user->_userData);
                //var_dump($this->_userData);
                //die('AFTERVALID');
                //$user =$this->user->findByUserName($_POST['username']);
                var_dump($this->UsersModel->findByUserName($_POST['username']));
                /*if($user)
                {
                    $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                    $user->login($remember);
                    Router::redirect(''); 
                }*/
                //print_r($user);
                if($user && password_verify(Input::get('password'),$user->password)){
                    //echo "redirect";
                    $remember = (isset($_POST['remember_me']) && Input::get('remember_me')) ? true : false;
                    $this->UsersModel->login($remember);
                    //Router::redirect(PROOT.'/home/index');
                   //Router::redirect('');
                } else {
                    $validation->addError("Error con el usuario o contraseña");
                }
            } 
        }
        $this->view->displayErrors = $validation->displayErrors();
        $this->view->render('register/login');
    }
    public function logoutAction(){
        if(curentUser()){
            curentUser()->logout();
        }
        Router::redirect("register/login");
    }
}