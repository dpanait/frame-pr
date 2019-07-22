<?php

class Users extends Model{
    private $_isLoggedIn, $_sessionName, $_cookieName;
    public $_userData;
    public static $currentLoggedInUser = null;

    public function __construct($user=''){
        /*echo "<pre>";
        var_dump($user);
        echo "</pre>";*/
        $table = "users";
        parent::__construct($table);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;
        //echo "USER: " .$user;
        if($user !='' /*&& $user !="users"*/){
            if(is_int($user)){
                $u = $this->_db->findFirst('users',['conditions'=>'id = ?','bind'=>[$user]]);
                //echo "User_RES_INT: <br>";
                //print_r($u);
            }
            else{
                $u = $this->_db->findFirst('users',['conditions'=>'username = ?','bind'=>[$user]]);
                //echo "User_RES_String: <br>";
                //print_r($u);
            }
            if($u){
                //echo "VAR U<br>";
                //print_r($u);
                foreach($u as $key=>$val){
                    //echo $key."<br>";
                    //echo $val."<br>";
                    $this->$key = $val;
                }
            }
        }
        //echo "<pre>";
        //print_r($this);
        //echo "</pre>";
        //var_dump($this);
    }


    public function findByUserName($username){
        return $this->findFirst(['conditions'=>'username = ?','bind'=>[$username]]);
    }
    public static function currentLoggedInUser(){
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $U = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $U;
        }
        return self::$currentLoggedInUser;
    }

    public function login($rememberMe = false){
        //print_r($this);
        //print_r($this->id);
        //var_dump($data);
        //dnd("User");
        Session::set($this->_sessionName,$this->id);
        if($rememberMe){
            $hash = md5((int)uniqid() + rand(0, 100) );
            $user_agent = Session::uagent_no_version();
            Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
            $fields =['session'=>$hash,'user_agent'=>$user_agent,'user_id'=>$this->id];
            //print_r($fields);
            // borrar session
            $this->_db->query("DELETE FROM users_session WHERE user_id = ? AND user_agent = ?",[$this->id, $user_agent]);
            //insertar la session
            $this->_db->insert("users_session",$fields);
        }
    }
    public function logout(){
        $user_agent = Session::uagent_no_version();
        //var_dump($this->id);
        //var_dump($this->_db);
        $this->_db->query("DELETE FROM users_session WHERE user_id = ? AND user_agent = ?",[$this->id,$user_agent]);
        Session::delete(CURRENT_USER_SESSION_NAME);
        if(Cookie::exists(REMEMBER_ME_COOKIE_NAME)){
            Cookie::delete(REMEMBER_ME_COOKIE_NAME);
        }
        self::$currentLoggedInUser = null;
        return true;
    }
    public static function loginFromCookie(){
        $user_session_model = new UserSession();
        $user_session = $user_session_model->findFirst([
            "conditions"=>"user_agent = ? AND session = ?",
            "bind" =>[Session::uagent_no_version(),Cookie::get(REMEMBER_ME_COOKIE_NAME)]
        ]);
        if($user_session->user_id != ""){
            $user = new self((int)$user_session->user_id);
        }
        $user->login();
        return $user;
    }
    public function populateObjData($result){
        $data = new stdClass();
        foreach($result as $key => $val){
            //print_r($val);
            //echo PHP_EOL;
            $this->$key = $val;
            $data->$key = $val;
        }
        //var_dump($data);
        //die("populate");
       
        return $data;
    }
}
