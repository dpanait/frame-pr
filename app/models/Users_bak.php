<?php

class Users extends Model{
    private $_isLoggedIn, $_sessionName, $_cookieName;
    public $_userData;
    public static $currentLoggedInUser = null;

    public function __construct($user=''){
        //echo "<pre>";
        //var_dump($user);
       // echo "</pre>";
        $table = "users";
        parent::__construct($table);
        $this->_sessionName = CURRENT_USER_SESSION_NAME;
        $this->_cookieName = REMEMBER_ME_COOKIE_NAME;
        $this->_softDelete = true;
        //echo "USER: " .$user;
        if($user !='' && $user !="users"){
            if(is_int($user)){
                $u = $this->_db->findFirst('users',['conditions'=>'id = ?','bind'=>[$user]]);
            }
            else{
                $u = $this->_db->findFirst('users',['conditions'=>'username = ?','bind'=>[$user]]);
            }
            if($u){
                //print_r($u);
                foreach($u as $key=>$val){
                    //echo $val;
                    $this->$key = $val;
                }
            }
        }
        
       // var_dump($this);
    }


    public function findByUserName($username){
        //echo "AAAA: ".$username.PHP_EOL;
        //var_dump($this->findFirst(['conditions'=>'username = ?','bind'=>[$username]]));
        //return 
       //$result = $this->findFirst(['conditions'=>'username = ?','bind'=>[$username]]);
       //$this->populateObjData($result);
        // esto funciona
        $this->_userData = $this->findFirst(['conditions'=>'username = ?','bind'=>[$username]]);
        //var_dump($this->_userData);
        //die("findByUserName");
        //return 
    }
    public static function currentLoggedInUser(){
        if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME)) {
            $U = new Users((int)Session::get(CURRENT_USER_SESSION_NAME));
            self::$currentLoggedInUser = $U;
        }
        return self::$currentLoggedInUser;
    }

    public function login($rememberMe = false){
        Session::set($this->_sessionName,$this->_userData->id);
        if($rememberMe){
            $hash = md5((int)uniqid() + rand(0, 100) );
            $user_agent = Session::uagent_no_version();
            Cookie::set($this->_cookieName, $hash, REMEMBER_COOKIE_EXPIRY);
            echo "user_user: ".$this->id;
            $fields =['session'=>$hash,'user_agent'=>$user_agent,'user_id'=>$this->_userData->id];
            // borrar session
            $this->_db->query("DELETE FROM users_session WHERE user_id = ? AND user_agent = ?",[$this->_userData->id, $user_agent]);
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
    public function populateObjData($result){
        $data = new stdClass();
        foreach($result as $key => $val){
            $this->$key = $val;
            $data->$key = $val;
        }
        
        return $data;
    }
}
