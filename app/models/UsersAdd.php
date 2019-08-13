<?php

class UsersAdd {
    private $_table = "";
    private $_db_bullcard = null;
    private $_db_buygest = null;
    
    public function __construct(){
        $this->_table = "users";
        // instanciamos la db_muli para poder insertar en la s dos tablas
        $this->db_multi = DB_MULTI::getInstance();
        //instanciamos las dos base de datos par poder usarlas
        $this->_db_bullcard = $this->db_multi->_db_bullcard;
        $this->_db_buygest = $this->db_multi->_db_buygest;
    }
    public function update_users_column($column, $users_id, $value){
        //print_r(["column"=>$column, "users_id"=>$users_id,"value"=>$value]);
        if($column != "" && $users_id != "" && $value != ""){
            //actualizamos datos en la tabla users
            $sql_users_upd = $this->_db_bullcard->prepare("UPDATE {$this->_table} SET {$column} = :{$column} WHERE users_id = :users_id");
            $sql_users_upd->bindParam(":{$column}", $value, PDO::PARAM_STR);
            $sql_users_upd->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $res_users_upd = $sql_users_upd->execute();
             //= $sql_users_upd->fetchAll(PDO::FETCH_OBJ);
            //print_r($res_users_upd);
            if($res_users_upd){
                return true;
            }
        }
        return false;
    }
    public function insert_from_google($data = []){
        if(!empty($data)){
            //print_r($data->profile);
            $service_id = $data->profile->Eea;
            $email = $data->profile->U3;
            $name = $data->profile->ig;
            $url_img_perfile = $data->profile->Paa;
            $sql_insert_users = $this->_db_bullcard->prepare("INSERT INTO users(email, token, login_type_id, service_id, url_img_profile) VALUES(?,?,?,?,?)");
            $sql_insert_users->execute([$email, $data->service_token, 2, $service_id, $url_img_perfile]);
            $users_id = $this->_db_bullcard->lastInsertId();
            // si tenemos el users_id sequimos
            if($users_id){
                $address_book_id = $this->insert_user_buygest($email,$name);
                if($address_book_id){
                    $this->update_users_column("address_book_id", $users_id, $address_book_id);
                    $res_steps = $this->stepsCounts($users_id);

                }
                return $users_id;
            }
        }
        return false;

    }
    /**
     * Insertamos el usuarion en la tabla _address_book de buygest
     */
    public function insert_user_buygest($email,$name){
        if($email != "" && $name != ""){
            $sql_addres = $this->_db_buygest->prepare("INSERT INTO _address_book(entry_emailE, entry_firstname, IDCLIENTE, countries_id) VALUES(?,?,?,?)");
            $sql_addres->execute([$email, $name, 127, 1]);
            $address_book_id = $this->_db_buygest->lastInsertId();
            if($address_book_id){
                return $address_book_id;
            }
        }
        return false;
    }
    /**
     * insertamos el paso dos del proceso de login
     */
    public function stepsCounts($users_id){
        if($users_id){
            // evidencia de los pasoso
            $sql_pasos_insert = $this->_db_bullcard->prepare("INSERT INTO users_steps(users_id, step) VALUES(?,?)");
            $sql_pasos_insert->execute([$users_id, 1]);
            return true;
        }
        return false;
    }
    /**
     * buscmos en que paso se ha quedado el usuario
     */
    public function usersSteps($users_id){
        if($users_id > 0){
            //buscamos si el proceso de registracion esta completado o amedias
            $sql_register_step = $this->_db_bullcard->prepare("SELECT step FROM users_steps WHERE users_id = :users_id");
            $sql_register_step->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $sql_register_step->execute();
            $res_register_step = $sql_register_step->fetchAll(PDO::FETCH_OBJ);
            if($res_register_step){
                $step = $res_register_step[0]->step;
                return $step;
            }
        }
        return null;
    }
    /**
     * insertamos datos desde facebook
     */
    public function insert_from_facebook($data = []){
        if(!empty($data)){
            //print_r($data->profile);
            $service_id = $data->profile->id;
            $email = $data->profile->email;
            $name = $data->profile->name;
            $url_img_perfile = $data->profile->picture->data->url;
            $sql_insert_users = $this->_db_bullcard->prepare("INSERT INTO users(email, token, login_type_id, service_id, url_img_profile) VALUES(?,?,?,?,?)");
            $sql_insert_users->execute([$email, $data->service_token, 3, $service_id, $url_img_perfile]);
            $users_id = $this->_db_bullcard->lastInsertId();
            // si tenemos el users_id sequimos
            if($users_id){
                $address_book_id = $this->insert_user_buygest($email,$name);
                if($address_book_id){
                    $this->update_users_column("address_book_id", $users_id, $address_book_id);
                    $res_steps = $this->stepsCounts($users_id);

                }
                return $users_id;
            }
        }
        return false;

    }
    /**
     * insertamos usuario desde Twitter
     */
    public function insert_from_twitter($data = []){
        if(!empty($data)){
            //print_r($data->profile);
            $service_id = $data->profile->uid;
            $email = $data->profile->email;
            $name = $data->profile->displayName;
            $url_img_perfile = $data->profile->photoURL;
            $sql_insert_users = $this->_db_bullcard->prepare("INSERT INTO users(email, token, login_type_id, service_id, url_img_profile) VALUES(?,?,?,?,?)");
            $sql_insert_users->execute([$email, $data->service_token, 4, $service_id, $url_img_perfile]);
            $users_id = $this->_db_bullcard->lastInsertId();
            // si tenemos el users_id sequimos
            if($users_id){
                $address_book_id = $this->insert_user_buygest($email,$name);
                if($address_book_id){
                    $this->update_users_column("address_book_id", $users_id, $address_book_id);
                    $res_steps = $this->stepsCounts($users_id);

                }
                return $users_id;
            }
        }
        return false;
    }
    /**
     * guardar los intentos de insertar la tarjeta
     */
    public function insert_attempts($users_id){
        $msg = "";
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //echo "$ip --- $users_id";
        if($users_id && $ip){
            // guardamos los instentos en la tabla users_ attempts
            if(SESSION::exists(CURRENT_USER_SESSION_NAME)){
                $session = SESSION::get(CURRENT_USER_SESSION_NAME);
            } else {
                $session = false;
            }
            //echo "session: $session";
            $sql_users_attempts = $this->_db_bullcard->prepare("INSERT INTO users_attempts(users_id, ip, session) VALUES(?,?,?)");
            $res_users_attempts = $sql_users_attempts->execute([$users_id, $ip, $session]);
            if(isset($sql_users_attempts->errorInfo()[2])){
                return ($sql_users_attempts->errorInfo()[2]);
            }
        
            if($res_users_attempts){
                $msg = "Insertado el intento de registrar tarjeta.";
            }
            return $msg;
        }
        return false;
    }
    /**
     * buscamos los intentos de guardar tarjeta
     */
    public function find_users_attempts($users_id){
        if($users_id){
            // uscamos los numero de veces que se a intentado guardar la tarjeta
            $sql_users_attempts_count = $this->_db_bullcard->prepare("SELECT * FROM users_attempts WHERE users_id = :users_id");
            $sql_users_attempts_count->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $sql_users_attempts_count->execute();
            $res_users_attempts_count = $sql_users_attempts_count->fetchAll(PDO::FETCH_OBJ);
            $num_attempts = count($res_users_attempts_count);
            return $num_attempts;
        }
        return false;
    }
    /**
    * cojemos datos del usuario para el botton login foto perfil, email, name
    */
    public function get_login_user($users_id){
        if($users_id > 0){
            //buscamos datos del usuario
            $sql_users = $this->_db_bullcard->prepare("SELECT email, url_img_profile, address_book_id FROM users WHERE users_id = :users_id");
            $sql_users->bindParam(":users_id", $users_id, PDO::PARAM_INT);
            $sql_users->execute();
            $res_users = $sql_users->fetchAll(PDO::FETCH_OBJ);
            $name = "";
            $email = "";
            $url_img_profile = "";
            //print_r($res_users);
            if($res_users){
                $address_book_id = $res_users[0]->address_book_id;
                $email = $res_users[0]->email;
                $url_img_profile = $res_users[0]->url_img_profile;
                if($address_book_id > 0){
                    //buscamos el nombre
                    $sql_address = $this->_db_buygest->prepare("SELECT entry_firstname FROM _address_book WHERE address_book_id = :address_book_id");
                    $sql_address->bindParam(":address_book_id", $address_book_id,PDO::PARAM_INT);
                    $sql_address->execute();
                    $res_address = $sql_address->fetchAll(PDO::FETCH_OBJ);
                    if($res_address){
                        $name = $res_address[0]->entry_firstname;
                    }
                }
            }
            return ["name" => $name, "email" => $email, "url_img_profile" => $url_img_profile];
        }
        return false;
    }
}